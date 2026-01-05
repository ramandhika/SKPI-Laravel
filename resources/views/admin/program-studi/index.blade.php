@extends('layouts.app')
@section('title', 'Kelola Program Studi')
@section('page-title', 'Kelola Program Studi')

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
<div class="mb-6">
    <a href="{{ route('admin.program-studi.create') }}" class="px-4 py-2 bg-indigo-600 text-white rounded-lg hover:bg-indigo-700 transition inline-block">
        <i class="fas fa-plus mr-2"></i> Tambah Program Studi
    </a>
</div>

<div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
    @forelse($programStudis as $prodi)
    <div class="bg-white rounded-lg shadow-md overflow-hidden">
        <div class="bg-indigo-600 text-white px-6 py-4">
            <div class="flex items-center justify-between">
                <h3 class="text-lg font-semibold">{{ $prodi->nama }}</h3>
                <span class="px-3 py-1 bg-white text-indigo-600 rounded-full text-sm font-bold">{{ $prodi->kode }}</span>
            </div>
            @if($prodi->nama_en)
                <p class="text-sm text-indigo-100 mt-1">{{ $prodi->nama_en }}</p>
            @endif
        </div>
        <div class="p-6">
            <div class="mb-4">
                <p class="text-sm text-gray-500">Dosen Pengelola:</p>
                <p class="font-medium">{{ $prodi->dosen ? $prodi->dosen->name : '-' }}</p>
            </div>
            <div class="flex gap-2">
                <a href="{{ route('admin.program-studi.edit', $prodi) }}" class="flex-1 text-center px-3 py-2 bg-yellow-600 text-white rounded hover:bg-yellow-700">
                    <i class="fas fa-edit"></i> Edit
                </a>
                <form action="{{ route('admin.program-studi.destroy', $prodi) }}" method="POST" class="inline" onsubmit="return confirm('Yakin ingin menghapus?')">
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
        Belum ada program studi
    </div>
    @endforelse
</div>

<div class="mt-6">
    {{ $programStudis->links() }}
</div>
@endsection