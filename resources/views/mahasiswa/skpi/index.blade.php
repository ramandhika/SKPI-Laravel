@extends('layouts.app')

@section('title', 'Data SKPI')
@section('page-title', 'Riwayat SKPI Saya')

@section('content')

    <div
        class="mb-6 bg-white border border-slate-200 rounded-xl p-4 flex flex-col md:flex-row items-center justify-between gap-4 shadow-sm">

        <form method="GET" class="flex items-center gap-2 w-full md:w-auto">
            <div class="relative w-full md:w-64">
                <i class="fas fa-filter absolute left-3 top-3.5 text-slate-400 text-sm"></i>
                <select name="status"
                    class="w-full pl-9 pr-4 py-2.5 bg-slate-50 border border-slate-200 rounded-lg focus:bg-white focus:ring-2 focus:ring-indigo-500/20 focus:border-indigo-500 transition outline-none appearance-none cursor-pointer text-sm font-medium">
                    <option value="">Semua Status</option>
                    <option value="draft" {{ request('status') == 'draft' ? 'selected' : '' }}>📝 Draft</option>
                    <option value="submitted" {{ request('status') == 'submitted' ? 'selected' : '' }}>⏳ Menunggu Validasi</option>
                    <option value="accepted" {{ request('status') == 'accepted' ? 'selected' : '' }}>✅ Disetujui</option>
                    <option value="rejected" {{ request('status') == 'rejected' ? 'selected' : '' }}>❌ Ditolak</option>
                </select>
            </div>
            <button type="submit"
                class="px-4 py-2.5 bg-slate-800 text-white font-semibold rounded-lg hover:bg-slate-900 transition shadow-sm text-sm">
                Filter
            </button>
        </form>

        <a href="{{ route('mahasiswa.skpi.create') }}"
            class="w-full md:w-auto inline-flex items-center justify-center gap-2 px-5 py-2.5 bg-indigo-600 text-white font-bold rounded-lg hover:bg-indigo-700 transition shadow-lg shadow-indigo-500/30">
            <i class="fas fa-plus"></i> Upload SKPI
        </a>
    </div>

    <div class="bg-white rounded-2xl shadow-sm border border-slate-100 overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full text-left border-collapse">
                <thead>
                    <tr class="bg-slate-50 text-slate-500 text-xs uppercase tracking-wider border-b border-slate-100">
                        <th class="px-6 py-4 font-semibold">Detail Kegiatan</th>
                        <th class="px-6 py-4 font-semibold">Kategori</th>
                        <th class="px-6 py-4 font-semibold text-center">Status</th>
                        <th class="px-6 py-4 font-semibold text-center">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100">
                    @forelse($skpis as $skpi)
                        <tr class="hover:bg-slate-50/80 transition group">

                            <td class="px-6 py-4 align-top">
                                <p class="text-sm font-bold text-slate-800 mb-1">{{ $skpi->nama_kegiatan }}</p>
                                @if ($skpi->nama_kegiatan_en)
                                    <p class="text-xs text-slate-500 italic mb-2">{{ $skpi->nama_kegiatan_en }}</p>
                                @endif
                                <div class="flex items-center gap-2 mt-2">
                                    <a href="{{ $skpi->attachment_url }}" target="_blank"
                                        class="inline-flex items-center gap-1 px-2 py-1 rounded bg-slate-100 text-slate-600 text-xs hover:bg-indigo-50 hover:text-indigo-600 transition">
                                        <i class="fab fa-google-drive"></i> Bukti Lampiran
                                    </a>
                                </div>
                            </td>

                            <td class="px-6 py-4 align-top">
                                <span
                                    class="inline-flex items-center px-2 py-0.5 rounded text-[10px] font-bold bg-indigo-50 text-indigo-700 mb-1">
                                    {{ $skpi->kategori->nama }}
                                </span>
                                <p class="text-xs text-slate-500">{{ $skpi->subKategori->nama }}</p>
                                <p class="text-xs font-bold text-slate-400 mt-1">Nilai: <span
                                        class="text-slate-600">{{ $skpi->kategori->nilai }}</span></p>
                            </td>

                            <td class="px-6 py-4 text-center align-top">
                                @php
                                    $statusConfig = [
                                        'draft' => [
                                            'bg' => 'bg-slate-100',
                                            'text' => 'text-slate-600',
                                            'border' => 'border-slate-200',
                                        ],
                                        'submitted' => [
                                            'bg' => 'bg-amber-100',
                                            'text' => 'text-amber-600',
                                            'border' => 'border-amber-200',
                                        ],
                                        'accepted' => [
                                            'bg' => 'bg-emerald-100',
                                            'text' => 'text-emerald-600',
                                            'border' => 'border-emerald-200',
                                        ],
                                        'rejected' => [
                                            'bg' => 'bg-rose-100',
                                            'text' => 'text-rose-600',
                                            'border' => 'border-rose-200',
                                        ],
                                    ];
                                    $config = $statusConfig[$skpi->status] ?? $statusConfig['draft'];
                                @endphp
                                <span
                                    class="inline-flex items-center px-3 py-1 rounded-full text-xs font-bold border {{ $config['bg'] }} {{ $config['text'] }} {{ $config['border'] }}">
                                    {{ ucfirst($skpi->status) }}
                                </span>

                                @if ($skpi->catatan_dosen)
                                    <div class="mt-2 text-left bg-rose-50 border border-rose-100 p-2 rounded-lg relative">
                                        <div
                                            class="absolute -top-1 left-1/2 -translate-x-1/2 w-2 h-2 bg-rose-50 border-t border-l border-rose-100 transform rotate-45">
                                        </div>
                                        <p class="text-[10px] text-rose-600 italic line-clamp-2"
                                            title="{{ $skpi->catatan_dosen }}">
                                            "{{ $skpi->catatan_dosen }}"
                                        </p>
                                    </div>
                                @endif
                            </td>

                            <td class="px-6 py-4 text-center align-top">
                                <div class="flex items-center justify-center gap-2">
                                    @if ($skpi->status == 'draft' || $skpi->status == 'submitted')
                                        <a href="{{ route('mahasiswa.skpi.edit', $skpi) }}"
                                            class="p-2 rounded-lg text-amber-500 hover:bg-amber-50 hover:text-amber-600 transition"
                                            title="Edit Data">
                                            <i class="fas fa-edit"></i>
                                        </a>
                                    @endif

                                    @if ($skpi->status == 'draft')
                                        <form action="{{ route('mahasiswa.skpi.destroy', $skpi) }}" method="POST"
                                            onsubmit="return confirm('Yakin ingin menghapus data ini? Action tidak bisa dibatalkan.')">
                                            @csrf @method('DELETE')
                                            <button type="submit"
                                                class="p-2 rounded-lg text-rose-400 hover:bg-rose-50 hover:text-rose-600 transition"
                                                title="Hapus Permanen">
                                                <i class="fas fa-trash-alt"></i>
                                            </button>
                                        </form>
                                    @endif

                                    @if ($skpi->status == 'accepted' || $skpi->status == 'rejected')
                                        <span class="text-xs text-slate-300 italic">Locked</span>
                                    @endif
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="4" class="px-6 py-12 text-center">
                                <div class="flex flex-col items-center justify-center text-slate-400">
                                    <div class="w-16 h-16 bg-slate-50 rounded-full flex items-center justify-center mb-3">
                                        <i class="fas fa-inbox text-2xl text-slate-300"></i>
                                    </div>
                                    <p class="text-sm font-medium">Belum ada data SKPI.</p>
                                    <a href="{{ route('mahasiswa.skpi.create') }}"
                                        class="mt-2 text-sm text-indigo-600 hover:underline">Mulai Upload</a>
                                </div>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <div class="p-4 border-t border-slate-100 bg-slate-50">
            {{ $skpis->links() }}
        </div>
    </div>
@endsection
