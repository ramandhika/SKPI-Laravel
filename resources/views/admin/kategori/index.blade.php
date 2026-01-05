@extends('layouts.app')

@section('title', 'Kelola Kategori SKPI')
@section('page-title', 'Kelola Kategori SKPI')

@section('sidebar')
<a href="{{ route('admin.dashboard') }}" class="block px-6 py-3 hover:bg-indigo-700 transition">
    <i class="fas fa-home mr-3"></i> Dashboard
</a>
<a href="{{ route('admin.mahasiswa.index') }}" class="block px-6 py-3 hover:bg-indigo-700 transition">
    <i class="fas fa-users mr-3"></i> Mahasiswa
</a>
<a href="{{ route('admin.kategori.index') }}" class="block px-6 py-3 bg-indigo-900 border-l-4 border-white">
    <i class="fas fa-list mr-3"></i> Kategori SKPI
</a>
<a href="{{ route('admin.periode.index') }}" class="block px-6 py-3 hover:bg-indigo-700 transition">
    <i class="fas fa-calendar mr-3"></i> Periode Input
</a>
<a href="{{ route('admin.program-studi.index') }}" class="block px-6 py-3 hover:bg-indigo-700 transition">
    <i class="fas fa-graduation-cap mr-3"></i> Program Studi
</a>
@endsection

@section('content')
<div class="mb-6">
    <a href="{{ route('admin.kategori.create') }}" class="px-4 py-2 bg-indigo-600 text-white rounded-lg hover:bg-indigo-700 transition inline-block">
        <i class="fas fa-plus mr-2"></i> Tambah Kategori
    </a>
</div>

<div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
    @forelse($kategoris as $kategori)
    <div class="bg-white rounded-lg shadow-md overflow-hidden">
        <div class="bg-indigo-600 text-white px-6 py-4">
            <h3 class="text-lg font-semibold">{{ $kategori->nama }}</h3>
            @if($kategori->nama_en)
                <p class="text-sm text-indigo-100">{{ $kategori->nama_en }}</p>
            @endif
        </div>
        <div class="p-6">
            <div class="mb-4">
                <span class="text-2xl font-bold text-indigo-600">{{ $kategori->nilai }}</span>
                <span class="text-gray-600 ml-2">Poin</span>
            </div>
            @if($kategori->deskripsi)
                <p class="text-gray-600 text-sm mb-4">{{ Str::limit($kategori->deskripsi, 100) }}</p>
            @endif
            <div class="mb-4">
                <span class="text-sm text-gray-500">
                    <i class="fas fa-layer-group mr-1"></i>
                    {{ $kategori->sub_kategori_count }} Sub Kategori
                </span>
            </div>
            <div class="flex gap-2">
                <a href="{{ route('admin.kategori.sub-kategori', $kategori) }}" class="flex-1 text-center px-3 py-2 bg-blue-600 text-white rounded hover:bg-blue-700 text-sm">
                    <i class="fas fa-list mr-1"></i> Sub Kategori
                </a>
                <a href="{{ route('admin.kategori.edit', $kategori) }}" class="px-3 py-2 bg-yellow-600 text-white rounded hover:bg-yellow-700">
                    <i class="fas fa-edit"></i>
                </a>
                <form action="{{ route('admin.kategori.destroy', $kategori) }}" method="POST" class="inline" onsubmit="return confirm('Yakin ingin menghapus?')">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="px-3 py-2 bg-red-600 text-white rounded hover:bg-red-700">
                        <i class="fas fa-trash"></i>
                    </button>
                </form>
            </div>
        </div>
    </div>
    @empty
    <div class="col-span-3 bg-white rounded-lg shadow p-8 text-center text-gray-500">
        Belum ada kategori SKPI
    </div>
    @endforelse
</div>

<div class="mt-6">
    {{ $kategoris->links() }}
</div>
@endsection
