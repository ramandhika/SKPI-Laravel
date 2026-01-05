@extends('layouts.app')

@section('title', 'Tambah SKPI')
@section('page-title', 'Tambah Data SKPI')

@section('sidebar')
<a href="{{ route('mahasiswa.dashboard') }}" class="block px-6 py-3 hover:bg-indigo-700 transition">
    <i class="fas fa-home mr-3"></i> Dashboard
</a>
<a href="{{ route('mahasiswa.skpi.index') }}" class="block px-6 py-3 hover:bg-indigo-700 transition">
    <i class="fas fa-file-alt mr-3"></i> Data SKPI
</a>
<a href="{{ route('mahasiswa.skpi.create') }}" class="block px-6 py-3 bg-indigo-900 border-l-4 border-white">
    <i class="fas fa-plus mr-3"></i> Tambah SKPI
</a>
@endsection

@section('content')
<div class="max-w-4xl mx-auto">
    <div class="bg-white rounded-lg shadow-md p-6">
        <form action="{{ route('mahasiswa.skpi.store') }}" method="POST" id="skpiForm">
            @csrf
            
            <div class="mb-6">
                <label class="block text-gray-700 font-semibold mb-2">Kategori SKPI <span class="text-red-500">*</span></label>
                <select name="kategori_skpi_id" id="kategori_skpi_id" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-transparent" required>
                    <option value="">Pilih Kategori</option>
                    @foreach($kategoris as $kategori)
                        <option value="{{ $kategori->id }}" data-nilai="{{ $kategori->nilai }}" {{ old('kategori_skpi_id') == $kategori->id ? 'selected' : '' }}>
                            {{ $kategori->nama }} (Nilai: {{ $kategori->nilai }})
                        </option>
                    @endforeach
                </select>
                @error('kategori_skpi_id')
                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>

            <div class="mb-6" id="nilaiDisplay" style="display: none;">
                <div class="bg-blue-50 border border-blue-200 rounded-lg p-4">
                    <p class="text-blue-800">
                        <i class="fas fa-star mr-2"></i>
                        <strong>Nilai Kategori:</strong> <span id="nilaiText">0</span>
                    </p>
                </div>
            </div>

            <div class="mb-6">
                <label class="block text-gray-700 font-semibold mb-2">Sub Kategori <span class="text-red-500">*</span></label>
                <select name="sub_kategori_skpi_id" id="sub_kategori_skpi_id" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-transparent" required disabled>
                    <option value="">Pilih kategori terlebih dahulu</option>
                </select>
                @error('sub_kategori_skpi_id')
                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>

            <div class="mb-6">
                <label class="block text-gray-700 font-semibold mb-2">Nama Kegiatan/Sertifikat (Bahasa Indonesia) <span class="text-red-500">*</span></label>
                <input type="text" name="nama_kegiatan" value="{{ old('nama_kegiatan') }}" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-transparent" placeholder="Contoh: Juara 1 Lomba Web Design Nasional" required>
                @error('nama_kegiatan')
                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>

            <div class="mb-6">
                <label class="block text-gray-700 font-semibold mb-2">Nama Kegiatan/Sertifikat (Bahasa Inggris)</label>
                <input type="text" name="nama_kegiatan_en" value="{{ old('nama_kegiatan_en') }}" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-transparent" placeholder="Example: 1st Winner of National Web Design Competition">
                @error('nama_kegiatan_en')
                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>

            <div class="mb-6">
                <label class="block text-gray-700 font-semibold mb-2">Link Attachment Google Drive <span class="text-red-500">*</span></label>
                <div class="flex gap-2">
                    <input type="url" name="attachment_url" id="attachment_url" value="{{ old('attachment_url') }}" class="flex-1 px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-transparent" placeholder="https://drive.google.com/file/d/..." required>
                    <button type="button" id="checkUrlBtn" class="px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition">
                        <i class="fas fa-check mr-2"></i> Cek Akses
                    </button>
                </div>
                <div id="urlStatus" class="mt-2"></div>
                <p class="text-sm text-gray-500 mt-2">
                    <i class="fas fa-info-circle mr-1"></i>
                    Pastikan file sudah di-share dengan "Anyone with the link"
                </p>
                @error('attachment_url')
                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>

            <div class="flex items-center justify-between pt-4 border-t">
                <a href="{{ route('mahasiswa.skpi.index') }}" class="px-6 py-2 bg-gray-300 text-gray-700 rounded-lg hover:bg-gray-400 transition">
                    <i class="fas fa-arrow-left mr-2"></i> Kembali
                </a>
                <div class="space-x-2">
                    <button type="submit" name="status" value="draft" class="px-6 py-2 bg-gray-600 text-white rounded-lg hover:bg-gray-700 transition">
                        <i class="fas fa-save mr-2"></i> Simpan sebagai Draft
                    </button>
                    <button type="submit" name="status" value="submitted" class="px-6 py-2 bg-indigo-600 text-white rounded-lg hover:bg-indigo-700 transition">
                        <i class="fas fa-paper-plane mr-2"></i> Submit
                    </button>
                </div>
            </div>
        </form>
    </div>
</div>

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    const kategoriSelect = document.getElementById('kategori_skpi_id');
    const subKategoriSelect = document.getElementById('sub_kategori_skpi_id');
    const nilaiDisplay = document.getElementById('nilaiDisplay');
    const nilaiText = document.getElementById('nilaiText');
    const checkUrlBtn = document.getElementById('checkUrlBtn');
    const attachmentUrl = document.getElementById('attachment_url');
    const urlStatus = document.getElementById('urlStatus');

    kategoriSelect.addEventListener('change', function() {
        const kategoriId = this.value;
        const selectedOption = this.options[this.selectedIndex];
        const nilai = selectedOption.getAttribute('data-nilai');

        if (kategoriId) {
            // Show nilai
            nilaiText.textContent = nilai;
            nilaiDisplay.style.display = 'block';

            // Load sub kategori
            fetch(`/mahasiswa/kategori/${kategoriId}/sub-kategori`)
                .then(response => response.json())
                .then(data => {
                    subKategoriSelect.innerHTML = '<option value="">Pilih Sub Kategori</option>';
                    data.forEach(sub => {
                        const option = document.createElement('option');
                        option.value = sub.id;
                        option.textContent = sub.nama;
                        subKategoriSelect.appendChild(option);
                    });
                    subKategoriSelect.disabled = false;
                })
                .catch(error => {
                    console.error('Error:', error);
                    alert('Gagal memuat sub kategori');
                });
        } else {
            nilaiDisplay.style.display = 'none';
            subKategoriSelect.innerHTML = '<option value="">Pilih kategori terlebih dahulu</option>';
            subKategoriSelect.disabled = true;
        }
    });

    checkUrlBtn.addEventListener('click', function() {
        const url = attachmentUrl.value;
        if (!url) {
            urlStatus.innerHTML = '<p class="text-red-600 text-sm"><i class="fas fa-times-circle mr-1"></i> Masukkan URL terlebih dahulu</p>';
            return;
        }

        checkUrlBtn.disabled = true;
        checkUrlBtn.innerHTML = '<i class="fas fa-spinner fa-spin mr-2"></i> Mengecek...';
        urlStatus.innerHTML = '<p class="text-gray-600 text-sm"><i class="fas fa-spinner fa-spin mr-1"></i> Sedang mengecek aksesibilitas link...</p>';

        fetch('/mahasiswa/check-url', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
            },
            body: JSON.stringify({ url: url })
        })
        .then(response => response.json())
        .then(data => {
            if (data.accessible) {
                urlStatus.innerHTML = `<p class="text-green-600 text-sm"><i class="fas fa-check-circle mr-1"></i> ${data.message}</p>`;
            } else {
                urlStatus.innerHTML = `<p class="text-red-600 text-sm"><i class="fas fa-exclamation-circle mr-1"></i> ${data.message}</p>`;
            }
        })
        .catch(error => {
            urlStatus.innerHTML = '<p class="text-red-600 text-sm"><i class="fas fa-times-circle mr-1"></i> Gagal mengecek URL</p>';
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
