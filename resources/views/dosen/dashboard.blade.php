@extends('layouts.app')

@section('title', 'Dashboard Dosen')
@section('page-title', 'Dashboard Dosen')

{{-- Sidebar sudah dihandle Layout --}}

@section('content')

    <div class="mb-8 relative overflow-hidden rounded-2xl bg-slate-900 text-white p-6 md:p-8 shadow-xl">
        <div class="absolute top-0 right-0 -mr-10 -mt-10 w-40 h-40 bg-[#0C6C85]/20 rounded-full blur-3xl"></div>
        <div class="absolute bottom-0 left-0 -ml-10 -mb-10 w-40 h-40 bg-blue-500/20 rounded-full blur-3xl"></div>

        <div class="relative z-10 flex flex-col md:flex-row md:items-center justify-between gap-6">
            <div>
                <div class="flex items-center gap-2 mb-2 text-slate-400 text-xs font-bold uppercase tracking-wider">
                    <i class="fas fa-university"></i> Program Studi
                </div>
                <h3 class="text-3xl font-bold mb-1">{{ $programStudi->nama }}</h3>
                <p class="text-slate-300 text-sm">
                    Kode Prodi: <span
                        class="font-mono bg-slate-800 px-2 py-0.5 rounded text-[#fbc21d]">{{ $programStudi->kode }}</span>
                </p>
            </div>

            <div class="flex items-center gap-4 bg-slate-800/50 p-4 rounded-xl border border-slate-700">
                <div class="w-12 h-12 bg-[#0F7287] rounded-full flex items-center justify-center text-white text-xl">
                    <i class="fas fa-users"></i>
                </div>
                <div>
                    <p class="text-xs text-slate-400">Mahasiswa Aktif</p>
                    <p class="text-xl font-bold">{{ $mahasiswaCount }}</p>
                </div>
            </div>
        </div>
    </div>

    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
        <div class="bg-white p-6 rounded-2xl shadow-sm border border-slate-100 hover:shadow-md transition group">
            <div class="flex justify-between items-start">
                <div>
                    <p class="text-xs font-bold text-slate-400 uppercase tracking-wider">Total SKPI</p>
                    <h3 class="text-3xl font-bold text-slate-800 mt-2">{{ $totalSkpi }}</h3>
                </div>
                <div
                    class="p-3 bg-[#f0f9fc] rounded-xl text-[#0F7287] group-hover:bg-[#0F7287] group-hover:text-white transition">
                    <i class="fas fa-file-contract text-xl"></i>
                </div>
            </div>
        </div>

        <div class="bg-white p-6 rounded-2xl shadow-sm border border-slate-100 hover:shadow-md transition group">
            <div class="flex justify-between items-start">
                <div>
                    <p class="text-xs font-bold text-slate-400 uppercase tracking-wider">Perlu Review</p>
                    <h3 class="text-3xl font-bold text-amber-600 mt-2">{{ $submittedSkpi }}</h3>
                </div>
                <div
                    class="p-3 bg-amber-50 rounded-xl text-amber-600 group-hover:bg-amber-500 group-hover:text-white transition">
                    <i class="fas fa-clock text-xl"></i>
                </div>
            </div>
        </div>

        <div class="bg-white p-6 rounded-2xl shadow-sm border border-slate-100 hover:shadow-md transition group">
            <div class="flex justify-between items-start">
                <div>
                    <p class="text-xs font-bold text-slate-400 uppercase tracking-wider">Disetujui</p>
                    <h3 class="text-3xl font-bold text-emerald-600 mt-2">{{ $acceptedSkpi }}</h3>
                </div>
                <div
                    class="p-3 bg-emerald-50 rounded-xl text-emerald-600 group-hover:bg-emerald-500 group-hover:text-white transition">
                    <i class="fas fa-check-circle text-xl"></i>
                </div>
            </div>
        </div>

        <div class="bg-white p-6 rounded-2xl shadow-sm border border-slate-100 hover:shadow-md transition group">
            <div class="flex justify-between items-start">
                <div>
                    <p class="text-xs font-bold text-slate-400 uppercase tracking-wider">Ditolak</p>
                    <h3 class="text-3xl font-bold text-rose-600 mt-2">{{ $rejectedSkpi }}</h3>
                </div>
                <div
                    class="p-3 bg-rose-50 rounded-xl text-rose-600 group-hover:bg-rose-500 group-hover:text-white transition">
                    <i class="fas fa-times-circle text-xl"></i>
                </div>
            </div>
        </div>
    </div>

    <div class="bg-white rounded-2xl shadow-sm border border-slate-100 overflow-hidden">
        <div class="p-6 border-b border-slate-100 flex items-center justify-between">
            <div>
                <h3 class="text-lg font-bold text-slate-800">SKPI Masuk Terbaru</h3>
                <p class="text-sm text-slate-500">5 data terakhir yang membutuhkan perhatian.</p>
            </div>
            <a href="{{ route('dosen.skpi.index') }}"
                class="text-sm text-[#0F7287] hover:text-[#0C6C85] font-medium transition">
                Lihat Semua <i class="fas fa-arrow-right ml-1 text-xs"></i>
            </a>
        </div>

        <div class="overflow-x-auto">
            <table class="w-full text-left border-collapse">
                <thead>
                    <tr class="bg-slate-50 text-slate-500 text-xs uppercase tracking-wider">
                        <th class="px-6 py-4 font-semibold">Mahasiswa</th>
                        <th class="px-6 py-4 font-semibold">Kategori</th>
                        <th class="px-6 py-4 font-semibold">Kegiatan</th>
                        <th class="px-6 py-4 font-semibold text-center">Status</th>
                        <th class="px-6 py-4 font-semibold text-right">Tanggal</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100">
                    @forelse($recentSkpi as $skpi)
                        <tr class="hover:bg-slate-50/80 transition">
                            <td class="px-6 py-4">
                                <div>
                                    <p class="text-sm font-bold text-slate-700">{{ $skpi->user->name }}</p>
                                    <p class="text-xs text-slate-500 font-mono">{{ $skpi->user->nim }}</p>
                                </div>
                            </td>
                            <td class="px-6 py-4">
                                <span
                                    class="inline-flex items-center px-2 py-0.5 rounded text-[10px] font-bold bg-[#f0f9fc] text-[#064D62] uppercase">
                                    {{ $skpi->kategori->nama }}
                                </span>
                            </td>
                            <td class="px-6 py-4">
                                <p class="text-sm font-medium text-slate-700 truncate max-w-xs">{{ $skpi->nama_kegiatan }}
                                </p>
                            </td>
                            <td class="px-6 py-4 text-center">
                                @php
                                    $statusConfig = [
                                        'draft' => ['bg' => 'bg-slate-100', 'text' => 'text-slate-600'],
                                        'submitted' => ['bg' => 'bg-amber-100', 'text' => 'text-amber-600'],
                                        'accepted' => ['bg' => 'bg-emerald-100', 'text' => 'text-emerald-600'],
                                        'rejected' => ['bg' => 'bg-rose-100', 'text' => 'text-rose-600'],
                                    ];
                                    $config = $statusConfig[$skpi->status] ?? $statusConfig['draft'];
                                @endphp
                                <span
                                    class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-bold {{ $config['bg'] }} {{ $config['text'] }}">
                                    {{ ucfirst($skpi->status) }}
                                </span>
                            </td>
                            <td class="px-6 py-4 text-right">
                                <span
                                    class="text-sm text-slate-500 font-mono">{{ $skpi->created_at->format('d M Y') }}</span>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="px-6 py-12 text-center text-slate-400">
                                <i class="far fa-folder-open text-3xl mb-2"></i>
                                <p class="text-sm">Belum ada data masuk</p>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
@endsection
