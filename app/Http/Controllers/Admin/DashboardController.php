<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\WaiterCall;
use App\Models\Category;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    public function index(Request $request)
    {
        // ── Filter periode pemasukan ──────────────────────────────
        $period = $request->get('period', '30');

        if ($period === 'custom') {
            $startDate = $request->filled('start_date')
                ? Carbon::parse($request->start_date)->startOfDay()
                : Carbon::now()->subDays(30)->startOfDay();
            $endDate = $request->filled('end_date')
                ? Carbon::parse($request->end_date)->endOfDay()
                : Carbon::now()->endOfDay();
        } elseif ($period === '7') {
            $startDate = Carbon::now()->subDays(7)->startOfDay();
            $endDate   = Carbon::now()->endOfDay();
        } elseif ($period === '1') {
            $startDate = Carbon::today()->startOfDay();
            $endDate   = Carbon::today()->endOfDay();
        } else {
            $startDate = Carbon::now()->subDays(30)->startOfDay();
            $endDate   = Carbon::now()->endOfDay();
        }

        // ── Statistik pemasukan ───────────────────────────────────
        $revenueQuery = Order::where('payment_status', 'paid')
            ->whereNotIn('order_status', ['dibatalkan'])
            ->whereBetween('created_at', [$startDate, $endDate]);

        $totalRevenue = (clone $revenueQuery)->sum('total');
        $totalOrders  = (clone $revenueQuery)->count();

        $todayRevenue = Order::where('payment_status', 'paid')
            ->whereNotIn('order_status', ['dibatalkan'])
            ->whereDate('created_at', Carbon::today())
            ->sum('total');

        // ── Stat cards real-time ──────────────────────────────────
        $activeOrders       = Order::whereIn('order_status', ['menunggu', 'diproses'])->count();
        $pendingPayments    = Order::where('payment_status', 'pending')
            ->whereNotIn('order_status', ['dibatalkan'])->count();
        $pendingWaiterCalls = WaiterCall::where('status', 'pending')->count();
        $waiterCalls        = WaiterCall::with('table')->where('status', 'pending')->latest()->get();

        // ── Menu terlaris (all time, top 1 per kategori utama) ────
        // Top menu keseluruhan
        $topMenuOverall = OrderItem::select('menu_id', DB::raw('SUM(quantity) as total_qty'))
            ->groupBy('menu_id')
            ->orderByDesc('total_qty')
            ->with('menu.category')
            ->first();

        // Top menu kategori Kopi
        $topKopi = OrderItem::select('order_items.menu_id', DB::raw('SUM(order_items.quantity) as total_qty'))
            ->join('menus', 'menus.id', '=', 'order_items.menu_id')
            ->join('categories', 'categories.id', '=', 'menus.category_id')
            ->where('categories.name', 'like', '%Kopi%')
            ->groupBy('order_items.menu_id')
            ->orderByDesc('total_qty')
            ->with('menu')
            ->first();

        // Top menu Makanan
        $topMakanan = OrderItem::select('order_items.menu_id', DB::raw('SUM(order_items.quantity) as total_qty'))
            ->join('menus', 'menus.id', '=', 'order_items.menu_id')
            ->join('categories', 'categories.id', '=', 'menus.category_id')
            ->where('categories.name', 'like', '%Makanan%')
            ->groupBy('order_items.menu_id')
            ->orderByDesc('total_qty')
            ->with('menu')
            ->first();

        // Top menu Minuman (non-kopi + minuman dingin)
        $topMinuman = OrderItem::select('order_items.menu_id', DB::raw('SUM(order_items.quantity) as total_qty'))
            ->join('menus', 'menus.id', '=', 'order_items.menu_id')
            ->join('categories', 'categories.id', '=', 'menus.category_id')
            ->whereIn('categories.name', ['Non-Kopi', 'Minuman Dingin'])
            ->groupBy('order_items.menu_id')
            ->orderByDesc('total_qty')
            ->with('menu')
            ->first();

        // ── Peringkat kategori terlaris ───────────────────────────
        $topCategories = Category::select('categories.id', 'categories.name',
                DB::raw('SUM(order_items.quantity) as total_qty'))
            ->join('menus', 'menus.category_id', '=', 'categories.id')
            ->join('order_items', 'order_items.menu_id', '=', 'menus.id')
            ->groupBy('categories.id', 'categories.name')
            ->orderByDesc('total_qty')
            ->get();

        // ── Peringkat menu terlaris (top 10 gabungan semua kategori) ──
        $topMenus = OrderItem::select('order_items.menu_id',
                DB::raw('SUM(order_items.quantity) as total_qty'))
            ->join('menus', 'menus.id', '=', 'order_items.menu_id')
            ->groupBy('order_items.menu_id')
            ->orderByDesc('total_qty')
            ->limit(10)
            ->with('menu.category')
            ->get();

        // ── Status per meja ───────────────────────────────────────
        // Ambil semua meja beserta pesanan aktif terakhirnya
        $tableStatuses = \App\Models\CafeTable::orderBy('number')
            ->with(['orders' => function ($q) {
                $q->whereNotIn('order_status', ['selesai', 'dibatalkan'])
                  ->latest()
                  ->limit(1);
            }])
            ->get();

        return view('admin.dashboard', compact(
            'activeOrders', 'pendingPayments', 'pendingWaiterCalls', 'waiterCalls',
            'totalRevenue', 'totalOrders', 'todayRevenue',
            'period', 'startDate', 'endDate',
            'topMenuOverall', 'topKopi', 'topMakanan', 'topMinuman',
            'topCategories', 'topMenus',
            'tableStatuses'
        ));
    }
}
