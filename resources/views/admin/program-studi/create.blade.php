@extends('layouts.app')
@section('title', 'Tambah Program Studi')
@section('page-title', 'Tambah Program Studi')

@section('sidebar')
<a href="{{ route('admin.dashboard') }}" class="block px-6 py-3 hover:bg-indigo-700 transition">
    <i class="fas fa-home mr-3"></i> Dashboard
</a>
<a href="{{ route('admin.mahasiswa.index') }}" class="block px-6 py-3 hover:bg-indigo-700 transition">
    <i class="fas fa-users mr-3"></i> Mahasiswa
</a>
<a href="{{ route('admin.kategori.index') }}" class="block px-6 py-3 hover:bg-indigo-700 transition">
    <i class="fas fa-list mr-3"></i> Kategori SKPI
</a>
<a href="{{ route('admin.periode.index') }}" class="block px-6 py-3 hover:bg-indigo-700 transition">
    <i class="fas fa-calendar mr-3"></i> Periode Input
</a>
<a href="{{ route('admin.program-studi.index') }}" class="block px-6 py-3 bg-indigo-900 border-l-4 border-white">
    <i class="fas fa-graduation-cap mr-3"></i> Program Studi
</a>
@endsection

@section('content')
<div class="max-w-2xl mx-auto">
    <div class="bg-white rounded-lg shadow-md p-6">
        <div class="bg-blue-50 border border-blue-200 rounded-lg p-4 mb-6">
            <p class="text-sm text-blue-800">
                <i class="fas fa-info-circle mr-2"></i>
                <strong>Kode Program Studi</strong> digunakan untuk mencocokkan NIM mahasiswa. Contoh: Kode "4" untuk NIM 204xxxxx (Sistem Informasi), Kode "5" untuk NIM 215xxxxx (Informatika)
            </p>
        </div>

        <form action="{{ route('admin.program-studi.store') }}" method="POST">
            @csrf
            
            <div class="mb-4">
                <label class="block text-gray-700 font-semibold mb-2">Kode Program Studi <span class="text-red-500">*</span></label>
                <input type="text" name="kode" value="{{ old('kode') }}" required maxlength="10" class="w-full px-4 py-2 border rounded-lg focus:ring-2 focus:ring-indigo-500" placeholder="Contoh: 4 atau 5">
                <p class="text-xs text-gray-500 mt-1">3 digit terakhir NIM akan dicocokkan dengan kode ini</p>
                @error('kode')<p class="text-red-500 text-sm mt-1">{{ $message }}</p>@enderror
            </div>

            <div class="mb-4">
                <label class="block text-gray-700 font-semibold mb-2">Nama Program Studi (Indonesia) <span class="text-red-500">*</span></label>
                <input type="text" name="nama" value="{{ old('nama') }}" required class="w-full px-4 py-2 border rounded-lg focus:ring-2 focus:ring-indigo-500" placeholder="Contoh: Sistem Informasi">
                @error('nama')<p class="text-red-500 text-sm mt-1">{{ $message }}</p>@enderror
            </div>

            <div class="mb-4">
                <label class="block text-gray-700 font-semibold mb-2">Nama Program Studi (English)</label>
                <input type="text" name="nama_en" value="{{ old('nama_en') }}" class="w-full px-4 py-2 border rounded-lg focus:ring-2 focus:ring-indigo-500" placeholder="Contoh: Information Systems">
                @error('nama_en')<p class="text-red-500 text-sm mt-1">{{ $message }}</p>@enderror
            </div>

            <div class="mb-4">
                <label class="block text-gray-700 font-semibold mb-2">Dosen Pengelola/Kaprodi</label>
                <select name="dosen_id" class="w-full px-4 py-2 border rounded-lg focus:ring-2 focus:ring-indigo-500">
                    <option value="">Pilih Dosen (Opsional)</option>
                    @foreach($dosens as $dosen)
                        <option value="{{ $dosen->id }}" {{ old('dosen_id') == $dosen->id ? 'selected' : '' }}>
                            {{ $dosen->name }} ({{ $dosen->nip }})
                        </option>
                    @endforeach
                </select>
                @error('dosen_id')<p class="text-red-500 text-sm mt-1">{{ $message }}</p>@enderror
            </div>

            <div class="flex justify-between pt-4 border-t">
                <a href="{{ route('admin.program-studi.index') }}" class="px-6 py-2 bg-gray-300 text-gray-700 rounded-lg hover:bg-gray-400">
                    <i class="fas fa-arrow-left mr-2"></i> Kembali
                </a>
                <button type="submit" class="px-6 py-2 bg-indigo-600 text-white rounded-lg hover:bg-indigo-700">
                    <i class="fas fa-save mr-2"></i> Simpan
                </button>
            </div>
        </form>
    </div>
</div>
@endsection