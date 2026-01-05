<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\SkpiMahasiswa;
use App\Models\KategoriSkpi;
use App\Models\PeriodeInput;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index()
    {
        $totalMahasiswa = User::where('role', 'mahasiswa')->count();
        $totalDosen = User::where('role', 'dosen')->count();
        $totalKategori = KategoriSkpi::count();
        $totalSkpi = SkpiMahasiswa::count();
        
        $skpiByStatus = SkpiMahasiswa::selectRaw('status, count(*) as count')
            ->groupBy('status')
            ->pluck('count', 'status');
        
        $recentSkpi = SkpiMahasiswa::with(['user', 'kategori', 'subKategori'])
            ->latest()
            ->take(10)
            ->get();
        
        $activePeriod = PeriodeInput::where('is_active', true)
            ->where('tanggal_mulai', '<=', now())
            ->where('tanggal_selesai', '>=', now())
            ->first();

        return view('admin.dashboard', compact(
            'totalMahasiswa',
            'totalDosen',
            'totalKategori',
            'totalSkpi',
            'skpiByStatus',
            'recentSkpi',
            'activePeriod'
        ));
    }
}
