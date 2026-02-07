@extends('layouts.app')

@section('title', 'Kelola Program Studi')
@section('page-title', 'Program Studi')

@section('content')

    <div class="mb-8 flex flex-col sm:flex-row justify-between items-start sm:items-center gap-4">
        <div class="flex items-center gap-3">
            <div class="p-3 bg-[#f0f9fc] rounded-xl text-[#0F7287]">
                <i class="fas fa-graduation-cap text-xl"></i>
            </div>
            <div>
                <h3 class="font-bold text-slate-800">Daftar Program Studi</h3>
                <p class="text-sm text-slate-500">Kelola data prodi dan dosen pengelola.</p>
            </div>
        </div>

        <a href="{{ route('admin.program-studi.create') }}"
            class="inline-flex items-center justify-center px-5 py-2.5 bg-[#0F7287] text-white font-bold rounded-xl hover:bg-[#064D62] transition shadow-lg shadow-[#0C6C85]/30">
            <i class="fas fa-plus mr-2"></i> Tambah Prodi
        </a>
    </div>

    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
        @forelse($programStudis as $prodi)
            <div
                class="bg-white rounded-2xl shadow-sm border border-slate-100 overflow-hidden hover:shadow-md transition duration-300 group">
                <div class="bg-gradient-to-r from-[#0F7287] to-[#064D62] p-6 relative overflow-hidden">
                    <div
                        class="absolute top-0 right-0 w-24 h-24 bg-white/10 rounded-full blur-2xl -mr-10 -mt-10 pointer-events-none">
                    </div>

                    <div class="flex justify-between items-start relative z-10">
                        <div>
                            <h3 class="text-lg font-bold text-white leading-tight">{{ $prodi->nama }}</h3>
                            @if ($prodi->nama_en)
                                <p class="text-xs text-[#fbc21d] mt-1 italic">{{ $prodi->nama_en }}</p>
                            @endif
                        </div>
                        <span
                            class="inline-flex items-center justify-center h-8 px-3 bg-white/20 backdrop-blur-sm text-white text-xs font-mono font-bold rounded-lg border border-white/10">
                            {{ $prodi->kode }}
                        </span>
                    </div>
                </div>

                <div class="p-6">
                    <div class="mb-6 flex items-start gap-3">
                        <div
                            class="w-10 h-10 rounded-full bg-slate-50 flex items-center justify-center text-slate-400 border border-slate-100 flex-shrink-0">
                            <i class="fas fa-user-tie"></i>
                        </div>
                        <div>
                            <p class="text-xs font-bold text-slate-400 uppercase tracking-wider mb-0.5">Dosen Pengelola</p>
                            <p class="text-sm font-semibold text-slate-700">
                                {{ $prodi->dosen ? $prodi->dosen->name : 'Belum ditentukan' }}
                            </p>
                        </div>
                    </div>

                    <div class="flex gap-3 pt-4 border-t border-slate-50">
                        <a href="{{ route('admin.program-studi.edit', $prodi) }}"
                            class="flex-1 inline-flex items-center justify-center px-4 py-2 bg-amber-50 text-amber-600 text-sm font-semibold rounded-lg hover:bg-amber-100 transition border border-amber-100">
                            <i class="fas fa-edit mr-2"></i> Edit
                        </a>

                        <form action="{{ route('admin.program-studi.destroy', $prodi) }}" method="POST"
                            class="inline-block"
                            onsubmit="return confirm('Yakin ingin menghapus Program Studi ini? Data terkait mungkin akan terpengaruh.')">
                            @csrf
                            @method('DELETE')
                            <button type="submit"
                                class="inline-flex items-center justify-center w-10 h-10 bg-white text-rose-500 rounded-lg hover:bg-rose-50 transition border border-slate-200 hover:border-rose-200">
                                <i class="fas fa-trash-alt"></i>
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        @empty
            <div
                class="col-span-full flex flex-col items-center justify-center p-12 bg-white rounded-2xl border border-slate-100 border-dashed">
                <div class="w-16 h-16 bg-slate-50 rounded-full flex items-center justify-center mb-4 text-slate-300">
                    <i class="fas fa-university text-3xl"></i>
                </div>
                <h3 class="text-lg font-bold text-slate-700">Belum ada Program Studi</h3>
                <p class="text-slate-500 text-sm mt-1 mb-4">Silakan tambahkan data prodi baru.</p>
                <a href="{{ route('admin.program-studi.create') }}"
                    class="text-[#0F7287] font-semibold text-sm hover:underline">Tambah Prodi Baru &rarr;</a>
            </div>
        @endforelse
    </div>

    <div class="mt-8">
        {{ $programStudis->links() }}
    </div>

@endsection
