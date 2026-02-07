<p class="px-4 text-xs font-semibold text-slate-500 uppercase tracking-wider mb-2 mt-4">Menu Dosen</p>

<a href="{{ route('dosen.dashboard') }}"
    class="flex items-center gap-3 px-4 py-3 text-sm font-medium rounded-xl transition-all duration-200 
   {{ request()->routeIs('dosen.dashboard') ? 'bg-[#0F7287] text-white shadow-lg shadow-[#0C6C85]/30' : 'text-slate-400 hover:bg-slate-800 hover:text-white' }}">
    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor"
        class="w-5 h-5">
        <path stroke-linecap="round" stroke-linejoin="round"
            d="m2.25 12 8.954-8.955c.44-.439 1.152-.439 1.591 0L21.75 12M4.5 9.75v10.125c0 .621.504 1.125 1.125 1.125H9.75v-4.875c0-.621.504-1.125 1.125-1.125h2.25c.621 0 1.125.504 1.125 1.125V21h4.125c.621 0 1.125-.504 1.125-1.125V9.75M8.25 21h8.25" />
    </svg>
    <span>Dashboard</span>
</a>

<a href="{{ route('dosen.skpi.index') }}"
    class="flex items-center gap-3 px-4 py-3 text-sm font-medium rounded-xl transition-all duration-200 
   {{ request()->routeIs('dosen.skpi.*') ? 'bg-[#0F7287] text-white shadow-lg shadow-[#0C6C85]/30' : 'text-slate-400 hover:bg-slate-800 hover:text-white' }}">
    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor"
        class="w-5 h-5">
        <path stroke-linecap="round" stroke-linejoin="round"
            d="M11.35 3.836c-.065.21-.1.433-.1.664 0 .414.336.75.75.75h4.5a.75.75 0 0 0 .75-.75 2.25 2.25 0 0 0-.1-.664m-5.8 0A2.251 2.251 0 0 1 13.5 2.25H15c1.012 0 1.867.668 2.15 1.586m-5.8 0c-.376.023-.75.05-1.124.08C9.095 4.01 8.25 4.973 8.25 6.108V8.25m0 0H4.875c-.621 0-1.125.504-1.125 1.125v11.25c0 .621.504 1.125 1.125 1.125h9.75c.621 0 1.125-.504 1.125-1.125V9.375c0-.621-.504-1.125-1.125-1.125H8.25ZM6.75 12h.008v.008H6.75V12Zm0 3h.008v.008H6.75V15Zm0 3h.008v.008H6.75V18Z" />
        <path stroke-linecap="round" stroke-linejoin="round"
            d="M20.651 11.151a.75.75 0 1 0-1.06-1.06L14.325 15.36l-2.43-2.427a.75.75 0 0 0-1.06 1.061l2.962 2.959a.75.75 0 0 0 1.06 0l5.8-5.8Z" />
    </svg>

    <span class="flex-1">Review SKPI</span>
</a>
