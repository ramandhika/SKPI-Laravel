@extends('layouts.app')
@section('title', 'Data SKPI')
@section('page-title', 'Data SKPI Saya')

@section('sidebar')
<a href="{{ route('mahasiswa.dashboard') }}" class="block px-6 py-3 hover:bg-indigo-700 transition">
    <i class="fas fa-home mr-3"></i> Dashboard
</a>
<a href="{{ route('mahasiswa.skpi.index') }}" class="block px-6 py-3 bg-indigo-900 border-l-4 border-white">
    <i class="fas fa-file-alt mr-3"></i> Data SKPI
</a>
<a href="{{ route('mahasiswa.skpi.create') }}" class="block px-6 py-3 hover:bg-indigo-700 transition">
    <i class="fas fa-plus mr-3"></i> Tambah SKPI
</a>
@endsection

@section('content')
<div class="mb-6 flex justify-between">
    <form method="GET" class="flex gap-2">
        <select name="status" class="px-4 py-2 border rounded-lg">
            <option value="">Semua Status</option>
            <option value="draft" {{ request('status')=='draft'?'selected':'' }}>Draft</option>
            <option value="submitted" {{ request('status')=='submitted'?'selected':'' }}>Submitted</option>
            <option value="accepted" {{ request('status')=='accepted'?'selected':'' }}>Accepted</option>
            <option value="rejected" {{ request('status')=='rejected'?'selected':'' }}>Rejected</option>
        </select>
        <button type="submit" class="px-4 py-2 bg-gray-600 text-white rounded-lg hover:bg-gray-700">
            <i class="fas fa-filter"></i> Filter
        </button>
    </form>
    <a href="{{ route('mahasiswa.skpi.create') }}" class="px-4 py-2 bg-indigo-600 text-white rounded-lg hover:bg-indigo-700">
        <i class="fas fa-plus mr-2"></i> Tambah SKPI
    </a>
</div>

<div class="bg-white rounded-lg shadow overflow-hidden">
    <table class="w-full">
        <thead class="bg-gray-50">
            <tr>
                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Kategori</th>
                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Sub Kategori</th>
                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Kegiatan</th>
                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Status</th>
                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Aksi</th>
            </tr>
        </thead>
        <tbody class="divide-y divide-gray-200">
            @forelse($skpis as $skpi)
            <tr class="hover:bg-gray-50">
                <td class="px-6 py-4">
                    <div>
                        <p class="font-medium">{{ $skpi->kategori->nama }}</p>
                        <p class="text-sm text-gray-500">Nilai: {{ $skpi->kategori->nilai }}</p>
                    </div>
                </td>
                <td class="px-6 py-4">{{ $skpi->subKategori->nama }}</td>
                <td class="px-6 py-4">{{ $skpi->nama_kegiatan }}</td>
                <td class="px-6 py-4">
                    @php $colors = ['draft'=>'gray','submitted'=>'yellow','accepted'=>'green','rejected'=>'red'];
                         $color = $colors[$skpi->status]??'gray'; @endphp
                    <span class="px-2 py-1 bg-{{$color}}-100 text-{{$color}}-800 rounded-full text-xs font-medium">
                        {{ ucfirst($skpi->status) }}
                    </span>
                    @if($skpi->catatan_dosen)
                    <p class="text-xs text-gray-600 mt-1">{{ Str::limit($skpi->catatan_dosen, 50) }}</p>
                    @endif
                </td>
                <td class="px-6 py-4">
                    <div class="flex gap-2">
                        <a href="{{ $skpi->attachment_url }}" target="_blank" class="text-blue-600 hover:text-blue-800" title="Lihat Attachment">
                            <i class="fas fa-external-link-alt"></i>
                        </a>
                        @if($skpi->status == 'draft' || $skpi->status == 'submitted')
                        <a href="{{ route('mahasiswa.skpi.edit', $skpi) }}" class="text-yellow-600 hover:text-yellow-800">
                            <i class="fas fa-edit"></i>
                        </a>
                        @endif
                        @if($skpi->status == 'draft')
                        <form action="{{ route('mahasiswa.skpi.destroy', $skpi) }}" method="POST" class="inline" onsubmit="return confirm('Yakin ingin menghapus?')">
                            @csrf @method('DELETE')
                            <button type="submit" class="text-red-600 hover:text-red-800">
                                <i class="fas fa-trash"></i>
                            </button>
                        </form>
                        @endif
                    </div>
                </td>
            </tr>
            @empty
            <tr><td colspan="5" class="px-6 py-8 text-center text-gray-500">Belum ada data SKPI</td></tr>
            @endforelse
        </tbody>
    </table>
</div>
<div class="mt-4">{{ $skpis->links() }}</div>
@endsection