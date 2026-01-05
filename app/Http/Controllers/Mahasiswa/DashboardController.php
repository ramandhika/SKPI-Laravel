<?php

namespace App\Http\Controllers\Mahasiswa;

use App\Http\Controllers\Controller;
use App\Models\SkpiMahasiswa;
use App\Models\KategoriSkpi;
use App\Models\PeriodeInput;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index()
    {
        $user = auth()->user();
        
        $totalSkpi = SkpiMahasiswa::where('user_id', $user->id)->count();
        $draftSkpi = SkpiMahasiswa::where('user_id', $user->id)->where('status', 'draft')->count();
        $submittedSkpi = SkpiMahasiswa::where('user_id', $user->id)->where('status', 'submitted')->count();
        $acceptedSkpi = SkpiMahasiswa::where('user_id', $user->id)->where('status', 'accepted')->count();
        
        $recentSkpi = SkpiMahasiswa::where('user_id', $user->id)
            ->with(['kategori', 'subKategori'])
            ->latest()
            ->take(5)
            ->get();
        
        $activePeriod = PeriodeInput::where('is_active', true)
            ->where('tanggal_mulai', '<=', now())
            ->where('tanggal_selesai', '>=', now())
            ->first();

        return view('mahasiswa.dashboard', compact(
            'totalSkpi',
            'draftSkpi',
            'submittedSkpi',
            'acceptedSkpi',
            'recentSkpi',
            'activePeriod'
        ));
    }
}
