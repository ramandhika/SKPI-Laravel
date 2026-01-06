@extends('layouts.app')

@section('title', 'Kelola Kategori SKPI')
@section('page-title', 'Master Kategori')

@section('content')

    <div class="mb-8 flex flex-col sm:flex-row justify-between items-start sm:items-center gap-4">
        <div class="flex items-center gap-3">
            <div class="p-3 bg-indigo-50 rounded-xl text-indigo-600">
                <i class="fas fa-layer-group text-xl"></i>
            </div>
            <div>
                <h3 class="font-bold text-slate-800">Daftar Kategori</h3>
                <p class="text-sm text-slate-500">Atur kategori dan bobot nilai SKPI.</p>
            </div>
        </div>

        <a href="{{ route('admin.kategori.create') }}"
            class="inline-flex items-center justify-center px-5 py-2.5 bg-indigo-600 text-white font-bold rounded-xl hover:bg-indigo-700 transition shadow-lg shadow-indigo-500/30">
            <i class="fas fa-plus mr-2"></i> Tambah Kategori
        </a>
    </div>

    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
        @forelse($kategoris as $kategori)
            <div
                class="bg-white rounded-2xl shadow-sm border border-slate-100 overflow-hidden hover:shadow-md transition duration-300 flex flex-col h-full">

                <div class="p-6 border-b border-slate-50">
                    <div class="flex justify-between items-start mb-2">
                        <div
                            class="w-10 h-10 rounded-full bg-slate-50 border border-slate-100 flex items-center justify-center text-slate-400">
                            <i class="fas fa-tag"></i>
                        </div>
                        <div
                            class="flex items-center gap-1 px-2.5 py-1 rounded-lg bg-indigo-50 text-indigo-600 text-xs font-bold">
                            <i class="fas fa-list-ul"></i>
                            <span>{{ $kategori->sub_kategori_count }} Sub</span>
                        </div>
                    </div>
                    <h3 class="text-lg font-bold text-slate-800 mb-1">{{ $kategori->nama }}</h3>
                    @if ($kategori->nama_en)
                        <p class="text-xs text-slate-400 italic">{{ $kategori->nama_en }}</p>
                    @endif
                </div>

                <div class="p-6 flex-1">
                    <p class="text-sm text-slate-500 line-clamp-3 leading-relaxed">
                        {{ $kategori->deskripsi ?? 'Tidak ada deskripsi.' }}
                    </p>
                </div>

                <div class="p-4 bg-slate-50 border-t border-slate-100 flex gap-2">
                    <a href="{{ route('admin.kategori.sub-kategori', $kategori) }}"
                        class="flex-1 inline-flex items-center justify-center px-3 py-2 bg-white border border-slate-200 text-slate-600 text-sm font-semibold rounded-lg hover:border-indigo-300 hover:text-indigo-600 transition shadow-sm">
                        <i class="fas fa-folder-open mr-2"></i> Detail
                    </a>

                    <a href="{{ route('admin.kategori.edit', $kategori) }}"
                        class="inline-flex items-center justify-center w-10 h-10 bg-white border border-slate-200 text-amber-500 rounded-lg hover:bg-amber-50 hover:border-amber-200 transition shadow-sm">
                        <i class="fas fa-pencil-alt"></i>
                    </a>

                    <form action="{{ route('admin.kategori.destroy', $kategori) }}" method="POST" class="inline-block"
                        onsubmit="return confirm('Hapus kategori ini beserta semua sub-kategorinya?')">
                        @csrf
                        @method('DELETE')
                        <button type="submit"
                            class="inline-flex items-center justify-center w-10 h-10 bg-white border border-slate-200 text-rose-500 rounded-lg hover:bg-rose-50 hover:border-rose-200 transition shadow-sm">
                            <i class="fas fa-trash-alt"></i>
                        </button>
                    </form>
                </div>
            </div>
        @empty
            <div
                class="col-span-full flex flex-col items-center justify-center p-12 bg-white rounded-2xl border border-slate-100 border-dashed">
                <div class="w-16 h-16 bg-slate-50 rounded-full flex items-center justify-center mb-4 text-slate-300">
                    <i class="fas fa-box-open text-3xl"></i>
                </div>
                <h3 class="text-lg font-bold text-slate-700">Data Kosong</h3>
                <p class="text-slate-500 text-sm mt-1 mb-4">Belum ada kategori SKPI yang dibuat.</p>
                <a href="{{ route('admin.kategori.create') }}"
                    class="text-indigo-600 font-semibold text-sm hover:underline">Buat Kategori Baru &rarr;</a>
            </div>
        @endforelse
    </div>

    <div class="mt-8">
        {{ $kategoris->links() }}
    </div>

@endsection
