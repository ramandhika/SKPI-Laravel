@extends('layouts.app')

@section('title', 'Tambah Program Studi')
@section('page-title', 'Form Prodi Baru')

@section('content')

    <div class="max-w-2xl mx-auto">

        <a href="{{ route('admin.program-studi.index') }}"
            class="inline-flex items-center text-sm font-medium text-slate-500 hover:text-[#0F7287] mb-6 transition">
            <div
                class="w-8 h-8 rounded-full bg-white border border-slate-200 flex items-center justify-center mr-2 shadow-sm">
                <i class="fas fa-arrow-left"></i>
            </div>
            Kembali ke Daftar
        </a>

        <div class="bg-white rounded-2xl shadow-sm border border-slate-100 overflow-hidden">

            <div class="bg-slate-50/50 border-b border-slate-100 px-8 py-6">
                <h2 class="text-xl font-bold text-slate-800">Tambah Program Studi</h2>
                <p class="text-sm text-slate-500 mt-1">Lengkapi informasi prodi di bawah ini.</p>
            </div>

            <div class="px-8 pt-6 pb-2">
                <div class="flex items-start gap-3 p-4 bg-blue-50 border border-blue-100 rounded-xl text-sm text-blue-700">
                    <i class="fas fa-info-circle mt-0.5 text-lg flex-shrink-0"></i>
                    <div>
                        <span class="font-bold block mb-1">Informasi Kode Prodi</span>
                        Kode ini digunakan untuk identifikasi NIM mahasiswa secara otomatis.
                        <br><span class="opacity-80">Contoh: Kode "4" untuk Sistem Informasi (20<b>4</b>xxxxx).</span>
                    </div>
                </div>
            </div>

            <form action="{{ route('admin.program-studi.store') }}" method="POST" class="p-8">
                @csrf

                <div class="space-y-6">
                    <div>
                        <label class="block text-sm font-bold text-slate-700 mb-2">Kode Identifikasi <span
                                class="text-rose-500">*</span></label>
                        <input type="text" name="kode" value="{{ old('kode') }}" required maxlength="10"
                            class="w-full px-4 py-3 bg-slate-50 border border-slate-200 rounded-xl focus:bg-white focus:ring-2 focus:ring-[#0C6C85]/20 focus:border-[#0C6C85] transition outline-none font-mono placeholder:text-slate-400"
                            placeholder="Contoh: 4">
                        @error('kode')
                            <p class="text-rose-500 text-xs mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label class="block text-sm font-bold text-slate-700 mb-2">Nama Prodi (Indonesia) <span
                                class="text-rose-500">*</span></label>
                        <input type="text" name="nama" value="{{ old('nama') }}" required
                            class="w-full px-4 py-3 bg-slate-50 border border-slate-200 rounded-xl focus:bg-white focus:ring-2 focus:ring-[#0C6C85]/20 focus:border-[#0C6C85] transition outline-none placeholder:text-slate-400"
                            placeholder="Contoh: Sistem Informasi">
                        @error('nama')
                            <p class="text-rose-500 text-xs mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label class="block text-sm font-bold text-slate-700 mb-2">Nama Prodi (English)</label>
                        <input type="text" name="nama_en" value="{{ old('nama_en') }}"
                            class="w-full px-4 py-3 bg-slate-50 border border-slate-200 rounded-xl focus:bg-white focus:ring-2 focus:ring-[#0C6C85]/20 focus:border-[#0C6C85] transition outline-none placeholder:text-slate-400"
                            placeholder="Contoh: Information Systems">
                        @error('nama_en')
                            <p class="text-rose-500 text-xs mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label class="block text-sm font-bold text-slate-700 mb-2">Kaprodi / Validator</label>
                        <div class="relative">
                            <select name="dosen_id"
                                class="w-full px-4 py-3 bg-slate-50 border border-slate-200 rounded-xl focus:bg-white focus:ring-2 focus:ring-[#0C6C85]/20 focus:border-[#0C6C85] transition outline-none appearance-none cursor-pointer">
                                <option value="">-- Pilih Dosen Pengelola --</option>
                                @foreach ($dosens as $dosen)
                                    <option value="{{ $dosen->id }}"
                                        {{ old('dosen_id') == $dosen->id ? 'selected' : '' }}>
                                        {{ $dosen->name }} ({{ $dosen->nip ?? 'N/A' }})
                                    </option>
                                @endforeach
                            </select>
                            <i
                                class="fas fa-chevron-down absolute right-4 top-4 text-slate-400 text-xs pointer-events-none"></i>
                        </div>
                        @error('dosen_id')
                            <p class="text-rose-500 text-xs mt-1">{{ $message }}</p>
                        @enderror
                    </div>
                </div>

                <div class="flex items-center justify-end gap-4 pt-8 border-t border-slate-100 mt-8">
                    <button type="submit"
                        class="px-8 py-3 bg-[#0F7287] text-white font-bold rounded-xl hover:bg-[#064D62] transition shadow-lg shadow-[#0C6C85]/30">
                        <i class="fas fa-save mr-2"></i> Simpan Data
                    </button>
                </div>
            </form>
        </div>
    </div>
@endsection
