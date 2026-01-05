<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\ProgramStudi;
use App\Models\User;
use Illuminate\Http\Request;

class ProgramStudiController extends Controller
{
    public function index()
    {
        $programStudis = ProgramStudi::with('dosen')->latest()->paginate(20);
        return view('admin.program-studi.index', compact('programStudis'));
    }

    public function create()
    {
        $dosens = User::where('role', 'dosen')->get();
        return view('admin.program-studi.create', compact('dosens'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'kode' => 'required|string|max:10|unique:program_studis,kode',
            'nama' => 'required|string|max:255',
            'nama_en' => 'nullable|string|max:255',
            'dosen_id' => 'nullable|exists:users,id',
        ]);

        ProgramStudi::create($validated);

        return redirect()->route('admin.program-studi.index')
            ->with('success', 'Program studi berhasil ditambahkan');
    }

    public function edit(ProgramStudi $programStudi)
    {
        $dosens = User::where('role', 'dosen')->get();
        return view('admin.program-studi.edit', compact('programStudi', 'dosens'));
    }

    public function update(Request $request, ProgramStudi $programStudi)
    {
        $validated = $request->validate([
            'kode' => 'required|string|max:10|unique:program_studis,kode,' . $programStudi->id,
            'nama' => 'required|string|max:255',
            'nama_en' => 'nullable|string|max:255',
            'dosen_id' => 'nullable|exists:users,id',
        ]);

        $programStudi->update($validated);

        return redirect()->route('admin.program-studi.index')
            ->with('success', 'Program studi berhasil diupdate');
    }

    public function destroy(ProgramStudi $programStudi)
    {
        $programStudi->delete();

        return redirect()->route('admin.program-studi.index')
            ->with('success', 'Program studi berhasil dihapus');
    }
}
