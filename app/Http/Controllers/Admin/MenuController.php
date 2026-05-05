<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\MenuRequest;
use App\Models\Category;
use App\Models\Menu;
use Illuminate\Support\Facades\Storage;

class MenuController extends Controller
{
    public function index()
    {
        $menus      = Menu::with('category')->latest()->paginate(15);
        $categories = Category::orderBy('name')->get();

        // ── Card terlaris per kategori ────────────────────────────
        $topMenuOverall = \App\Models\OrderItem::select('menu_id', \Illuminate\Support\Facades\DB::raw('SUM(quantity) as total_qty'))
            ->groupBy('menu_id')->orderByDesc('total_qty')->with('menu.category')->first();

        $topKopi = \App\Models\OrderItem::select('order_items.menu_id', \Illuminate\Support\Facades\DB::raw('SUM(order_items.quantity) as total_qty'))
            ->join('menus', 'menus.id', '=', 'order_items.menu_id')
            ->join('categories', 'categories.id', '=', 'menus.category_id')
            ->where('categories.name', 'like', '%Kopi%')
            ->groupBy('order_items.menu_id')->orderByDesc('total_qty')->with('menu')->first();

        $topMakanan = \App\Models\OrderItem::select('order_items.menu_id', \Illuminate\Support\Facades\DB::raw('SUM(order_items.quantity) as total_qty'))
            ->join('menus', 'menus.id', '=', 'order_items.menu_id')
            ->join('categories', 'categories.id', '=', 'menus.category_id')
            ->where('categories.name', 'like', '%Makanan%')
            ->groupBy('order_items.menu_id')->orderByDesc('total_qty')->with('menu')->first();

        $topMinuman = \App\Models\OrderItem::select('order_items.menu_id', \Illuminate\Support\Facades\DB::raw('SUM(order_items.quantity) as total_qty'))
            ->join('menus', 'menus.id', '=', 'order_items.menu_id')
            ->join('categories', 'categories.id', '=', 'menus.category_id')
            ->whereIn('categories.name', ['Non-Kopi', 'Minuman Dingin'])
            ->groupBy('order_items.menu_id')->orderByDesc('total_qty')->with('menu')->first();

        return view('admin.menus.index', compact(
            'menus', 'categories',
            'topMenuOverall', 'topKopi', 'topMakanan', 'topMinuman'
        ));
    }

    public function store(MenuRequest $request)
    {
        $data = $request->validated();
        $data['is_available'] = $request->boolean('is_available');

        if ($request->hasFile('image')) {
            $data['image'] = $request->file('image')->store('menus', 'public');
        }

        Menu::create($data);

        return redirect()->route('admin.menus.index')
            ->with('success', 'Menu berhasil ditambahkan.');
    }

    public function update(MenuRequest $request, Menu $menu)
    {
        $data = $request->validated();
        $data['is_available'] = $request->boolean('is_available');

        if ($request->hasFile('image')) {
            if ($menu->image) {
                Storage::disk('public')->delete($menu->image);
            }
            $data['image'] = $request->file('image')->store('menus', 'public');
        }

        $menu->update($data);

        return redirect()->route('admin.menus.index')
            ->with('success', 'Menu berhasil diperbarui.');
    }

    public function destroy(Menu $menu)
    {
        if ($menu->image) {
            Storage::disk('public')->delete($menu->image);
        }
        $menu->delete();

        return redirect()->route('admin.menus.index')
            ->with('success', 'Menu berhasil dihapus.');
    }

    public function toggle(Menu $menu)
    {
        $menu->update(['is_available' => !$menu->is_available]);
        $status = $menu->is_available ? 'tersedia' : 'tidak tersedia';
        return back()->with('success', "Menu \"{$menu->name}\" sekarang {$status}.");
    }
}
