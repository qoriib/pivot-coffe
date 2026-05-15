<?php

namespace App\Http\Controllers\Customer;

use App\Http\Controllers\Controller;
use App\Models\CafeTable;
use App\Models\Category;
use App\Models\Menu;
use App\Models\OrderItem;
use App\Models\Promo;
use Carbon\Carbon;
use Illuminate\Http\Request;

class MenuController extends Controller
{
    public function index(Request $request, string $qrToken)
    {
        $table = CafeTable::where('qr_token', $qrToken)->firstOrFail();

        // Store table in session
        session(['table_id' => $table->id, 'table_number' => $table->number, 'qr_token' => $qrToken]);

        $categories = Category::orderBy('name')->get();
        $selectedCategory = $request->get('category');
        $search = $request->get('search');

        $menuQuery = Menu::with('category')->where('is_available', true);

        if ($selectedCategory) {
            $menuQuery->whereHas('category', fn($q) => $q->where('slug', $selectedCategory));
        }

        if ($search) {
            $menuQuery->where('name', 'like', '%' . $search . '%');
        }

        $menus = $menuQuery->get();

        // Best sellers: top 3 by total quantity sold
        $bestSellerIds = OrderItem::selectRaw('menu_id, SUM(quantity) as total_qty')
            ->groupBy('menu_id')
            ->orderByDesc('total_qty')
            ->limit(3)
            ->pluck('menu_id');

        $bestSellers = Menu::whereIn('id', $bestSellerIds)
            ->where('is_available', true)
            ->get()
            ->sortBy(fn($m) => $bestSellerIds->search($m->id));

        // Active promos
        $today = Carbon::today();
        $promos = Promo::where('is_active', true)
            ->where('valid_from', '<=', $today)
            ->where('valid_until', '>=', $today)
            ->get();

        $cart = session('cart_' . $table->id, []);

        return view('customer.menu', compact(
            'table', 'categories', 'menus', 'bestSellers',
            'promos', 'cart', 'selectedCategory', 'search'
        ));
    }

    public function show(string $qrToken, Menu $menu)
    {
        $table = CafeTable::where('qr_token', $qrToken)->firstOrFail();
        return view('customer.menu-detail', compact('table', 'menu'));
    }
}
