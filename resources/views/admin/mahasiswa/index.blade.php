@extends('layouts.app')

@section('title', 'Kelola Mahasiswa')
@section('page-title', 'Kelola Mahasiswa')

@section('sidebar')
<a href="{{ route('admin.dashboard') }}" class="block px-6 py-3 hover:bg-indigo-700 transition">
    <i class="fas fa-home mr-3"></i> Dashboard
</a>
<a href="{{ route('admin.mahasiswa.index') }}" class="block px-6 py-3 bg-indigo-900 border-l-4 border-white">
    <i class="fas fa-users mr-3"></i> Mahasiswa
</a>
<a href="{{ route('admin.kategori.index') }}" class="block px-6 py-3 hover:bg-indigo-700 transition">
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
    <div class="flex justify-between items-center">
        <div class="flex gap-3">
            <a href="{{ route('admin.mahasiswa.create') }}" class="px-4 py-2 bg-indigo-600 text-white rounded-lg hover:bg-indigo-700 transition">
                <i class="fas fa-plus mr-2"></i> Tambah Mahasiswa
            </a>
            <button onclick="document.getElementById('importModal').classList.remove('hidden')" class="px-4 py-2 bg-green-600 text-white rounded-lg hover:bg-green-700 transition">
                <i class="fas fa-file-import mr-2"></i> Import CSV/Excel
            </button>
            <a href="{{ route('admin.export.mahasiswa') }}" class="px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition">
                <i class="fas fa-file-excel mr-2"></i> Export Excel
            </a>
        </div>
        <form method="GET" class="flex gap-2">
            <input type="text" name="search" value="{{ request('search') }}" placeholder="Cari NIM/Nama..." class="px-4 py-2 border rounded-lg">
            <select name="program_studi" class="px-4 py-2 border rounded-lg">
                <option value="">Semua Prodi</option>
                @foreach($programStudis as $prodi)
                    <option value="{{ $prodi->id }}" {{ request('program_studi') == $prodi->id ? 'selected' : '' }}>
                        {{ $prodi->nama }}
                    </option>
                @endforeach
            </select>
            <button type="submit" class="px-4 py-2 bg-gray-600 text-white rounded-lg hover:bg-gray-700">
                <i class="fas fa-search"></i>
            </button>
        </form>
    </div>
</div>

<div class="bg-white rounded-lg shadow overflow-hidden">
    <table class="w-full">
        <thead class="bg-gray-50">
            <tr>
                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">NIM</th>
                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Nama</th>
                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Email</th>
                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Program Studi</th>
                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Aksi</th>
            </tr>
        </thead>
        <tbody class="divide-y divide-gray-200">
            @forelse($mahasiswas as $mahasiswa)
            <tr class="hover:bg-gray-50">
                <td class="px-6 py-4 font-medium">{{ $mahasiswa->nim }}</td>
                <td class="px-6 py-4">{{ $mahasiswa->name }}</td>
                <td class="px-6 py-4">{{ $mahasiswa->email }}</td>
                <td class="px-6 py-4">
                    <span class="px-2 py-1 bg-indigo-100 text-indigo-800 rounded text-sm">
                        {{ $mahasiswa->programStudi ? $mahasiswa->programStudi->nama : '-' }}
                    </span>
                </td>
                <td class="px-6 py-4">
                    <div class="flex gap-2">
                        <a href="{{ route('admin.mahasiswa.edit', $mahasiswa) }}" class="text-blue-600 hover:text-blue-800">
                            <i class="fas fa-edit"></i>
                        </a>
                        <form action="{{ route('admin.mahasiswa.destroy', $mahasiswa) }}" method="POST" class="inline" onsubmit="return confirm('Yakin ingin menghapus?')">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="text-red-600 hover:text-red-800">
                                <i class="fas fa-trash"></i>
                            </button>
                        </form>
                    </div>
                </td>
            </tr>
            @empty
            <tr>
                <td colspan="5" class="px-6 py-8 text-center text-gray-500">
                    Tidak ada data mahasiswa
                </td>
            </tr>
            @endforelse
        </tbody>
    </table>
</div>

<div class="mt-4">
    {{ $mahasiswas->links() }}
</div>

<!-- Import Modal -->
<div id="importModal" class="hidden fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center z-50">
    <div class="bg-white rounded-lg p-6 max-w-md w-full">
        <h3 class="text-lg font-semibold mb-4">Import Mahasiswa</h3>
        <form action="{{ route('admin.mahasiswa.import') }}" method="POST" enctype="multipart/form-data">
            @csrf
            <div class="mb-4">
                <label class="block text-gray-700 mb-2">File CSV/Excel</label>
                <input type="file" name="file" accept=".csv,.xlsx,.xls" required class="w-full px-3 py-2 border rounded">
                <p class="text-sm text-gray-500 mt-2">Format: name, email, nim, password, program_studi_id</p>
            </div>
            <div class="flex justify-end gap-2">
                <button type="button" onclick="document.getElementById('importModal').classList.add('hidden')" class="px-4 py-2 bg-gray-300 rounded hover:bg-gray-400">
                    Batal
                </button>
                <button type="submit" class="px-4 py-2 bg-green-600 text-white rounded hover:bg-green-700">
                    Import
                </button>
            </div>
        </form>
    </div>
</div>
@endsection
