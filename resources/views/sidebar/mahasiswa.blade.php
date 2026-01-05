<p class="px-4 text-xs font-semibold text-slate-500 uppercase tracking-wider mb-2 mt-4">Main Navigation</p>

<a href="{{ route('mahasiswa.dashboard') }}"
    class="flex items-center gap-3 px-4 py-3 text-sm font-medium rounded-xl transition-all duration-200 
   {{ request()->routeIs('mahasiswa.dashboard') ? 'bg-indigo-600 text-white shadow-lg shadow-indigo-500/30' : 'text-slate-400 hover:bg-slate-800 hover:text-white' }}">
    <i class="fas fa-list w-5 text-center"></i>
    <span>Dashboard</span>
</a>

<a href="{{ route('mahasiswa.skpi.index') }}"
    class="flex items-center gap-3 px-4 py-3 text-sm font-medium rounded-xl transition-all duration-200 
   {{ request()->routeIs('mahasiswa.skpi.index') ? 'bg-indigo-600 text-white shadow-lg shadow-indigo-500/30' : 'text-slate-400 hover:bg-slate-800 hover:text-white' }}">
    <i class="fa-regular fa-hard-drive w-5 text-center"></i>
    <span>Data SKPI</span>
</a>

<a href="{{ route('mahasiswa.skpi.create') }}"
    class="flex items-center gap-3 px-4 py-3 text-sm font-medium rounded-xl transition-all duration-200 
   {{ request()->routeIs('mahasiswa.skpi.create') ? 'bg-indigo-600 text-white shadow-lg shadow-indigo-500/30' : 'text-slate-400 hover:bg-slate-800 hover:text-white' }}">
    <i class="fa-solid fa-person-circle-plus w-5 text-center"></i>
    <span>Tambah SKPI</span>
</a>
