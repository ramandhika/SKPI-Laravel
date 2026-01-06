@extends('layouts.app')

@section('title', 'Edit SKPI')
@section('page-title', 'Edit Submission')

@section('content')

    <div class="max-w-4xl mx-auto">

        <div class="flex items-center justify-between mb-6">
            <a href="{{ route('mahasiswa.skpi.index') }}"
                class="inline-flex items-center text-sm font-medium text-slate-500 hover:text-indigo-600 transition">
                <div
                    class="w-8 h-8 rounded-full bg-white border border-slate-200 flex items-center justify-center mr-2 shadow-sm">
                    <i class="fas fa-arrow-left"></i>
                </div>
                Batal Edit
            </a>
            <span class="px-3 py-1 bg-amber-50 text-amber-600 text-xs font-bold rounded-full border border-amber-100">
                Editing Mode
            </span>
        </div>

        <div class="bg-white rounded-2xl shadow-sm border border-slate-100 overflow-hidden">

            <div class="bg-amber-50/50 border-b border-amber-100 px-8 py-6">
                <h2 class="text-xl font-bold text-slate-800">Edit Data SKPI</h2>
                <p class="text-sm text-slate-500 mt-1">Perbarui informasi kegiatan sebelum melakukan submit ulang.</p>
            </div>

            <form action="{{ route('mahasiswa.skpi.update', $skpi) }}" method="POST" id="skpiForm" class="p-8">
                @csrf
                @method('PUT')

                <div class="grid grid-cols-1 md:grid-cols-2 gap-8 mb-8">

                    <div class="space-y-6">
                        <div>
                            <label class="block text-sm font-bold text-slate-700 mb-2">
                                Sub Kategori SKPI <span class="text-rose-500">*</span>
                            </label>
                            <select name="sub_kategori_skpi_id" id="sub_kategori_skpi_id"
                                class="w-full px-4 py-3 bg-slate-50 border border-slate-200 rounded-xl focus:bg-white focus:ring-2 focus:ring-indigo-500/20 focus:border-indigo-500 transition outline-none cursor-pointer"
                                required>
                                <option value="">-- Pilih Sub Kategori --</option>
                                @foreach ($kategoris as $kategori)
                                    <optgroup label="{{ $kategori->nama }}">
                                        @foreach ($kategori->subKategori as $sub)
                                            <option value="{{ $sub->id }}" data-nilai="{{ $sub->nilai }}"
                                                {{ old('sub_kategori_skpi_id', $skpi->sub_kategori_skpi_id) == $sub->id ? 'selected' : '' }}>
                                                {{ $sub->nama }} - {{ $sub->nilai }} poin
                                            </option>
                                        @endforeach
                                    </optgroup>
                                @endforeach
                            </select>
                            @error('sub_kategori_skpi_id')
                                <p class="text-rose-500 text-xs mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        <div id="nilaiDisplay" class="transition-all duration-300">
                            <div
                                class="flex items-center gap-3 p-4 bg-indigo-50 border border-indigo-100 rounded-xl text-indigo-700">
                                <div
                                    class="w-10 h-10 bg-white rounded-full flex items-center justify-center text-indigo-600 shadow-sm font-bold text-lg">
                                    <span id="nilaiText">{{ $skpi->subKategori->nilai ?? 0 }}</span>
                                </div>
                                <div>
                                    <p class="text-xs font-bold uppercase tracking-wide opacity-70">Poin Kredit</p>
                                    <p class="text-sm font-semibold">Nilai Sub Kategori Ini</p>
                                </div>
                            </div>
                        </div>
                        @error('sub_kategori_skpi_id')
                            <p class="text-rose-500 text-xs mt-1">{{ $message }}</p>
                        @enderror
                    </div>
                </div>

                <div class="space-y-6">
                    <div>
                        <label class="block text-sm font-bold text-slate-700 mb-2">
                            Nama Kegiatan (Indonesia) <span class="text-rose-500">*</span>
                        </label>
                        <input type="text" name="nama_kegiatan" value="{{ old('nama_kegiatan', $skpi->nama_kegiatan) }}"
                            class="w-full px-4 py-3 bg-slate-50 border border-slate-200 rounded-xl focus:bg-white focus:ring-2 focus:ring-indigo-500/20 focus:border-indigo-500 transition outline-none"
                            required>
                        @error('nama_kegiatan')
                            <p class="text-rose-500 text-xs mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label class="block text-sm font-bold text-slate-700 mb-2">
                            Nama Kegiatan (English)
                        </label>
                        <input type="text" name="nama_kegiatan_en"
                            value="{{ old('nama_kegiatan_en', $skpi->nama_kegiatan_en) }}"
                            class="w-full px-4 py-3 bg-slate-50 border border-slate-200 rounded-xl focus:bg-white focus:ring-2 focus:ring-indigo-500/20 focus:border-indigo-500 transition outline-none">
                        @error('nama_kegiatan_en')
                            <p class="text-rose-500 text-xs mt-1">{{ $message }}</p>
                        @enderror
                    </div>
                </div>

        </div>

        <div class="mb-8 p-6 bg-slate-50 rounded-2xl border border-slate-200 border-dashed">
            <label class="block text-sm font-bold text-slate-700 mb-3">
                Link Bukti (Google Drive) <span class="text-rose-500">*</span>
            </label>

            <div class="flex flex-col md:flex-row gap-3">
                <div class="relative flex-1">
                    <i class="fab fa-google-drive absolute left-4 top-3.5 text-slate-400 text-lg"></i>
                    <input type="url" name="attachment_url" id="attachment_url"
                        value="{{ old('attachment_url', $skpi->attachment_url) }}"
                        class="w-full pl-12 pr-4 py-3 bg-white border border-slate-200 rounded-xl focus:ring-2 focus:ring-indigo-500/20 focus:border-indigo-500 transition outline-none"
                        required>
                </div>
                <button type="button" id="checkUrlBtn"
                    class="px-6 py-3 bg-white border border-slate-200 text-slate-600 font-semibold rounded-xl hover:border-indigo-300 hover:text-indigo-600 transition shadow-sm whitespace-nowrap">
                    <i class="fas fa-link mr-2"></i> Cek Akses
                </button>
            </div>

            <div id="urlStatus" class="mt-3"></div>
            @error('attachment_url')
                <p class="text-rose-500 text-xs mt-1">{{ $message }}</p>
            @enderror
        </div>

        <div class="flex flex-col-reverse md:flex-row items-center justify-end gap-4 pt-6 border-t border-slate-100">
            <button type="submit" name="status" value="draft"
                class="w-full md:w-auto px-8 py-3.5 bg-slate-100 text-slate-600 font-bold rounded-xl hover:bg-slate-200 transition">
                <i class="fas fa-save mr-2"></i> Update Draft
            </button>
            <button type="submit" name="status" value="submitted"
                class="w-full md:w-auto px-8 py-3.5 bg-indigo-600 text-white font-bold rounded-xl hover:bg-indigo-700 transition shadow-lg shadow-indigo-500/30">
                <i class="fas fa-paper-plane mr-2"></i> Submit Ulang
            </button>
        </div>
        </form>
    </div>
    </div>

    @push('scripts')
        <script>
            document.addEventListener('DOMContentLoaded', function() {
                const subKategoriSelect = document.getElementById('sub_kategori_skpi_id');
                const nilaiText = document.getElementById('nilaiText');
                const checkUrlBtn = document.getElementById('checkUrlBtn');
                const attachmentUrl = document.getElementById('attachment_url');
                const urlStatus = document.getElementById('urlStatus');

                // Handle sub kategori change
                subKategoriSelect.addEventListener('change', function() {
                    const selectedOption = this.options[this.selectedIndex];
                    const nilai = selectedOption.getAttribute('data-nilai');
                    if (this.value) {
                        nilaiText.textContent = nilai || 0;
                    }
                });

                document.getElementById('checkUrlBtn').addEventListener('click', function() {
                    const url = document.getElementById('attachment_url').value;
                    if (!url) {
                        document.getElementById('urlStatus').innerHTML =
                            '<p class="text-red-600 text-sm"><i class="fas fa-times-circle mr-1"></i>Masukkan URL</p>';
                        return;
                    }

                    this.disabled = true;
                    this.innerHTML = '<i class="fas fa-spinner fa-spin mr-2"></i>Mengecek...';

                    fetch('/mahasiswa/check-url', {
                            method: 'POST',
                            headers: {
                                'Content-Type': 'application/json',
                                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
                            },
                            body: JSON.stringify({
                                url
                            })
                        })
                        .then(r => r.json())
                        .then(data => {
                            document.getElementById('urlStatus').innerHTML =
                                `<p class="text-${data.accessible?'green':'red'}-600 text-sm"><i class="fas fa-${data.accessible?'check':'exclamation'}-circle mr-1"></i>${data.message}</p>`;
                        })
                        .finally(() => {
                            this.disabled = false;
                            this.innerHTML = '<i class="fas fa-check mr-2"></i> Cek Akses';
                        });
                });
            });
        </script>
    @endpush
@endsection
