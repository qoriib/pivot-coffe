<?php

namespace App\Http\Controllers\Customer;

use App\Http\Controllers\Controller;
use App\Models\CafeTable;
use App\Models\Menu;
use Illuminate\Http\Request;

class CartController extends Controller
{
    private function getCartKey(int $tableId): string
    {
        return 'cart_' . $tableId;
    }

    public function add(Request $request, string $qrToken)
    {
        $table = CafeTable::where('qr_token', $qrToken)->firstOrFail();
        $request->validate([
            'menu_id'  => 'required|exists:menus,id',
            'quantity' => 'required|integer|min:1',
        ]);

        $menu = Menu::findOrFail($request->menu_id);

        if (!$menu->is_available) {
            return back()->with('error', 'Menu tidak tersedia.');
        }

        $cartKey = $this->getCartKey($table->id);
        $cart = session($cartKey, []);

        $menuId = (string) $menu->id;
        if (isset($cart[$menuId])) {
            $cart[$menuId]['quantity'] += (int) $request->quantity;
        } else {
            $cart[$menuId] = [
                'name'       => $menu->name,
                'quantity'   => (int) $request->quantity,
                'unit_price' => (float) $menu->price,
            ];
        }

        session([$cartKey => $cart]);

        return back()->with('success', "\"{$menu->name}\" ditambahkan ke keranjang.");
    }

    public function update(Request $request, string $qrToken)
    {
        $table = CafeTable::where('qr_token', $qrToken)->firstOrFail();
        $request->validate([
            'menu_id'  => 'required|exists:menus,id',
            'quantity' => 'required|integer|min:1',
        ]);

        $cartKey = $this->getCartKey($table->id);
        $cart = session($cartKey, []);
        $menuId = (string) $request->menu_id;

        if (isset($cart[$menuId])) {
            $cart[$menuId]['quantity'] = (int) $request->quantity;
            session([$cartKey => $cart]);
        }

        return back()->with('success', 'Keranjang diperbarui.');
    }

    public function remove(Request $request, string $qrToken)
    {
        $table = CafeTable::where('qr_token', $qrToken)->firstOrFail();
        $request->validate(['menu_id' => 'required|exists:menus,id']);

        $cartKey = $this->getCartKey($table->id);
        $cart = session($cartKey, []);
        $menuId = (string) $request->menu_id;

        unset($cart[$menuId]);
        session([$cartKey => $cart]);

        return back()->with('success', 'Item dihapus dari keranjang.');
    }

    public function clear(string $qrToken)
    {
        $table = CafeTable::where('qr_token', $qrToken)->firstOrFail();
        session()->forget('cart_' . $table->id);
        return back()->with('success', 'Keranjang dikosongkan.');
    }
}
