<p class="px-4 text-xs font-semibold text-slate-500 uppercase tracking-wider mb-2 mt-4">Main Navigation</p>

<a href="{{ route('admin.dashboard') }}"
    class="flex items-center gap-3 px-4 py-3 text-sm font-medium rounded-xl transition-all duration-200 
   {{ request()->routeIs('admin.dashboard') ? 'bg-indigo-600 text-white shadow-lg shadow-indigo-500/30' : 'text-slate-400 hover:bg-slate-800 hover:text-white' }}">
    <i class="fas fa-home w-5 text-center"></i>
    <span>Dashboard</span>
</a>

<a href="{{ route('admin.mahasiswa.index') }}"
    class="flex items-center gap-3 px-4 py-3 text-sm font-medium rounded-xl transition-all duration-200 
   {{ request()->routeIs('admin.mahasiswa.*') ? 'bg-indigo-600 text-white shadow-lg shadow-indigo-500/30' : 'text-slate-400 hover:bg-slate-800 hover:text-white' }}">
    <i class="fas fa-user-graduate w-5 text-center"></i>
    <span>Mahasiswa</span>
</a>

<a href="{{ route('admin.program-studi.index') }}"
    class="flex items-center gap-3 px-4 py-3 text-sm font-medium rounded-xl transition-all duration-200 
   {{ request()->routeIs('admin.program-studi.*') ? 'bg-indigo-600 text-white shadow-lg shadow-indigo-500/30' : 'text-slate-400 hover:bg-slate-800 hover:text-white' }}">
    <i class="fas fa-graduation-cap w-5 text-center"></i>
    <span>Program Studi</span>
</a>

<p class="px-4 text-xs font-semibold text-slate-500 uppercase tracking-wider mb-2 mt-6 pt-6">Master Data</p>

<a href="{{ route('admin.kategori.index') }}"
    class="flex items-center gap-3 px-4 py-3 text-sm font-medium rounded-xl transition-all duration-200 
   {{ request()->routeIs('admin.kategori.*') ? 'bg-indigo-600 text-white shadow-lg shadow-indigo-500/30' : 'text-slate-400 hover:bg-slate-800 hover:text-white' }}">
    <i class="fas fa-list w-5 text-center"></i>
    <span>Kategori SKPI</span>
</a>

<a href="{{ route('admin.periode.index') }}"
    class="flex items-center gap-3 px-4 py-3 text-sm font-medium rounded-xl transition-all duration-200 
   {{ request()->routeIs('admin.periode.*') ? 'bg-indigo-600 text-white shadow-lg shadow-indigo-500/30' : 'text-slate-400 hover:bg-slate-800 hover:text-white' }}">
    <i class="fas fa-calendar-alt w-5 text-center"></i>
    <span>Periode Input</span>
</a>
