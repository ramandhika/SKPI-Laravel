@extends('layouts.app')

@section('title', 'Edit Mahasiswa')
@section('page-title', 'Edit Data Mahasiswa')

@section('content')

    <div class="max-w-4xl mx-auto">

        <div class="flex items-center justify-between mb-6">
            <a href="{{ route('admin.mahasiswa.index') }}"
                class="inline-flex items-center text-sm font-medium text-slate-500 hover:text-[#0F7287] transition">
                <div
                    class="w-8 h-8 rounded-full bg-white border border-slate-200 flex items-center justify-center mr-2 shadow-sm">
                    <i class="fas fa-arrow-left"></i>
                </div>
                Kembali ke Daftar
            </a>
            <span class="px-3 py-1 bg-amber-50 text-amber-600 text-xs font-bold rounded-full border border-amber-100">
                Mode Edit
            </span>
        </div>

        <div class="bg-white rounded-2xl shadow-sm border border-slate-100 overflow-hidden">

            <div class="bg-amber-50/50 border-b border-amber-100 px-8 py-6">
                <h2 class="text-xl font-bold text-slate-800">Update Data: {{ $mahasiswa->name }}</h2>
                <p class="text-sm text-slate-500 mt-1">Perbarui informasi mahasiswa dengan benar.</p>
            </div>

            <form action="{{ route('admin.mahasiswa.update', $mahasiswa) }}" method="POST" class="p-8">
                @csrf
                @method('PUT')

                <div class="grid grid-cols-1 md:grid-cols-2 gap-8 mb-8">

                    <div class="space-y-6">
                        <div>
                            <label class="block text-sm font-bold text-slate-700 mb-2">Nama Lengkap <span
                                    class="text-rose-500">*</span></label>
                            <input type="text" name="name" value="{{ old('name', $mahasiswa->name) }}" required
                                class="w-full px-4 py-3 bg-slate-50 border border-slate-200 rounded-xl focus:bg-white focus:ring-2 focus:ring-[#0C6C85]/20 focus:border-[#0C6C85] transition outline-none">
                            @error('name')
                                <p class="text-rose-500 text-xs mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        <div>
                            <label class="block text-sm font-bold text-slate-700 mb-2">Nomor Induk (NIM) <span
                                    class="text-rose-500">*</span></label>
                            <input type="text" name="nim" value="{{ old('nim', $mahasiswa->nim) }}" required
                                class="w-full px-4 py-3 bg-slate-50 border border-slate-200 rounded-xl focus:bg-white focus:ring-2 focus:ring-[#0C6C85]/20 focus:border-[#0C6C85] transition outline-none">
                            @error('nim')
                                <p class="text-rose-500 text-xs mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        <div>
                            <label class="block text-sm font-bold text-slate-700 mb-2">Program Studi <span
                                    class="text-rose-500">*</span></label>
                            <select name="program_studi_id" required
                                class="w-full px-4 py-3 bg-slate-50 border border-slate-200 rounded-xl focus:bg-white focus:ring-2 focus:ring-[#0C6C85]/20 focus:border-[#0C6C85] transition outline-none cursor-pointer">
                                <option value="">-- Pilih Program Studi --</option>
                                @foreach ($programStudis as $prodi)
                                    <option value="{{ $prodi->id }}"
                                        {{ old('program_studi_id', $mahasiswa->program_studi_id) == $prodi->id ? 'selected' : '' }}>
                                        {{ $prodi->nama }}
                                    </option>
                                @endforeach
                            </select>
                            @error('program_studi_id')
                                <p class="text-rose-500 text-xs mt-1">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>

                    <div class="space-y-6">
                        <div>
                            <label class="block text-sm font-bold text-slate-700 mb-2">Alamat Email <span
                                    class="text-rose-500">*</span></label>
                            <input type="email" name="email" value="{{ old('email', $mahasiswa->email) }}" required
                                class="w-full px-4 py-3 bg-slate-50 border border-slate-200 rounded-xl focus:bg-white focus:ring-2 focus:ring-[#0C6C85]/20 focus:border-[#0C6C85] transition outline-none">
                            @error('email')
                                <p class="text-rose-500 text-xs mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        <div>
                            <label class="block text-sm font-bold text-slate-700 mb-2">Password Baru</label>
                            <input type="password" name="password"
                                class="w-full px-4 py-3 bg-slate-50 border border-slate-200 rounded-xl focus:bg-white focus:ring-2 focus:ring-[#0C6C85]/20 focus:border-[#0C6C85] transition outline-none placeholder:text-slate-400"
                                placeholder="••••••••">
                            <p class="text-xs text-slate-400 mt-2 flex items-center">
                                <i class="fas fa-info-circle mr-1"></i> Biarkan kosong jika tidak ingin mengubah password.
                            </p>
                            @error('password')
                                <p class="text-rose-500 text-xs mt-1">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>
                </div>

                <div class="flex items-center justify-end gap-4 pt-6 border-t border-slate-100">
                    <button type="submit"
                        class="px-8 py-3 bg-[#0F7287] text-white font-bold rounded-xl hover:bg-[#064D62] transition shadow-lg shadow-[#0C6C85]/30">
                        <i class="fas fa-sync-alt mr-2"></i> Update Data
                    </button>
                </div>
            </form>
        </div>
    </div>
@endsection
