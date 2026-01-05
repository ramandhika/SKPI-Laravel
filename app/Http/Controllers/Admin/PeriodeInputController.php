<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\PeriodeInput;
use Illuminate\Http\Request;

class PeriodeInputController extends Controller
{
    public function index()
    {
        $periodes = PeriodeInput::latest()->paginate(20);
        return view('admin.periode.index', compact('periodes'));
    }

    public function create()
    {
        return view('admin.periode.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'nama' => 'required|string|max:255',
            'tanggal_mulai' => 'required|date',
            'tanggal_selesai' => 'required|date|after_or_equal:tanggal_mulai',
            'is_active' => 'boolean',
        ]);

        $validated['is_active'] = $request->has('is_active');

        PeriodeInput::create($validated);

        return redirect()->route('admin.periode.index')
            ->with('success', 'Periode berhasil ditambahkan');
    }

    public function edit(PeriodeInput $periode)
    {
        return view('admin.periode.edit', compact('periode'));
    }

    public function update(Request $request, PeriodeInput $periode)
    {
        $validated = $request->validate([
            'nama' => 'required|string|max:255',
            'tanggal_mulai' => 'required|date',
            'tanggal_selesai' => 'required|date|after_or_equal:tanggal_mulai',
            'is_active' => 'boolean',
        ]);

        $validated['is_active'] = $request->has('is_active');

        $periode->update($validated);

        return redirect()->route('admin.periode.index')
            ->with('success', 'Periode berhasil diupdate');
    }

    public function destroy(PeriodeInput $periode)
    {
        $periode->delete();

        return redirect()->route('admin.periode.index')
            ->with('success', 'Periode berhasil dihapus');
    }

    public function toggleActive(PeriodeInput $periode)
    {
        $periode->update(['is_active' => !$periode->is_active]);

        return redirect()->route('admin.periode.index')
            ->with('success', 'Status periode berhasil diubah');
    }
}
