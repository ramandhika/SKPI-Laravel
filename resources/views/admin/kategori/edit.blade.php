@extends('layouts.app')

@section('title', 'Edit Kategori SKPI')
@section('page-title', 'Edit Kategori')

@section('content')

    <div class="max-w-3xl mx-auto">

        <div class="flex items-center justify-between mb-6">
            <a href="{{ route('admin.kategori.index') }}"
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
                <h2 class="text-xl font-bold text-slate-800">Update Kategori</h2>
                <p class="text-sm text-slate-500 mt-1">Perbarui informasi {{ $kategori->nama }}.</p>
            </div>

            <form action="{{ route('admin.kategori.update', $kategori) }}" method="POST" class="p-8">
                @csrf
                @method('PUT')

                <div class="space-y-6">
                    <div>
                        <label class="block text-sm font-bold text-slate-700 mb-2">Nama Kategori (Indonesia) <span
                                class="text-rose-500">*</span></label>
                        <input type="text" name="nama" value="{{ old('nama', $kategori->nama) }}" required
                            class="w-full px-4 py-3 bg-slate-50 border border-slate-200 rounded-xl focus:bg-white focus:ring-2 focus:ring-indigo-500/20 focus:border-indigo-500 transition outline-none">
                        @error('nama')
                            <p class="text-rose-500 text-xs mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label class="block text-sm font-bold text-slate-700 mb-2">Nama Kategori (English)</label>
                        <input type="text" name="nama_en" value="{{ old('nama_en', $kategori->nama_en) }}"
                            class="w-full px-4 py-3 bg-slate-50 border border-slate-200 rounded-xl focus:bg-white focus:ring-2 focus:ring-indigo-500/20 focus:border-indigo-500 transition outline-none">
                        @error('nama_en')
                            <p class="text-rose-500 text-xs mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label class="block text-sm font-bold text-slate-700 mb-2">Deskripsi</label>
                        <textarea name="deskripsi" rows="4"
                            class="w-full px-4 py-3 bg-slate-50 border border-slate-200 rounded-xl focus:bg-white focus:ring-2 focus:ring-indigo-500/20 focus:border-indigo-500 transition outline-none resize-none">{{ old('deskripsi', $kategori->deskripsi) }}</textarea>
                        @error('deskripsi')
                            <p class="text-rose-500 text-xs mt-1">{{ $message }}</p>
                        @enderror
                    </div>
                </div>

                <div class="flex items-center justify-end gap-4 pt-8 border-t border-slate-100 mt-8">
                    <button type="submit"
                        class="px-8 py-3 bg-indigo-600 text-white font-bold rounded-xl hover:bg-indigo-700 transition shadow-lg shadow-indigo-500/30">
                        <i class="fas fa-sync-alt mr-2"></i> Update Kategori
                    </button>
                </div>
            </form>
        </div>
    </div>
@endsection
