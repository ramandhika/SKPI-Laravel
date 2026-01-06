@extends('layouts.app')

@section('title', 'Edit Program Studi')
@section('page-title', 'Edit Data Prodi')

@section('content')

    <div class="max-w-2xl mx-auto">

        <div class="flex items-center justify-between mb-6">
            <a href="{{ route('admin.program-studi.index') }}"
                class="inline-flex items-center text-sm font-medium text-slate-500 hover:text-indigo-600 transition">
                <div
                    class="w-8 h-8 rounded-full bg-white border border-slate-200 flex items-center justify-center mr-2 shadow-sm">
                    <i class="fas fa-arrow-left"></i>
                </div>
                Kembali
            </a>
            <span class="px-3 py-1 bg-amber-50 text-amber-600 text-xs font-bold rounded-full border border-amber-100">
                Editing Mode
            </span>
        </div>

        <div class="bg-white rounded-2xl shadow-sm border border-slate-100 overflow-hidden">

            <div class="bg-amber-50/50 border-b border-amber-100 px-8 py-6">
                <h2 class="text-xl font-bold text-slate-800">Update Program Studi</h2>
                <p class="text-sm text-slate-500 mt-1">Perbarui data {{ $programStudi->nama }}.</p>
            </div>

            <form action="{{ route('admin.program-studi.update', $programStudi) }}" method="POST" class="p-8">
                @csrf
                @method('PUT')

                <div class="space-y-6">
                    <div>
                        <label class="block text-sm font-bold text-slate-700 mb-2">Kode Identifikasi <span
                                class="text-rose-500">*</span></label>
                        <input type="text" name="kode" value="{{ old('kode', $programStudi->kode) }}" required
                            maxlength="10"
                            class="w-full px-4 py-3 bg-slate-50 border border-slate-200 rounded-xl focus:bg-white focus:ring-2 focus:ring-indigo-500/20 focus:border-indigo-500 transition outline-none font-mono">
                        <p class="text-xs text-slate-400 mt-1">Digunakan untuk validasi NIM mahasiswa.</p>
                        @error('kode')
                            <p class="text-rose-500 text-xs mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label class="block text-sm font-bold text-slate-700 mb-2">Nama Prodi (Indonesia) <span
                                class="text-rose-500">*</span></label>
                        <input type="text" name="nama" value="{{ old('nama', $programStudi->nama) }}" required
                            class="w-full px-4 py-3 bg-slate-50 border border-slate-200 rounded-xl focus:bg-white focus:ring-2 focus:ring-indigo-500/20 focus:border-indigo-500 transition outline-none">
                        @error('nama')
                            <p class="text-rose-500 text-xs mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label class="block text-sm font-bold text-slate-700 mb-2">Nama Prodi (English)</label>
                        <input type="text" name="nama_en" value="{{ old('nama_en', $programStudi->nama_en) }}"
                            class="w-full px-4 py-3 bg-slate-50 border border-slate-200 rounded-xl focus:bg-white focus:ring-2 focus:ring-indigo-500/20 focus:border-indigo-500 transition outline-none">
                        @error('nama_en')
                            <p class="text-rose-500 text-xs mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label class="block text-sm font-bold text-slate-700 mb-2">Kaprodi / Validator</label>
                        <div class="relative">
                            <select name="dosen_id"
                                class="w-full px-4 py-3 bg-slate-50 border border-slate-200 rounded-xl focus:bg-white focus:ring-2 focus:ring-indigo-500/20 focus:border-indigo-500 transition outline-none appearance-none cursor-pointer">
                                <option value="">-- Pilih Dosen Pengelola --</option>
                                @foreach ($dosens as $dosen)
                                    <option value="{{ $dosen->id }}"
                                        {{ old('dosen_id', $programStudi->dosen_id) == $dosen->id ? 'selected' : '' }}>
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
                        class="px-8 py-3 bg-indigo-600 text-white font-bold rounded-xl hover:bg-indigo-700 transition shadow-lg shadow-indigo-500/30">
                        <i class="fas fa-sync-alt mr-2"></i> Update Data
                    </button>
                </div>
            </form>
        </div>
    </div>
@endsection
