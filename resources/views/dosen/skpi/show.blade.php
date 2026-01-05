@extends('layouts.app')

@section('title', 'Detail SKPI')
@section('page-title', 'Review Submission')

@section('content')

    <div class="max-w-5xl mx-auto">

        <a href="{{ route('dosen.skpi.index') }}"
            class="inline-flex items-center text-sm font-medium text-slate-500 hover:text-indigo-600 mb-6 transition">
            <div
                class="w-8 h-8 rounded-full bg-white border border-slate-200 flex items-center justify-center mr-2 shadow-sm">
                <i class="fas fa-arrow-left"></i>
            </div>
            Kembali ke Daftar
        </a>

        <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">

            <div class="lg:col-span-2 space-y-6">

                <div class="bg-white rounded-2xl shadow-sm border border-slate-100 p-6 flex items-start gap-5">
                    <div
                        class="w-16 h-16 rounded-full bg-slate-100 flex items-center justify-center text-slate-400 text-2xl font-bold flex-shrink-0">
                        {{ substr($skpi->user->name, 0, 1) }}
                    </div>
                    <div>
                        <h2 class="text-xl font-bold text-slate-800">{{ $skpi->user->name }}</h2>
                        <div class="flex items-center gap-4 mt-2 text-sm text-slate-500">
                            <span
                                class="bg-slate-100 px-2 py-0.5 rounded text-slate-600 font-mono">{{ $skpi->user->nim }}</span>
                            <span><i class="fas fa-envelope mr-1 text-slate-400"></i> {{ $skpi->user->email }}</span>
                        </div>
                    </div>
                </div>

                <div class="bg-white rounded-2xl shadow-sm border border-slate-100 overflow-hidden">
                    <div class="bg-slate-50/50 px-6 py-4 border-b border-slate-100 flex justify-between items-center">
                        <h3 class="font-bold text-slate-800">Detail Kegiatan</h3>
                        <span class="text-xs font-mono text-slate-400">ID: #{{ $skpi->id }}</span>
                    </div>

                    <div class="p-6 space-y-6">
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <div>
                                <p class="text-xs font-bold text-slate-400 uppercase mb-1">Kategori</p>
                                <div
                                    class="inline-flex items-center px-3 py-1 bg-indigo-50 text-indigo-700 rounded-lg text-sm font-medium">
                                    <i class="fas fa-tag mr-2 text-indigo-400"></i> {{ $skpi->kategori->nama }}
                                </div>
                            </div>
                            <div>
                                <p class="text-xs font-bold text-slate-400 uppercase mb-1">Poin Kredit</p>
                                <p class="text-lg font-bold text-slate-700">{{ $skpi->kategori->nilai }} <span
                                        class="text-sm font-normal text-slate-400">poin</span></p>
                            </div>
                        </div>

                        <div>
                            <p class="text-xs font-bold text-slate-400 uppercase mb-1">Nama Kegiatan (ID)</p>
                            <p class="text-base font-medium text-slate-800">{{ $skpi->nama_kegiatan }}</p>
                        </div>

                        @if ($skpi->nama_kegiatan_en)
                            <div>
                                <p class="text-xs font-bold text-slate-400 uppercase mb-1">Activity Name (EN)</p>
                                <p class="text-base font-medium text-slate-600 italic">{{ $skpi->nama_kegiatan_en }}</p>
                            </div>
                        @endif

                        <div class="pt-4 border-t border-slate-100">
                            <p class="text-xs font-bold text-slate-400 uppercase mb-3">Bukti Pendukung</p>
                            <a href="{{ $skpi->attachment_url }}" target="_blank"
                                class="flex items-center gap-3 p-4 rounded-xl border border-slate-200 hover:border-indigo-300 hover:bg-indigo-50/30 transition group">
                                <div
                                    class="w-10 h-10 bg-red-50 text-red-500 rounded-lg flex items-center justify-center text-xl group-hover:scale-110 transition">
                                    <i class="fab fa-google-drive"></i>
                                </div>
                                <div class="flex-1">
                                    <p class="text-sm font-bold text-slate-700 group-hover:text-indigo-700 transition">Buka
                                        Lampiran</p>
                                    <p class="text-xs text-slate-400">Google Drive Link</p>
                                </div>
                                <i class="fas fa-external-link-alt text-slate-400 group-hover:text-indigo-500"></i>
                            </a>
                        </div>
                    </div>
                </div>

                @if ($skpi->status != 'submitted')
                    <div class="bg-white rounded-2xl shadow-sm border border-slate-100 p-6">
                        <h3 class="font-bold text-slate-800 mb-4">Riwayat Review</h3>
                        <div class="flex gap-4">
                            <div class="flex flex-col items-center">
                                <div class="w-2 h-2 rounded-full bg-slate-300"></div>
                                <div class="w-0.5 h-full bg-slate-200 my-1"></div>
                                <div
                                    class="w-2 h-2 rounded-full {{ $skpi->status == 'accepted' ? 'bg-emerald-500' : 'bg-rose-500' }}">
                                </div>
                            </div>
                            <div class="flex-1 space-y-6 pb-2">
                                <div>
                                    <p class="text-sm font-bold text-slate-700">Diajukan</p>
                                    <p class="text-xs text-slate-400">{{ $skpi->created_at->format('d F Y, H:i') }}</p>
                                </div>
                                <div>
                                    <p
                                        class="text-sm font-bold {{ $skpi->status == 'accepted' ? 'text-emerald-600' : 'text-rose-600' }}">
                                        {{ ucfirst($skpi->status) }}
                                    </p>
                                    <p class="text-xs text-slate-400">Oleh: {{ $skpi->reviewer->name ?? 'Dosen' }} •
                                        {{ $skpi->reviewed_at ? $skpi->reviewed_at->format('d F Y, H:i') : '-' }}</p>

                                    @if ($skpi->catatan_dosen)
                                        <div
                                            class="mt-3 p-3 bg-slate-50 border-l-4 {{ $skpi->status == 'accepted' ? 'border-emerald-400' : 'border-rose-400' }} rounded-r-lg text-sm text-slate-600 italic">
                                            "{{ $skpi->catatan_dosen }}"
                                        </div>
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>
                @endif

            </div>

            <div class="lg:col-span-1">
                <div class="sticky top-24">

                    @if ($skpi->status == 'submitted')
                        <div class="bg-white rounded-2xl shadow-lg border border-indigo-100 overflow-hidden">
                            <div class="bg-indigo-600 p-4 text-white text-center">
                                <h3 class="font-bold text-lg">Action Required</h3>
                                <p class="text-indigo-200 text-xs">Validasi submission ini</p>
                            </div>

                            <form action="{{ route('dosen.skpi.review', $skpi) }}" method="POST" class="p-6">
                                @csrf

                                <div class="space-y-4">
                                    <div>
                                        <label class="block text-sm font-bold text-slate-700 mb-2">Keputusan</label>
                                        <div class="grid grid-cols-2 gap-3">
                                            <label class="cursor-pointer">
                                                <input type="radio" name="status" value="accepted" class="peer sr-only"
                                                    required>
                                                <div
                                                    class="p-3 text-center rounded-xl border-2 border-slate-200 text-slate-500 peer-checked:border-emerald-500 peer-checked:bg-emerald-50 peer-checked:text-emerald-600 transition hover:bg-slate-50">
                                                    <i class="fas fa-check-circle block text-2xl mb-1"></i> Accept
                                                </div>
                                            </label>
                                            <label class="cursor-pointer">
                                                <input type="radio" name="status" value="rejected" class="peer sr-only"
                                                    required>
                                                <div
                                                    class="p-3 text-center rounded-xl border-2 border-slate-200 text-slate-500 peer-checked:border-rose-500 peer-checked:bg-rose-50 peer-checked:text-rose-600 transition hover:bg-slate-50">
                                                    <i class="fas fa-times-circle block text-2xl mb-1"></i> Reject
                                                </div>
                                            </label>
                                        </div>
                                    </div>

                                    <div>
                                        <label class="block text-sm font-bold text-slate-700 mb-2">Catatan
                                            (Opsional)</label>
                                        <textarea name="catatan_dosen" rows="4"
                                            class="w-full px-4 py-3 bg-slate-50 border border-slate-200 rounded-xl focus:bg-white focus:ring-2 focus:ring-indigo-500/20 focus:border-indigo-500 transition outline-none resize-none"
                                            placeholder="Alasan penolakan atau apresiasi..."></textarea>
                                    </div>

                                    <button type="submit"
                                        class="w-full py-3.5 bg-indigo-600 hover:bg-indigo-700 text-white font-bold rounded-xl shadow-lg shadow-indigo-500/30 transition transform active:scale-95">
                                        Submit Review
                                    </button>
                                </div>
                            </form>
                        </div>
                    @else
                        <div class="bg-slate-50 border border-slate-200 rounded-2xl p-8 text-center">
                            <div
                                class="w-16 h-16 bg-white rounded-full flex items-center justify-center mx-auto mb-4 shadow-sm text-slate-300">
                                <i class="fas fa-lock text-2xl"></i>
                            </div>
                            <h3 class="font-bold text-slate-600">Review Selesai</h3>
                            <p class="text-sm text-slate-400 mt-1">Status saat ini: <span
                                    class="font-bold {{ $skpi->status == 'accepted' ? 'text-emerald-500' : 'text-rose-500' }}">{{ ucfirst($skpi->status) }}</span>
                            </p>
                        </div>
                    @endif

                </div>
            </div>

        </div>
    </div>

@endsection
