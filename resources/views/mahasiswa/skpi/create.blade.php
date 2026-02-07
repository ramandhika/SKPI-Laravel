@extends('layouts.app')

@section('title', 'Tambah SKPI')
@section('page-title', 'Upload SKPI Baru')

@section('content')

    <div class="max-w-4xl mx-auto">

        <a href="{{ route('mahasiswa.skpi.index') }}"
            class="inline-flex items-center text-sm font-medium text-slate-500 hover:text-[#0F7287] mb-6 transition">
            <div
                class="w-8 h-8 rounded-full bg-white border border-slate-200 flex items-center justify-center mr-2 shadow-sm">
                <i class="fas fa-arrow-left"></i>
            </div>
            Kembali ke Daftar
        </a>

        <div class="bg-white rounded-2xl shadow-sm border border-slate-100 overflow-hidden">

            <div class="bg-slate-50/50 border-b border-slate-100 px-8 py-6">
                <h2 class="text-xl font-bold text-slate-800">Formulir Pengajuan SKPI</h2>
                <p class="text-sm text-slate-500 mt-1">Lengkapi data sertifikat atau kegiatan Anda dengan benar.</p>
            </div>

            <form action="{{ route('mahasiswa.skpi.store') }}" method="POST" id="skpiForm" class="p-8">
                @csrf

                <div class="grid grid-cols-1 md:grid-cols-2 gap-8 mb-8">

                    <div class="space-y-6">
                        <div>
                            <label class="block text-sm font-bold text-slate-700 mb-2">
                                Sub Kategori SKPI <span class="text-rose-500">*</span>
                            </label>

                            <!-- Hidden input untuk form submission -->
                            <input type="hidden" name="sub_kategori_skpi_id" id="sub_kategori_skpi_id" required>

                            <!-- Custom Dropdown -->
                            <div class="relative">
                                <button type="button" id="dropdownButton"
                                    class="w-full px-4 py-3 bg-slate-50 border border-slate-200 rounded-xl focus:bg-white focus:ring-2 focus:ring-[#0C6C85]/20 focus:border-[#0C6C85] transition outline-none text-left flex items-center justify-between hover:border-slate-300">
                                    <span id="selectedText" class="text-slate-500">-- Pilih Sub Kategori --</span>
                                    <i class="fas fa-chevron-down text-slate-400 text-sm"></i>
                                </button>

                                <!-- Dropdown Menu -->
                                <div id="dropdownMenu"
                                    class="hidden absolute top-full left-0 right-0 mt-2 bg-white border border-slate-200 rounded-xl shadow-lg z-50">

                                    <div class="max-h-96 overflow-y-auto p-2">
                                        @foreach ($kategoris as $kategori)
                                            <!-- Category Header -->
                                            <div
                                                class="px-4 py-2 text-sm font-bold text-slate-700 bg-slate-50/50 mt-2 first:mt-0 rounded-lg">
                                                {{ $kategori->nama }}
                                            </div>

                                            <!-- Sub Category Items -->
                                            @foreach ($kategori->subKategori as $sub)
                                                <button type="button" data-id="{{ $sub->id }}"
                                                    data-nama="{{ $sub->nama }}" data-nilai="{{ $sub->nilai }}"
                                                    class="dropdown-item w-full text-left px-4 py-3 hover:bg-[#f0f9fc] rounded-lg transition text-sm {{ old('sub_kategori_skpi_id') == $sub->id ? 'bg-[#f0f9fc] border-l-4 border-[#0C6C85]' : '' }}">
                                                    <div class="flex justify-between items-start">
                                                        <span class="text-slate-700 font-medium">{{ $sub->nama }}</span>
                                                        <span
                                                            class="text-[#0F7287] font-bold text-xs bg-[#d4f3ff] px-2 py-1 rounded">{{ $sub->nilai }}
                                                            poin</span>
                                                    </div>
                                                </button>
                                            @endforeach
                                        @endforeach
                                    </div>
                                </div>
                            </div>

                            @error('sub_kategori_skpi_id')
                                <p class="text-rose-500 text-xs mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        <div id="nilaiDisplay" class="hidden transition-all duration-300">
                            <div
                                class="flex items-center gap-3 p-4 bg-[#f0f9fc] border border-[#d4f3ff] rounded-xl text-[#064D62]">
                                <div
                                    class="w-10 h-10 bg-white rounded-full flex items-center justify-center text-[#0F7287] shadow-sm font-bold text-lg">
                                    <i class="fas fa-star text-amber-400 text-xs absolute -mt-6 -mr-6"></i>
                                    <span id="nilaiText">0</span>
                                </div>
                                <div>
                                    <p class="text-xs font-bold uppercase tracking-wide opacity-70">Poin Kredit</p>
                                    <p class="text-sm font-semibold">Nilai Sub Kategori Ini</p>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="space-y-6">
                        <div>
                            <label class="block text-sm font-bold text-slate-700 mb-2">
                                Nama Kegiatan (Indonesia) <span class="text-rose-500">*</span>
                            </label>
                            <input type="text" name="nama_kegiatan" value="{{ old('nama_kegiatan') }}"
                                class="w-full px-4 py-3 bg-slate-50 border border-slate-200 rounded-xl focus:bg-white focus:ring-2 focus:ring-[#0C6C85]/20 focus:border-[#0C6C85] transition outline-none placeholder:text-slate-400"
                                placeholder="Contoh: Juara 1 Lomba Web Design Nasional" required>
                            @error('nama_kegiatan')
                                <p class="text-rose-500 text-xs mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        <div>
                            <label class="block text-sm font-bold text-slate-700 mb-2">
                                Nama Kegiatan (English)
                            </label>
                            <input type="text" name="nama_kegiatan_en" value="{{ old('nama_kegiatan_en') }}"
                                class="w-full px-4 py-3 bg-slate-50 border border-slate-200 rounded-xl focus:bg-white focus:ring-2 focus:ring-[#0C6C85]/20 focus:border-[#0C6C85] transition outline-none placeholder:text-slate-400"
                                placeholder="Optional...">
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
                                value="{{ old('attachment_url') }}"
                                class="w-full pl-12 pr-4 py-3 bg-white border border-slate-200 rounded-xl focus:ring-2 focus:ring-[#0C6C85]/20 focus:border-[#0C6C85] transition outline-none"
                                placeholder="https://drive.google.com/file/d/..." required>
                        </div>
                        <button type="button" id="checkUrlBtn"
                            class="px-6 py-3 bg-white border border-slate-200 text-slate-600 font-semibold rounded-xl hover:border-[#fbc21d] hover:text-[#0F7287] transition shadow-sm whitespace-nowrap">
                            <i class="fas fa-link mr-2"></i> Cek Akses
                        </button>
                    </div>

                    <div id="urlStatus" class="mt-3"></div>

                    <p class="text-xs text-slate-400 mt-3 flex items-center">
                        <i class="fas fa-info-circle mr-1.5"></i> Pastikan file diatur ke "Anyone with the link" agar bisa
                        diakses dosen.
                    </p>
                    @error('attachment_url')
                        <p class="text-rose-500 text-xs mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <div
                    class="flex flex-col-reverse md:flex-row items-center justify-end gap-4 pt-6 border-t border-slate-100">
                    <button type="submit" name="status" value="draft"
                        class="w-full md:w-auto px-8 py-3.5 bg-slate-100 text-slate-600 font-bold rounded-xl hover:bg-slate-200 transition">
                        <i class="fas fa-save mr-2"></i> Simpan Draft
                    </button>
                    <button type="submit" name="status" value="submitted"
                        class="w-full md:w-auto px-8 py-3.5 bg-[#0F7287] text-white font-bold rounded-xl hover:bg-[#064D62] transition shadow-lg shadow-[#0C6C85]/30">
                        <i class="fas fa-paper-plane mr-2"></i> Submit Sekarang
                    </button>
                </div>
            </form>
        </div>
    </div>

    @push('scripts')
        <script>
            document.addEventListener('DOMContentLoaded', function() {
                // Custom Dropdown Logic
                const dropdownButton = document.getElementById('dropdownButton');
                const dropdownMenu = document.getElementById('dropdownMenu');
                const selectedText = document.getElementById('selectedText');
                const hiddenInput = document.getElementById('sub_kategori_skpi_id');
                const dropdownItems = document.querySelectorAll('.dropdown-item');
                const nilaiDisplay = document.getElementById('nilaiDisplay');
                const nilaiText = document.getElementById('nilaiText');

                // Toggle dropdown
                dropdownButton.addEventListener('click', function() {
                    dropdownMenu.classList.toggle('hidden');
                    dropdownButton.classList.toggle('ring-2');
                    dropdownButton.classList.toggle('ring-[#0C6C85]/20');
                });

                // Handle item selection
                dropdownItems.forEach(item => {
                    item.addEventListener('click', function(e) {
                        e.preventDefault();
                        const id = this.getAttribute('data-id');
                        const nama = this.getAttribute('data-nama');
                        const nilai = this.getAttribute('data-nilai');

                        // Update hidden input
                        hiddenInput.value = id;

                        // Update button text
                        selectedText.textContent = `${nama} - ${nilai} poin`;
                        selectedText.classList.remove('text-slate-500');
                        selectedText.classList.add('text-slate-700', 'font-medium');

                        // Update active state
                        dropdownItems.forEach(btn => {
                            btn.classList.remove('bg-[#f0f9fc]', 'border-l-4',
                                'border-[#0C6C85]');
                        });
                        this.classList.add('bg-[#f0f9fc]', 'border-l-4', 'border-[#0C6C85]');

                        // Show nilai
                        nilaiText.textContent = nilai;
                        nilaiDisplay.style.display = 'block';

                        // Close dropdown
                        dropdownMenu.classList.add('hidden');
                        dropdownButton.classList.remove('ring-2', 'ring-[#0C6C85]/20');
                    });
                });

                // Close dropdown when clicking outside
                document.addEventListener('click', function(e) {
                    if (!dropdownButton.contains(e.target) && !dropdownMenu.contains(e.target)) {
                        dropdownMenu.classList.add('hidden');
                        dropdownButton.classList.remove('ring-2', 'ring-[#0C6C85]/20');
                    }
                });

                // Restore value if old data exists
                const currentValue = hiddenInput.value;
                if (currentValue) {
                    const selectedItem = document.querySelector(`.dropdown-item[data-id="${currentValue}"]`);
                    if (selectedItem) {
                        const nama = selectedItem.getAttribute('data-nama');
                        const nilai = selectedItem.getAttribute('data-nilai');
                        selectedText.textContent = `${nama} - ${nilai} poin`;
                        selectedText.classList.remove('text-slate-500');
                        selectedText.classList.add('text-slate-700', 'font-medium');
                        selectedItem.classList.add('bg-[#f0f9fc]', 'border-l-4', 'border-[#0C6C85]');
                        nilaiText.textContent = nilai;
                        nilaiDisplay.style.display = 'block';
                    }
                }

                checkUrlBtn.addEventListener('click', function() {
                    const url = attachmentUrl.value;
                    if (!url) {
                        urlStatus.innerHTML =
                            '<p class="text-red-600 text-sm"><i class="fas fa-times-circle mr-1"></i> Masukkan URL terlebih dahulu</p>';
                        return;
                    }

                    checkUrlBtn.disabled = true;
                    checkUrlBtn.innerHTML = '<i class="fas fa-spinner fa-spin mr-2"></i> Mengecek...';
                    urlStatus.innerHTML =
                        '<p class="text-gray-600 text-sm"><i class="fas fa-spinner fa-spin mr-1"></i> Sedang mengecek aksesibilitas link...</p>';

                    fetch('/mahasiswa/check-url', {
                            method: 'POST',
                            headers: {
                                'Content-Type': 'application/json',
                                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
                            },
                            body: JSON.stringify({
                                url: url
                            })
                        })
                        .then(response => response.json())
                        .then(data => {
                            if (data.accessible) {
                                urlStatus.innerHTML =
                                    `<p class="text-green-600 text-sm"><i class="fas fa-check-circle mr-1"></i> ${data.message}</p>`;
                            } else {
                                urlStatus.innerHTML =
                                    `<p class="text-red-600 text-sm"><i class="fas fa-exclamation-circle mr-1"></i> ${data.message}</p>`;
                            }
                        })
                        .catch(error => {
                            urlStatus.innerHTML =
                                '<p class="text-red-600 text-sm"><i class="fas fa-times-circle mr-1"></i> Gagal mengecek URL</p>';
                        })
                        .finally(() => {
                            checkUrlBtn.disabled = false;
                            checkUrlBtn.innerHTML = '<i class="fas fa-check mr-2"></i> Cek Akses';
                        });
                });
            });
        </script>
    @endpush
@endsection
