<?php

namespace App\Http\Controllers\Dosen;

use App\Http\Controllers\Controller;
use App\Models\SkpiMahasiswa;
use App\Models\User;
use App\Models\ProgramStudi;
use Illuminate\Http\Request;

class SkpiReviewController extends Controller
{
    public function index(Request $request)
    {
        $user = auth()->user();
        
        // Get program studi that this dosen is responsible for
        $programStudi = ProgramStudi::where('dosen_id', $user->id)->first();
        
        if (!$programStudi) {
            return view('dosen.skpi.no-prodi');
        }

        // Get mahasiswa from this program studi
        $mahasiswaIds = User::where('role', 'mahasiswa')
            ->where('program_studi_id', $programStudi->id)
            ->pluck('id');

        $query = SkpiMahasiswa::whereIn('user_id', $mahasiswaIds)
            ->with(['user', 'kategori', 'subKategori', 'reviewer']);

        // Filter by status
        if ($request->filled('status')) {
            $query->where('status', $request->status);
        } else {
            // Default: show submitted items
            $query->where('status', 'submitted');
        }

        // Search by NIM or name
        if ($request->filled('search')) {
            $query->whereHas('user', function($q) use ($request) {
                $q->where('nim', 'like', '%' . $request->search . '%')
                  ->orWhere('name', 'like', '%' . $request->search . '%');
            });
        }

        $skpis = $query->latest()->paginate(20);

        return view('dosen.skpi.index', compact('skpis', 'programStudi'));
    }

    public function show(SkpiMahasiswa $skpi)
    {
        $user = auth()->user();
        
        // Check if this dosen can review this SKPI
        $programStudi = ProgramStudi::where('dosen_id', $user->id)->first();
        
        if (!$programStudi || $skpi->user->program_studi_id !== $programStudi->id) {
            abort(403, 'Anda tidak memiliki akses untuk mereview SKPI ini');
        }

        $skpi->load(['user', 'kategori', 'subKategori', 'reviewer']);

        return view('dosen.skpi.show', compact('skpi'));
    }

    public function review(Request $request, SkpiMahasiswa $skpi)
    {
        $user = auth()->user();
        
        // Check if this dosen can review this SKPI
        $programStudi = ProgramStudi::where('dosen_id', $user->id)->first();
        
        if (!$programStudi || $skpi->user->program_studi_id !== $programStudi->id) {
            abort(403, 'Anda tidak memiliki akses untuk mereview SKPI ini');
        }

        $validated = $request->validate([
            'status' => 'required|in:accepted,rejected',
            'catatan_dosen' => 'nullable|string',
        ]);

        $skpi->update([
            'status' => $validated['status'],
            'catatan_dosen' => $validated['catatan_dosen'],
            'reviewed_by' => $user->id,
            'reviewed_at' => now(),
        ]);

        $message = $validated['status'] === 'accepted' 
            ? 'SKPI berhasil disetujui' 
            : 'SKPI ditolak';

        return redirect()->route('dosen.skpi.index')
            ->with('success', $message);
    }

    public function bulkReview(Request $request)
    {
        $user = auth()->user();
        
        $validated = $request->validate([
            'skpi_ids' => 'required|array',
            'skpi_ids.*' => 'exists:skpi_mahasiswas,id',
            'status' => 'required|in:accepted,rejected',
            'catatan_dosen' => 'nullable|string',
        ]);

        // Get program studi that this dosen is responsible for
        $programStudi = ProgramStudi::where('dosen_id', $user->id)->first();
        
        if (!$programStudi) {
            return redirect()->route('dosen.skpi.index')
                ->with('error', 'Anda tidak terdaftar sebagai pengelola program studi');
        }

        // Get mahasiswa from this program studi
        $mahasiswaIds = User::where('role', 'mahasiswa')
            ->where('program_studi_id', $programStudi->id)
            ->pluck('id');

        // Update only SKPI that belongs to mahasiswa in this program studi
        SkpiMahasiswa::whereIn('id', $validated['skpi_ids'])
            ->whereIn('user_id', $mahasiswaIds)
            ->update([
                'status' => $validated['status'],
                'catatan_dosen' => $validated['catatan_dosen'],
                'reviewed_by' => $user->id,
                'reviewed_at' => now(),
            ]);

        $message = $validated['status'] === 'accepted' 
            ? 'SKPI yang dipilih berhasil disetujui' 
            : 'SKPI yang dipilih ditolak';

        return redirect()->route('dosen.skpi.index')
            ->with('success', $message);
    }

    public function dashboard()
    {
        $user = auth()->user();
        
        // Get program studi that this dosen is responsible for
        $programStudi = ProgramStudi::where('dosen_id', $user->id)->first();
        
        if (!$programStudi) {
            return view('dosen.dashboard-no-prodi');
        }

        // Get mahasiswa from this program studi
        $mahasiswaIds = User::where('role', 'mahasiswa')
            ->where('program_studi_id', $programStudi->id)
            ->pluck('id');

        $totalSkpi = SkpiMahasiswa::whereIn('user_id', $mahasiswaIds)->count();
        $submittedSkpi = SkpiMahasiswa::whereIn('user_id', $mahasiswaIds)->where('status', 'submitted')->count();
        $acceptedSkpi = SkpiMahasiswa::whereIn('user_id', $mahasiswaIds)->where('status', 'accepted')->count();
        $rejectedSkpi = SkpiMahasiswa::whereIn('user_id', $mahasiswaIds)->where('status', 'rejected')->count();

        $recentSkpi = SkpiMahasiswa::whereIn('user_id', $mahasiswaIds)
            ->with(['user', 'kategori', 'subKategori'])
            ->latest()
            ->take(10)
            ->get();

        return view('dosen.dashboard', compact(
            'programStudi',
            'totalSkpi',
            'submittedSkpi',
            'acceptedSkpi',
            'rejectedSkpi',
            'recentSkpi'
        ));
    }
}
