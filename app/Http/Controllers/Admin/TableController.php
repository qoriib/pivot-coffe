<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\TableRequest;
use App\Models\CafeTable;
use SimpleSoftwareIO\QrCode\Facades\QrCode;

class TableController extends Controller
{
    public function index()
    {
        $tables = \App\Models\CafeTable::orderBy('number')
            ->with(['orders' => function ($q) {
                $q->whereNotIn('order_status', ['selesai', 'dibatalkan'])
                  ->latest()->limit(1);
            }])
            ->paginate(15);

        return view('admin.tables.index', compact('tables'));
    }

    public function store(TableRequest $request)
    {
        CafeTable::create($request->validated());
        return redirect()->route('admin.tables.index')
            ->with('success', 'Meja berhasil ditambahkan.');
    }

    public function update(TableRequest $request, CafeTable $table)
    {
        $table->update(['number' => $request->number]);
        return redirect()->route('admin.tables.index')
            ->with('success', 'Meja berhasil diperbarui.');
    }

    public function destroy(CafeTable $table)
    {
        $table->delete();
        return redirect()->route('admin.tables.index')
            ->with('success', 'Meja berhasil dihapus.');
    }

    public function qr(CafeTable $table)
    {
        $url = route('customer.home', $table);
        $qrCode = QrCode::size(250)->generate($url);
        return view('admin.tables.qr', compact('table', 'qrCode', 'url'));
    }
}
