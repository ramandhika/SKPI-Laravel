<p class="px-4 text-xs font-semibold text-slate-500 uppercase tracking-wider mb-2 mt-4">Menu Dosen</p>

<a href="{{ route('dosen.dashboard') }}"
    class="flex items-center gap-3 px-4 py-3 text-sm font-medium rounded-xl transition-all duration-200 
   {{ request()->routeIs('dosen.dashboard') ? 'bg-indigo-600 text-white shadow-lg shadow-indigo-500/30' : 'text-slate-400 hover:bg-slate-800 hover:text-white' }}">
    <i class="fas fa-home w-5 text-center"></i>
    <span>Dashboard</span>
</a>

<a href="{{ route('dosen.skpi.index') }}"
    class="flex items-center gap-3 px-4 py-3 text-sm font-medium rounded-xl transition-all duration-200 
   {{ request()->routeIs('dosen.skpi.*') ? 'bg-indigo-600 text-white shadow-lg shadow-indigo-500/30' : 'text-slate-400 hover:bg-slate-800 hover:text-white' }}">
    <i class="fas fa-clipboard-check w-5 text-center"></i>
    <span>Review SKPI</span>

    {{-- Badge Opsional: Menampilkan jumlah yang perlu direview
    @php
        // Pastikan variabel $pendingCount tersedia lewat View Composer atau inject
        // Jika tidak mau ribet, hapus bagian span badge ini
        $pendingCount = \App\Models\SkpiMahasiswa::where('status', 'submitted')
            ->whereHas('user', function ($q) {
                // Logic filter prodi dosen login
                // Ini hanya contoh visual
            })
            ->count();
    @endphp

    @if (isset($pendingCount) && $pendingCount > 0)
        <span class="ml-auto bg-amber-500 text-white text-[10px] font-bold px-2 py-0.5 rounded-full">
            {{ $pendingCount > 99 ? '99+' : $pendingCount }}
        </span>
    @endif --}}
</a>
