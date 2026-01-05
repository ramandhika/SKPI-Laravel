@extends('layouts.app')
@section('title', 'Detail SKPI')
@section('page-title', 'Detail & Review SKPI')

@section('sidebar')
<a href="{{ route('dosen.dashboard') }}" class="block px-6 py-3 hover:bg-indigo-700 transition">
    <i class="fas fa-home mr-3"></i> Dashboard
</a>
<a href="{{ route('dosen.skpi.index') }}" class="block px-6 py-3 bg-indigo-900 border-l-4 border-white">
    <i class="fas fa-clipboard-check mr-3"></i> Review SKPI
</a>
@endsection

@section('content')
<div class="mb-6">
    <a href="{{ route('dosen.skpi.index') }}" class="text-indigo-600 hover:text-indigo-800">
        <i class="fas fa-arrow-left mr-2"></i> Kembali ke List
    </a>
</div>

<div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
    <div class="lg:col-span-2">
        <div class="bg-white rounded-lg shadow-md p-6 mb-6">
            <h3 class="text-lg font-semibold mb-4 border-b pb-2">Informasi Mahasiswa</h3>
            <div class="grid grid-cols-2 gap-4">
                <div>
                    <p class="text-sm text-gray-500">Nama</p>
                    <p class="font-medium">{{ $skpi->user->name }}</p>
                </div>
                <div>
                    <p class="text-sm text-gray-500">NIM</p>
                    <p class="font-medium">{{ $skpi->user->nim }}</p>
                </div>
                <div>
                    <p class="text-sm text-gray-500">Email</p>
                    <p class="font-medium">{{ $skpi->user->email }}</p>
                </div>
                <div>
                    <p class="text-sm text-gray-500">Program Studi</p>
                    <p class="font-medium">{{ $skpi->user->programStudi->nama }}</p>
                </div>
            </div>
        </div>

        <div class="bg-white rounded-lg shadow-md p-6">
            <h3 class="text-lg font-semibold mb-4 border-b pb-2">Detail SKPI</h3>
            
            <div class="mb-4">
                <p class="text-sm text-gray-500">Kategori</p>
                <p class="font-medium">{{ $skpi->kategori->nama }}</p>
                <p class="text-sm text-indigo-600">Nilai: {{ $skpi->kategori->nilai }} Poin</p>
            </div>

            <div class="mb-4">
                <p class="text-sm text-gray-500">Sub Kategori</p>
                <p class="font-medium">{{ $skpi->subKategori->nama }}</p>
            </div>

            <div class="mb-4">
                <p class="text-sm text-gray-500">Nama Kegiatan (Indonesia)</p>
                <p class="font-medium">{{ $skpi->nama_kegiatan }}</p>
            </div>

            @if($skpi->nama_kegiatan_en)
            <div class="mb-4">
                <p class="text-sm text-gray-500">Nama Kegiatan (English)</p>
                <p class="font-medium">{{ $skpi->nama_kegiatan_en }}</p>
            </div>
            @endif

            <div class="mb-4">
                <p class="text-sm text-gray-500 mb-2">Attachment</p>
                <a href="{{ $skpi->attachment_url }}" target="_blank" class="inline-flex items-center px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700">
                    <i class="fas fa-external-link-alt mr-2"></i> Buka Google Drive
                </a>
            </div>

            <div class="mb-4">
                <p class="text-sm text-gray-500">Status Saat Ini</p>
                @php $colors=['draft'=>'gray','submitted'=>'yellow','accepted'=>'green','rejected'=>'red'];
                     $color=$colors[$skpi->status]??'gray'; @endphp
                <span class="inline-block px-3 py-1 bg-{{$color}}-100 text-{{$color}}-800 rounded-full text-sm font-medium">
                    {{ ucfirst($skpi->status) }}
                </span>
            </div>

            @if($skpi->reviewed_by)
            <div class="mb-4 p-4 bg-gray-50 rounded">
                <p class="text-sm text-gray-500">Direview Oleh</p>
                <p class="font-medium">{{ $skpi->reviewer->name }}</p>
                <p class="text-xs text-gray-500">{{ $skpi->reviewed_at->format('d M Y, H:i') }}</p>
            </div>
            @endif

            @if($skpi->catatan_dosen)
            <div class="p-4 bg-yellow-50 border border-yellow-200 rounded">
                <p class="text-sm text-yellow-800 font-semibold mb-1">Catatan Dosen:</p>
                <p class="text-yellow-700">{{ $skpi->catatan_dosen }}</p>
            </div>
            @endif
        </div>
    </div>

    <div class="lg:col-span-1">
        @if($skpi->status == 'submitted')
        <div class="bg-white rounded-lg shadow-md p-6">
            <h3 class="text-lg font-semibold mb-4">Review SKPI</h3>
            <form action="{{ route('dosen.skpi.review', $skpi) }}" method="POST">
                @csrf
                <div class="mb-4">
                    <label class="block text-gray-700 font-semibold mb-2">Keputusan <span class="text-red-500">*</span></label>
                    <select name="status" required class="w-full px-3 py-2 border rounded-lg">
                        <option value="">Pilih Keputusan</option>
                        <option value="accepted">Accept</option>
                        <option value="rejected">Reject</option>
                    </select>
                </div>

                <div class="mb-4">
                    <label class="block text-gray-700 font-semibold mb-2">Catatan</label>
                    <textarea name="catatan_dosen" rows="4" class="w-full px-3 py-2 border rounded-lg" placeholder="Berikan catatan untuk mahasiswa (opsional untuk accept, wajib untuk reject)"></textarea>
                </div>

                <button type="submit" class="w-full px-4 py-2 bg-indigo-600 text-white rounded-lg hover:bg-indigo-700">
                    <i class="fas fa-check mr-2"></i> Submit Review
                </button>
            </form>
        </div>
        @else
        <div class="bg-gray-50 border border-gray-200 rounded-lg p-6 text-center">
            <i class="fas fa-info-circle text-gray-400 text-3xl mb-2"></i>
            <p class="text-gray-600">SKPI ini sudah direview</p>
        </div>
        @endif
    </div>
</div>
@endsection