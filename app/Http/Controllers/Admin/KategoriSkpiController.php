<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\KategoriSkpi;
use App\Models\SubKategoriSkpi;
use Illuminate\Http\Request;

class KategoriSkpiController extends Controller
{
    public function index()
    {
        $kategoris = KategoriSkpi::withCount('subKategori')->latest()->paginate(20);
        return view('admin.kategori.index', compact('kategoris'));
    }

    public function create()
    {
        return view('admin.kategori.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'nama' => 'required|string|max:255',
            'nama_en' => 'nullable|string|max:255',
            'nilai' => 'required|integer|min:0',
            'deskripsi' => 'nullable|string',
        ]);

        KategoriSkpi::create($validated);

        return redirect()->route('admin.kategori.index')
            ->with('success', 'Kategori berhasil ditambahkan');
    }

    public function edit(KategoriSkpi $kategori)
    {
        return view('admin.kategori.edit', compact('kategori'));
    }

    public function update(Request $request, KategoriSkpi $kategori)
    {
        $validated = $request->validate([
            'nama' => 'required|string|max:255',
            'nama_en' => 'nullable|string|max:255',
            'nilai' => 'required|integer|min:0',
            'deskripsi' => 'nullable|string',
        ]);

        $kategori->update($validated);

        return redirect()->route('admin.kategori.index')
            ->with('success', 'Kategori berhasil diupdate');
    }

    public function destroy(KategoriSkpi $kategori)
    {
        $kategori->delete();

        return redirect()->route('admin.kategori.index')
            ->with('success', 'Kategori berhasil dihapus');
    }

    // Sub Kategori methods
    public function showSubKategori(KategoriSkpi $kategori)
    {
        $subKategoris = $kategori->subKategori()->latest()->paginate(20);
        return view('admin.kategori.sub-kategori', compact('kategori', 'subKategoris'));
    }

    public function storeSubKategori(Request $request, KategoriSkpi $kategori)
    {
        $validated = $request->validate([
            'nama' => 'required|string|max:255',
            'nama_en' => 'nullable|string|max:255',
            'deskripsi' => 'nullable|string',
        ]);

        $kategori->subKategori()->create($validated);

        return redirect()->route('admin.kategori.sub-kategori', $kategori)
            ->with('success', 'Sub kategori berhasil ditambahkan');
    }

    public function updateSubKategori(Request $request, KategoriSkpi $kategori, SubKategoriSkpi $subKategori)
    {
        $validated = $request->validate([
            'nama' => 'required|string|max:255',
            'nama_en' => 'nullable|string|max:255',
            'deskripsi' => 'nullable|string',
        ]);

        $subKategori->update($validated);

        return redirect()->route('admin.kategori.sub-kategori', $kategori)
            ->with('success', 'Sub kategori berhasil diupdate');
    }

    public function destroySubKategori(KategoriSkpi $kategori, SubKategoriSkpi $subKategori)
    {
        $subKategori->delete();

        return redirect()->route('admin.kategori.sub-kategori', $kategori)
            ->with('success', 'Sub kategori berhasil dihapus');
    }
}
