<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\PromoRequest;
use App\Models\Promo;

class PromoController extends Controller
{
    public function index()
    {
        $promos = Promo::latest()->paginate(15);
        return view('admin.promos.index', compact('promos'));
    }

    public function store(PromoRequest $request)
    {
        $data = $request->validated();
        $data['is_active'] = $request->boolean('is_active');
        Promo::create($data);
        return redirect()->route('admin.promos.index')
            ->with('success', 'Promo berhasil ditambahkan.');
    }

    public function update(PromoRequest $request, Promo $promo)
    {
        $data = $request->validated();
        $data['is_active'] = $request->boolean('is_active');
        $promo->update($data);
        return redirect()->route('admin.promos.index')
            ->with('success', 'Promo berhasil diperbarui.');
    }

    public function destroy(Promo $promo)
    {
        $promo->delete();
        return redirect()->route('admin.promos.index')
            ->with('success', 'Promo berhasil dihapus.');
    }
}
