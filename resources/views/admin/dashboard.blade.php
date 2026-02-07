@extends('layouts.app')

@section('title', 'Admin Dashboard')
@section('page-title', 'Dashboard Overview')

@section('content')
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
        <div class="bg-white p-6 rounded-2xl shadow-sm border border-slate-100 hover:shadow-md transition duration-300">
            <div class="flex justify-between items-start">
                <div>
                    <p class="text-xs font-semibold text-slate-400 uppercase tracking-wider">Mahasiswa</p>
                    <h3 class="text-3xl font-bold text-slate-800 mt-2">{{ $totalMahasiswa }}</h3>
                </div>
                <div class="p-3 bg-[#f0f9fc] rounded-xl text-[#0F7287]">
                    <i class="fas fa-users text-xl"></i>
                </div>
            </div>
            <div class="mt-4 flex items-center text-xs text-slate-500">
                <span class="text-green-500 font-semibold mr-1"><i class="fas fa-arrow-up"></i> Active</span>
                <span>registered users</span>
            </div>
        </div>

        <div class="bg-white p-6 rounded-2xl shadow-sm border border-slate-100 hover:shadow-md transition duration-300">
            <div class="flex justify-between items-start">
                <div>
                    <p class="text-xs font-semibold text-slate-400 uppercase tracking-wider">Dosen Validator</p>
                    <h3 class="text-3xl font-bold text-slate-800 mt-2">{{ $totalDosen }}</h3>
                </div>
                <div class="p-3 bg-teal-50 rounded-xl text-teal-600">
                    <i class="fas fa-chalkboard-teacher text-xl"></i>
                </div>
            </div>
            <div class="mt-4 flex items-center text-xs text-slate-500">
                <span class="text-slate-400 mr-1">Total</span>
                <span>academic staff</span>
            </div>
        </div>

        <div class="bg-white p-6 rounded-2xl shadow-sm border border-slate-100 hover:shadow-md transition duration-300">
            <div class="flex justify-between items-start">
                <div>
                    <p class="text-xs font-semibold text-slate-400 uppercase tracking-wider">Kategori SKPI</p>
                    <h3 class="text-3xl font-bold text-slate-800 mt-2">{{ $totalKategori }}</h3>
                </div>
                <div class="p-3 bg-purple-50 rounded-xl text-purple-600">
                    <i class="fas fa-tags text-xl"></i>
                </div>
            </div>
            <div class="mt-4 flex items-center text-xs text-slate-500">
                <span class="text-slate-400 mr-1">Types of</span>
                <span>achievements</span>
            </div>
        </div>

        <div class="bg-white p-6 rounded-2xl shadow-sm border border-slate-100 hover:shadow-md transition duration-300">
            <div class="flex justify-between items-start">
                <div>
                    <p class="text-xs font-semibold text-slate-400 uppercase tracking-wider">Total SKPI</p>
                    <h3 class="text-3xl font-bold text-slate-800 mt-2">{{ $totalSkpi }}</h3>
                </div>
                <div class="p-3 bg-blue-50 rounded-xl text-blue-600">
                    <i class="fas fa-file-contract text-xl"></i>
                </div>
            </div>
            <div class="mt-4 flex items-center text-xs text-slate-500">
                <span class="text-slate-400 mr-1">Total</span>
                <span>submissions</span>
            </div>
        </div>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6 mb-8">

        <div class="lg:col-span-2 bg-white p-6 rounded-2xl shadow-sm border border-slate-100">
            <div class="flex items-center justify-between mb-6">
                <h3 class="text-lg font-bold text-slate-800">Status Overview</h3>
                <button class="text-slate-400 hover:text-[#0F7287] transition"><i class="fas fa-ellipsis-h"></i></button>
            </div>

            <div class="grid grid-cols-2 sm:grid-cols-4 gap-4">
                <div class="p-4 rounded-xl bg-slate-50 border border-slate-100 text-center">
                    <span class="block text-2xl font-bold text-slate-600 mb-1">{{ $skpiByStatus['draft'] ?? 0 }}</span>
                    <span class="text-xs font-semibold text-slate-400 uppercase tracking-wide">Draft</span>
                </div>
                <div class="p-4 rounded-xl bg-amber-50 border border-amber-100 text-center">
                    <span class="block text-2xl font-bold text-amber-600 mb-1">{{ $skpiByStatus['submitted'] ?? 0 }}</span>
                    <span class="text-xs font-semibold text-amber-500 uppercase tracking-wide">Pending</span>
                </div>
                <div class="p-4 rounded-xl bg-emerald-50 border border-emerald-100 text-center">
                    <span class="block text-2xl font-bold text-emerald-600 mb-1">{{ $skpiByStatus['accepted'] ?? 0 }}</span>
                    <span class="text-xs font-semibold text-emerald-500 uppercase tracking-wide">Accepted</span>
                </div>
                <div class="p-4 rounded-xl bg-rose-50 border border-rose-100 text-center">
                    <span class="block text-2xl font-bold text-rose-600 mb-1">{{ $skpiByStatus['rejected'] ?? 0 }}</span>
                    <span class="text-xs font-semibold text-rose-500 uppercase tracking-wide">Rejected</span>
                </div>
            </div>
        </div>

        <div
            class="bg-white p-6 rounded-2xl shadow-sm border border-slate-100 flex flex-col justify-center relative overflow-hidden">
            <div
                class="absolute -right-6 -top-6 w-24 h-24 bg-gradient-to-br from-[#0C6C85] to-[#0F7287] rounded-full opacity-10">
            </div>

            <h3 class="text-lg font-bold text-slate-800 mb-4 z-10">Periode Aktif</h3>

            @if ($activePeriod)
                <div class="relative z-10">
                    <div
                        class="inline-flex items-center px-3 py-1 rounded-full bg-green-100 text-green-700 text-xs font-semibold mb-3">
                        <span class="w-2 h-2 rounded-full bg-green-500 mr-2 animate-pulse"></span>
                        Open for Submission
                    </div>
                    <h4 class="text-xl font-bold text-[#064D62] mb-1">{{ $activePeriod->nama }}</h4>
                    <p class="text-sm text-slate-500 mb-4">Pastikan mahasiswa menginput data sebelum tenggat waktu.</p>

                    <div
                        class="flex items-center gap-3 text-sm text-slate-600 bg-slate-50 p-3 rounded-lg border border-slate-100">
                        <i class="far fa-calendar-alt text-[#0C6C85]"></i>
                        <span class="font-medium">{{ $activePeriod->tanggal_mulai->format('d M') }}</span>
                        <i class="fas fa-arrow-right text-slate-300 text-xs"></i>
                        <span class="font-medium">{{ $activePeriod->tanggal_selesai->format('d M Y') }}</span>
                    </div>
                </div>
            @else
                <div class="text-center py-6 z-10">
                    <div
                        class="w-16 h-16 bg-slate-100 rounded-full flex items-center justify-center mx-auto mb-3 text-slate-400">
                        <i class="fas fa-calendar-times text-2xl"></i>
                    </div>
                    <p class="text-slate-500 font-medium">Tidak ada periode aktif</p>
                    <a href="{{ route('admin.periode.index') }}"
                        class="text-sm text-[#0F7287] hover:underline mt-2 inline-block">Buat Periode Baru</a>
                </div>
            @endif
        </div>
    </div>

    <div class="bg-white rounded-2xl shadow-sm border border-slate-100 overflow-hidden">
        <div class="p-6 border-b border-slate-100 flex flex-col md:flex-row md:items-center justify-between gap-4">
            <div>
                <h3 class="text-lg font-bold text-slate-800">SKPI Terbaru</h3>
                <p class="text-sm text-slate-500">Data submission yang baru masuk.</p>
            </div>
            <div class="flex items-center gap-3">
                <a href="{{ route('admin.export.excel') }}"
                    class="inline-flex items-center gap-2 px-4 py-2 bg-green-50 text-green-700 text-sm font-medium rounded-lg hover:bg-green-100 border border-green-200 transition">
                    <i class="fas fa-file-excel"></i> Excel
                </a>
                <a href="{{ route('admin.export.pdf') }}"
                    class="inline-flex items-center gap-2 px-4 py-2 bg-red-50 text-red-700 text-sm font-medium rounded-lg hover:bg-red-100 border border-red-200 transition">
                    <i class="fas fa-file-pdf"></i> PDF
                </a>
            </div>
        </div>

        <div class="overflow-x-auto">
            <table class="w-full text-left border-collapse">
                <thead>
                    <tr class="bg-slate-50 text-slate-500 text-xs uppercase tracking-wider">
                        <th class="px-6 py-4 font-semibold">Mahasiswa</th>
                        <th class="px-6 py-4 font-semibold">Kategori & Kegiatan</th>
                        <th class="px-6 py-4 font-semibold text-center">Status</th>
                        <th class="px-6 py-4 font-semibold text-right">Tanggal</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100">
                    @forelse($recentSkpi as $skpi)
                        <tr class="hover:bg-slate-50/80 transition duration-150">
                            <td class="px-6 py-4">
                                <div class="flex items-center gap-3">
                                    <div
                                        class="w-10 h-10 rounded-full bg-slate-200 flex items-center justify-center text-slate-500 font-bold text-xs">
                                        {{ substr($skpi->user->name, 0, 2) }}
                                    </div>
                                    <div>
                                        <p class="text-sm font-semibold text-slate-800">{{ $skpi->user->name }}</p>
                                        <p class="text-xs text-slate-500 font-mono">{{ $skpi->user->nim }}</p>
                                    </div>
                                </div>
                            </td>
                            <td class="px-6 py-4">
                                <span
                                    class="inline-block px-2 py-0.5 rounded text-[10px] font-bold bg-[#f0f9fc] text-[#0F7287] mb-1">
                                    {{ $skpi->kategori->nama }}
                                </span>
                                <p class="text-sm font-medium text-slate-700 truncate max-w-xs"
                                    title="{{ $skpi->nama_kegiatan }}">
                                    {{ $skpi->nama_kegiatan }}
                                </p>
                            </td>
                            <td class="px-6 py-4 text-center">
                                @php
                                    $statusClasses = [
                                        'draft' => 'bg-slate-100 text-slate-600',
                                        'submitted' => 'bg-amber-100 text-amber-600',
                                        'accepted' => 'bg-emerald-100 text-emerald-600',
                                        'rejected' => 'bg-rose-100 text-rose-600',
                                    ];
                                    $class = $statusClasses[$skpi->status] ?? 'bg-slate-100 text-slate-600';
                                @endphp
                                <span
                                    class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-bold {{ $class }}">
                                    {{ ucfirst($skpi->status) }}
                                </span>
                            </td>
                            <td class="px-6 py-4 text-right">
                                <p class="text-sm font-medium text-slate-600">{{ $skpi->created_at->format('d M Y') }}</p>
                                <p class="text-xs text-slate-400">{{ $skpi->created_at->format('H:i') }}</p>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="4" class="px-6 py-12 text-center">
                                <div class="flex flex-col items-center justify-center text-slate-400">
                                    <i class="far fa-folder-open text-4xl mb-3"></i>
                                    <p class="text-sm font-medium">Belum ada data SKPI terbaru.</p>
                                </div>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <div class="p-4 border-t border-slate-100 bg-slate-50/50 text-center">
            <a href="#" class="text-sm text-[#0F7287] hover:text-[#064D62] font-medium transition">
                Lihat Semua Data <i class="fas fa-arrow-right ml-1 text-xs"></i>
            </a>
        </div>
    </div>
@endsection
