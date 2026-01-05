<?php

namespace App\Http\Controllers\Mahasiswa;

use App\Http\Controllers\Controller;
use App\Models\SkpiMahasiswa;
use App\Models\KategoriSkpi;
use App\Models\SubKategoriSkpi;
use App\Models\PeriodeInput;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class SkpiController extends Controller
{
    public function index(Request $request)
    {
        $user = auth()->user();
        $query = SkpiMahasiswa::where('user_id', $user->id)
            ->with(['kategori', 'subKategori', 'reviewer']);

        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        $skpis = $query->latest()->paginate(20);

        return view('mahasiswa.skpi.index', compact('skpis'));
    }

    public function create()
    {
        // Check if there's an active period
        $activePeriod = PeriodeInput::where('is_active', true)
            ->where('tanggal_mulai', '<=', now())
            ->where('tanggal_selesai', '>=', now())
            ->first();

        if (!$activePeriod) {
            return redirect()->route('mahasiswa.skpi.index')
                ->with('error', 'Tidak ada periode input aktif saat ini');
        }

        $kategoris = KategoriSkpi::with('subKategori')->get();
        return view('mahasiswa.skpi.create', compact('kategoris'));
    }

    public function store(Request $request)
    {
        // Check if there's an active period
        $activePeriod = PeriodeInput::where('is_active', true)
            ->where('tanggal_mulai', '<=', now())
            ->where('tanggal_selesai', '>=', now())
            ->first();

        if (!$activePeriod) {
            return redirect()->route('mahasiswa.skpi.index')
                ->with('error', 'Tidak ada periode input aktif saat ini');
        }

        $validated = $request->validate([
            'kategori_skpi_id' => 'required|exists:kategori_skpis,id',
            'sub_kategori_skpi_id' => 'required|exists:sub_kategori_skpis,id',
            'nama_kegiatan' => 'required|string|max:255',
            'nama_kegiatan_en' => 'nullable|string|max:255',
            'attachment_url' => 'required|url',
            'status' => 'required|in:draft,submitted',
        ]);

        // Validate if attachment is publicly accessible
        if (!$this->isUrlPubliclyAccessible($validated['attachment_url'])) {
            return back()->withErrors([
                'attachment_url' => 'Link Google Drive tidak dapat diakses secara publik. Pastikan file sudah di-share dengan "Anyone with the link"'
            ])->withInput();
        }

        $validated['user_id'] = auth()->id();

        SkpiMahasiswa::create($validated);

        $message = $validated['status'] === 'draft' 
            ? 'Data SKPI berhasil disimpan sebagai draft' 
            : 'Data SKPI berhasil disubmit';

        return redirect()->route('mahasiswa.skpi.index')
            ->with('success', $message);
    }

    public function edit(SkpiMahasiswa $skpi)
    {
        // Check if user owns this SKPI
        if ($skpi->user_id !== auth()->id()) {
            abort(403);
        }

        // Check if SKPI is still editable (draft or submitted, not accepted/rejected)
        if (in_array($skpi->status, ['accepted', 'rejected'])) {
            return redirect()->route('mahasiswa.skpi.index')
                ->with('error', 'Data SKPI yang sudah direview tidak dapat diedit');
        }

        $kategoris = KategoriSkpi::with('subKategori')->get();
        return view('mahasiswa.skpi.edit', compact('skpi', 'kategoris'));
    }

    public function update(Request $request, SkpiMahasiswa $skpi)
    {
        // Check if user owns this SKPI
        if ($skpi->user_id !== auth()->id()) {
            abort(403);
        }

        // Check if SKPI is still editable
        if (in_array($skpi->status, ['accepted', 'rejected'])) {
            return redirect()->route('mahasiswa.skpi.index')
                ->with('error', 'Data SKPI yang sudah direview tidak dapat diedit');
        }

        $validated = $request->validate([
            'kategori_skpi_id' => 'required|exists:kategori_skpis,id',
            'sub_kategori_skpi_id' => 'required|exists:sub_kategori_skpis,id',
            'nama_kegiatan' => 'required|string|max:255',
            'nama_kegiatan_en' => 'nullable|string|max:255',
            'attachment_url' => 'required|url',
            'status' => 'required|in:draft,submitted',
        ]);

        // Validate if attachment is publicly accessible
        if (!$this->isUrlPubliclyAccessible($validated['attachment_url'])) {
            return back()->withErrors([
                'attachment_url' => 'Link Google Drive tidak dapat diakses secara publik. Pastikan file sudah di-share dengan "Anyone with the link"'
            ])->withInput();
        }

        $skpi->update($validated);

        $message = $validated['status'] === 'draft' 
            ? 'Data SKPI berhasil diupdate sebagai draft' 
            : 'Data SKPI berhasil disubmit';

        return redirect()->route('mahasiswa.skpi.index')
            ->with('success', $message);
    }

    public function destroy(SkpiMahasiswa $skpi)
    {
        // Check if user owns this SKPI
        if ($skpi->user_id !== auth()->id()) {
            abort(403);
        }

        // Only allow deletion of draft items
        if ($skpi->status !== 'draft') {
            return redirect()->route('mahasiswa.skpi.index')
                ->with('error', 'Hanya data draft yang dapat dihapus');
        }

        $skpi->delete();

        return redirect()->route('mahasiswa.skpi.index')
            ->with('success', 'Data SKPI berhasil dihapus');
    }

    public function getSubKategori($kategoriId)
    {
        $subKategoris = SubKategoriSkpi::where('kategori_skpi_id', $kategoriId)->get();
        return response()->json($subKategoris);
    }

    public function checkUrl(Request $request)
    {
        $url = $request->input('url');
        $isAccessible = $this->isUrlPubliclyAccessible($url);
        
        return response()->json([
            'accessible' => $isAccessible,
            'message' => $isAccessible 
                ? 'Link dapat diakses secara publik' 
                : 'Link tidak dapat diakses. Pastikan file sudah di-share dengan "Anyone with the link"'
        ]);
    }

    private function isUrlPubliclyAccessible($url)
    {
        try {
            // Check if it's a Google Drive link
            if (strpos($url, 'drive.google.com') !== false) {
                $response = Http::timeout(5)->get($url);
                
                // Check if we can access the file (status 200) and it's not a login page
                return $response->successful() && 
                       strpos($response->body(), 'Sign in') === false;
            }
            
            // For other URLs, just check if they're accessible
            $response = Http::timeout(5)->head($url);
            return $response->successful();
        } catch (\Exception $e) {
            return false;
        }
    }
}
