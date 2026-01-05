@extends('layouts.app')

@section('title', 'Sub Kategori - ' . $kategori->nama)
@section('page-title', 'Sub Kategori: ' . $kategori->nama)

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
<div class="mb-6 flex justify-between items-center">
    <a href="{{ route('admin.kategori.index') }}" class="text-indigo-600 hover:text-indigo-800">
        <i class="fas fa-arrow-left mr-2"></i> Kembali ke Kategori
    </a>
    <button onclick="document.getElementById('createModal').classList.remove('hidden')" class="px-4 py-2 bg-indigo-600 text-white rounded-lg hover:bg-indigo-700">
        <i class="fas fa-plus mr-2"></i> Tambah Sub Kategori
    </button>
</div>

<div class="bg-white rounded-lg shadow overflow-hidden">
    <div class="px-6 py-4 bg-indigo-50 border-b">
        <h3 class="text-lg font-semibold text-indigo-900">{{ $kategori->nama }}</h3>
        <p class="text-sm text-indigo-700">Nilai: {{ $kategori->nilai }} Poin</p>
    </div>
    <table class="w-full">
        <thead class="bg-gray-50">
            <tr>
                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Nama (ID)</th>
                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Nama (EN)</th>
                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Aksi</th>
            </tr>
        </thead>
        <tbody class="divide-y divide-gray-200">
            @forelse($subKategoris as $sub)
            <tr class="hover:bg-gray-50">
                <td class="px-6 py-4">{{ $sub->nama }}</td>
                <td class="px-6 py-4 text-gray-600">{{ $sub->nama_en ?? '-' }}</td>
                <td class="px-6 py-4">
                    <div class="flex gap-2">
                        <button onclick="editSubKategori({{ $sub->id }}, '{{ $sub->nama }}', '{{ $sub->nama_en }}', '{{ $sub->deskripsi }}')" class="text-blue-600 hover:text-blue-800">
                            <i class="fas fa-edit"></i>
                        </button>
                        <form action="{{ route('admin.kategori.sub-kategori.destroy', [$kategori, $sub]) }}" method="POST" class="inline" onsubmit="return confirm('Yakin ingin menghapus?')">
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
                <td colspan="3" class="px-6 py-8 text-center text-gray-500">
                    Belum ada sub kategori
                </td>
            </tr>
            @endforelse
        </tbody>
    </table>
</div>

<!-- Create Modal -->
<div id="createModal" class="hidden fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center z-50">
    <div class="bg-white rounded-lg p-6 max-w-md w-full">
        <h3 class="text-lg font-semibold mb-4">Tambah Sub Kategori</h3>
        <form action="{{ route('admin.kategori.sub-kategori.store', $kategori) }}" method="POST">
            @csrf
            <div class="mb-4">
                <label class="block text-gray-700 mb-2">Nama (Indonesia) <span class="text-red-500">*</span></label>
                <input type="text" name="nama" required class="w-full px-3 py-2 border rounded">
            </div>
            <div class="mb-4">
                <label class="block text-gray-700 mb-2">Nama (English)</label>
                <input type="text" name="nama_en" class="w-full px-3 py-2 border rounded">
            </div>
            <div class="mb-4">
                <label class="block text-gray-700 mb-2">Deskripsi</label>
                <textarea name="deskripsi" rows="3" class="w-full px-3 py-2 border rounded"></textarea>
            </div>
            <div class="flex justify-end gap-2">
                <button type="button" onclick="document.getElementById('createModal').classList.add('hidden')" class="px-4 py-2 bg-gray-300 rounded hover:bg-gray-400">
                    Batal
                </button>
                <button type="submit" class="px-4 py-2 bg-indigo-600 text-white rounded hover:bg-indigo-700">
                    Simpan
                </button>
            </div>
        </form>
    </div>
</div>

<!-- Edit Modal -->
<div id="editModal" class="hidden fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center z-50">
    <div class="bg-white rounded-lg p-6 max-w-md w-full">
        <h3 class="text-lg font-semibold mb-4">Edit Sub Kategori</h3>
        <form id="editForm" method="POST">
            @csrf
            @method('PUT')
            <div class="mb-4">
                <label class="block text-gray-700 mb-2">Nama (Indonesia) <span class="text-red-500">*</span></label>
                <input type="text" id="edit_nama" name="nama" required class="w-full px-3 py-2 border rounded">
            </div>
            <div class="mb-4">
                <label class="block text-gray-700 mb-2">Nama (English)</label>
                <input type="text" id="edit_nama_en" name="nama_en" class="w-full px-3 py-2 border rounded">
            </div>
            <div class="mb-4">
                <label class="block text-gray-700 mb-2">Deskripsi</label>
                <textarea id="edit_deskripsi" name="deskripsi" rows="3" class="w-full px-3 py-2 border rounded"></textarea>
            </div>
            <div class="flex justify-end gap-2">
                <button type="button" onclick="document.getElementById('editModal').classList.add('hidden')" class="px-4 py-2 bg-gray-300 rounded hover:bg-gray-400">
                    Batal
                </button>
                <button type="submit" class="px-4 py-2 bg-indigo-600 text-white rounded hover:bg-indigo-700">
                    Update
                </button>
            </div>
        </form>
    </div>
</div>

@push('scripts')
<script>
function editSubKategori(id, nama, nama_en, deskripsi) {
    document.getElementById('edit_nama').value = nama;
    document.getElementById('edit_nama_en').value = nama_en || '';
    document.getElementById('edit_deskripsi').value = deskripsi || '';
    document.getElementById('editForm').action = `/admin/kategori/{{ $kategori->id }}/sub-kategori/${id}`;
    document.getElementById('editModal').classList.remove('hidden');
}
</script>
@endpush
@endsection
