@extends('layouts.app')

@section('title', 'Tambah Periode')
@section('page-title', 'Buat Periode Baru')

@section('content')

    <div class="max-w-2xl mx-auto">

        <a href="{{ route('admin.periode.index') }}"
            class="inline-flex items-center text-sm font-medium text-slate-500 hover:text-[#0F7287] mb-6 transition">
            <div
                class="w-8 h-8 rounded-full bg-white border border-slate-200 flex items-center justify-center mr-2 shadow-sm">
                <i class="fas fa-arrow-left"></i>
            </div>
            Kembali ke Daftar
        </a>

        <div class="bg-white rounded-2xl shadow-sm border border-slate-100 overflow-hidden">

            <div class="bg-slate-50/50 border-b border-slate-100 px-8 py-6">
                <h2 class="text-xl font-bold text-slate-800">Form Periode Input</h2>
                <p class="text-sm text-slate-500 mt-1">Tentukan rentang waktu mahasiswa dapat mengisi SKPI.</p>
            </div>

            <form action="{{ route('admin.periode.store') }}" method="POST" class="p-8">
                @csrf

                <div class="space-y-6">
                    <div>
                        <label class="block text-sm font-bold text-slate-700 mb-2">Nama Periode <span
                                class="text-rose-500">*</span></label>
                        <input type="text" name="nama" value="{{ old('nama') }}" required
                            class="w-full px-4 py-3 bg-slate-50 border border-slate-200 rounded-xl focus:bg-white focus:ring-2 focus:ring-[#0C6C85]/20 focus:border-[#0C6C85] transition outline-none placeholder:text-slate-400"
                            placeholder="Contoh: Wisuda Periode I Tahun 2025">
                        @error('nama')
                            <p class="text-rose-500 text-xs mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div>
                            <label class="block text-sm font-bold text-slate-700 mb-2">Tanggal Mulai <span
                                    class="text-rose-500">*</span></label>
                            <input type="date" name="tanggal_mulai" value="{{ old('tanggal_mulai') }}" required
                                class="w-full px-4 py-3 bg-slate-50 border border-slate-200 rounded-xl focus:bg-white focus:ring-2 focus:ring-[#0C6C85]/20 focus:border-[#0C6C85] transition outline-none text-slate-600">
                            @error('tanggal_mulai')
                                <p class="text-rose-500 text-xs mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        <div>
                            <label class="block text-sm font-bold text-slate-700 mb-2">Tanggal Selesai <span
                                    class="text-rose-500">*</span></label>
                            <input type="date" name="tanggal_selesai" value="{{ old('tanggal_selesai') }}" required
                                class="w-full px-4 py-3 bg-slate-50 border border-slate-200 rounded-xl focus:bg-white focus:ring-2 focus:ring-[#0C6C85]/20 focus:border-[#0C6C85] transition outline-none text-slate-600">
                            @error('tanggal_selesai')
                                <p class="text-rose-500 text-xs mt-1">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>

                    <div class="pt-2">
                        <label
                            class="flex items-center gap-3 p-4 border border-slate-200 rounded-xl cursor-pointer hover:bg-slate-50 transition group">
                            <input type="checkbox" name="is_active" value="1" {{ old('is_active') ? 'checked' : '' }}
                                class="w-5 h-5 text-[#0F7287] border-slate-300 rounded focus:ring-[#0C6C85] focus:ring-2 cursor-pointer">
                            <div>
                                <span class="block font-bold text-slate-700 group-hover:text-[#064D62]">Langsung
                                    Aktifkan</span>
                                <span class="text-xs text-slate-500">Mahasiswa dapat langsung melakukan input jika
                                    dicentang.</span>
                            </div>
                        </label>
                    </div>
                </div>

                <div class="flex items-center justify-end gap-4 pt-8 border-t border-slate-100 mt-8">
                    <button type="submit"
                        class="px-8 py-3 bg-[#0F7287] text-white font-bold rounded-xl hover:bg-[#064D62] transition shadow-lg shadow-[#0C6C85]/30">
                        <i class="fas fa-save mr-2"></i> Simpan Periode
                    </button>
                </div>
            </form>
        </div>
    </div>
@endsection
