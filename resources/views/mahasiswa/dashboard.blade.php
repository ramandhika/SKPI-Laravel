@extends('layouts.app')

@section('title', 'Dashboard Mahasiswa')
@section('page-title', 'Overview Akademik')

{{-- Sidebar sudah dihandle oleh Layouts, jadi section sidebar dihapus --}}

@section('content')

    @if ($activePeriod)
        <div
            class="mb-8 relative overflow-hidden rounded-2xl bg-gradient-to-r from-[#0F7287] to-[#064D62] shadow-lg shadow-[#0C6C85]/20 text-white p-6 md:p-8">
            <div class="absolute top-0 right-0 -mr-10 -mt-10 w-40 h-40 bg-white/10 rounded-full blur-3xl"></div>
            <div class="absolute bottom-0 left-0 -ml-10 -mb-10 w-40 h-40 bg-purple-500/20 rounded-full blur-3xl"></div>

            <div class="relative z-10 flex flex-col md:flex-row md:items-center justify-between gap-6">
                <div>
                    <div class="flex items-center gap-2 mb-2">
                        <span
                            class="px-2.5 py-0.5 rounded-full bg-green-400/20 text-green-300 text-xs font-bold border border-green-400/30 animate-pulse">
                            <i class="fas fa-circle text-[8px] mr-1"></i> Periode Aktif
                        </span>
                    </div>
                    <h3 class="text-2xl font-bold mb-1">{{ $activePeriod->nama }}</h3>
                    <p class="text-[#fbc21d] text-sm opacity-90">
                        <i class="far fa-calendar-alt mr-1"></i>
                        {{ $activePeriod->tanggal_mulai->format('d M Y') }} —
                        {{ $activePeriod->tanggal_selesai->format('d M Y') }}
                    </p>
                </div>

                {{-- Pastikan route 'mahasiswa.skpi.create' ada, jika belum, ganti '#' --}}
                <a href="{{ route('mahasiswa.skpi.create') }}"
                    class="inline-flex items-center justify-center px-6 py-3 bg-white text-[#064D62] font-bold rounded-xl hover:bg-[#f0f9fc] transition transform hover:-translate-y-0.5 shadow-md">
                    <i class="fas fa-plus-circle mr-2"></i> Upload SKPI Baru
                </a>
            </div>
        </div>
    @else
        <div class="mb-8 p-6 rounded-2xl bg-slate-100 border border-slate-200 text-center">
            <div class="w-16 h-16 bg-slate-200 rounded-full flex items-center justify-center mx-auto mb-3 text-slate-400">
                <i class="fas fa-calendar-times text-2xl"></i>
            </div>
            <h3 class="text-lg font-bold text-slate-700">Tidak Ada Periode Aktif</h3>
            <p class="text-slate-500 text-sm mt-1">Saat ini belum ada periode pengumpulan SKPI yang dibuka.</p>
        </div>
    @endif

    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
        <div class="bg-white p-6 rounded-2xl shadow-sm border border-slate-100 hover:shadow-md transition">
            <div class="flex justify-between items-start">
                <div>
                    <p class="text-xs font-bold text-slate-400 uppercase tracking-wider">Total Upload</p>
                    <h3 class="text-3xl font-bold text-slate-800 mt-2">{{ $totalSkpi }}</h3>
                </div>
                <div class="p-3 bg-[#f0f9fc] rounded-xl text-[#0F7287]">
                    <i class="fas fa-folder-open text-xl"></i>
                </div>
            </div>
        </div>

        <div class="bg-white p-6 rounded-2xl shadow-sm border border-slate-100 hover:shadow-md transition">
            <div class="flex justify-between items-start">
                <div>
                    <p class="text-xs font-bold text-slate-400 uppercase tracking-wider">Draft</p>
                    <h3 class="text-3xl font-bold text-slate-600 mt-2">{{ $draftSkpi }}</h3>
                </div>
                <div class="p-3 bg-slate-100 rounded-xl text-slate-600">
                    <i class="fas fa-pencil-alt text-xl"></i>
                </div>
            </div>
        </div>

        <div class="bg-white p-6 rounded-2xl shadow-sm border border-slate-100 hover:shadow-md transition">
            <div class="flex justify-between items-start">
                <div>
                    <p class="text-xs font-bold text-slate-400 uppercase tracking-wider">Menunggu Validasi</p>
                    <h3 class="text-3xl font-bold text-amber-600 mt-2">{{ $submittedSkpi }}</h3>
                </div>
                <div class="p-3 bg-amber-50 rounded-xl text-amber-600">
                    <i class="fas fa-clock text-xl"></i>
                </div>
            </div>
        </div>

        <div class="bg-white p-6 rounded-2xl shadow-sm border border-slate-100 hover:shadow-md transition">
            <div class="flex justify-between items-start">
                <div>
                    <p class="text-xs font-bold text-slate-400 uppercase tracking-wider">Disetujui</p>
                    <h3 class="text-3xl font-bold text-emerald-600 mt-2">{{ $acceptedSkpi }}</h3>
                </div>
                <div class="p-3 bg-emerald-50 rounded-xl text-emerald-600">
                    <i class="fas fa-check-circle text-xl"></i>
                </div>
            </div>
        </div>
    </div>

    <div class="bg-white rounded-2xl shadow-sm border border-slate-100 overflow-hidden">
        <div class="p-6 border-b border-slate-100 flex items-center justify-between">
            <div>
                <h3 class="text-lg font-bold text-slate-800">Riwayat SKPI Terbaru</h3>
                <p class="text-sm text-slate-500">5 data terakhir yang kamu input.</p>
            </div>
            <a href="{{ route('mahasiswa.skpi.index') }}"
                class="text-sm text-[#0F7287] hover:text-[#064D62] font-medium transition">
                Lihat Semua <i class="fas fa-arrow-right ml-1 text-xs"></i>
            </a>
        </div>

        <div class="overflow-x-auto">
            <table class="w-full text-left border-collapse">
                <thead>
                    <tr class="bg-slate-50 text-slate-500 text-xs uppercase tracking-wider">
                        <th class="px-6 py-4 font-semibold">Kategori</th>
                        <th class="px-6 py-4 font-semibold">Nama Kegiatan</th>
                        <th class="px-6 py-4 font-semibold text-center">Status</th>
                        <th class="px-6 py-4 font-semibold text-right">Tanggal Input</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100">
                    @forelse($recentSkpi as $skpi)
                        <tr class="hover:bg-slate-50/80 transition">
                            <td class="px-6 py-4">
                                <span
                                    class="inline-flex items-center px-2.5 py-0.5 rounded-lg text-xs font-bold bg-[#f0f9fc] text-[#064D62]">
                                    <i class="fas fa-tag mr-1.5 text-[10px]"></i> {{ $skpi->kategori->nama }}
                                </span>
                            </td>
                            <td class="px-6 py-4">
                                <p class="text-sm font-semibold text-slate-700 truncate max-w-xs">
                                    {{ $skpi->nama_kegiatan }}</p>
                            </td>
                            <td class="px-6 py-4 text-center">
                                @php
                                    $statusConfig = [
                                        'draft' => [
                                            'bg' => 'bg-slate-100',
                                            'text' => 'text-slate-600',
                                            'icon' => 'fa-pencil-alt',
                                        ],
                                        'submitted' => [
                                            'bg' => 'bg-amber-100',
                                            'text' => 'text-amber-600',
                                            'icon' => 'fa-clock',
                                        ],
                                        'accepted' => [
                                            'bg' => 'bg-emerald-100',
                                            'text' => 'text-emerald-600',
                                            'icon' => 'fa-check',
                                        ],
                                        'rejected' => [
                                            'bg' => 'bg-rose-100',
                                            'text' => 'text-rose-600',
                                            'icon' => 'fa-times',
                                        ],
                                    ];
                                    $config = $statusConfig[$skpi->status] ?? $statusConfig['draft'];
                                @endphp
                                <span
                                    class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-bold {{ $config['bg'] }} {{ $config['text'] }}">
                                    <i class="fas {{ $config['icon'] }} mr-1.5 text-[10px]"></i>
                                    {{ ucfirst($skpi->status) }}
                                </span>
                            </td>
                            <td class="px-6 py-4 text-right">
                                <span
                                    class="text-sm text-slate-500 font-mono">{{ $skpi->created_at->format('d/m/Y') }}</span>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="4" class="px-6 py-12 text-center">
                                <div class="flex flex-col items-center justify-center text-slate-400">
                                    <i class="far fa-folder-open text-4xl mb-3"></i>
                                    <p class="text-sm font-medium">Belum ada data SKPI.</p>
                                    @if ($activePeriod)
                                        <a href="{{ route('mahasiswa.skpi.create') }}"
                                            class="mt-2 text-sm text-[#0F7287] hover:underline">
                                            Mulai Upload Sekarang
                                        </a>
                                    @endif
                                </div>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
@endsection
