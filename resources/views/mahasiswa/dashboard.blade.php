@extends('layouts.app')
@section('title', 'Dashboard Mahasiswa')
@section('page-title', 'Dashboard Mahasiswa')

{{-- @section('sidebar')
<a href="{{ route('mahasiswa.dashboard') }}" class="block px-6 py-3 bg-indigo-900 border-l-4 border-white">
    <i class="fas fa-home mr-3"></i> Dashboard
</a>
<a href="{{ route('mahasiswa.skpi.index') }}" class="block px-6 py-3 hover:bg-indigo-700 transition">
    <i class="fas fa-file-alt mr-3"></i> Data SKPI
</a>
<a href="{{ route('mahasiswa.skpi.create') }}" class="block px-6 py-3 hover:bg-indigo-700 transition">
    <i class="fas fa-plus mr-3"></i> Tambah SKPI
</a>
@endsection --}}

@section('content')
    <div class="grid grid-cols-1 md:grid-cols-4 gap-6 mb-6">
        <div class="bg-white rounded-lg shadow p-6">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-gray-500 text-sm">Total SKPI</p>
                    <p class="text-3xl font-bold text-indigo-600">{{ $totalSkpi }}</p>
                </div>
                <div class="w-12 h-12 bg-indigo-100 rounded-full flex items-center justify-center">
                    <i class="fas fa-file-alt text-indigo-600 text-xl"></i>
                </div>
            </div>
        </div>

        <div class="bg-white rounded-lg shadow p-6">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-gray-500 text-sm">Draft</p>
                    <p class="text-3xl font-bold text-gray-600">{{ $draftSkpi }}</p>
                </div>
                <div class="w-12 h-12 bg-gray-100 rounded-full flex items-center justify-center">
                    <i class="fas fa-edit text-gray-600 text-xl"></i>
                </div>
            </div>
        </div>

        <div class="bg-white rounded-lg shadow p-6">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-gray-500 text-sm">Submitted</p>
                    <p class="text-3xl font-bold text-yellow-600">{{ $submittedSkpi }}</p>
                </div>
                <div class="w-12 h-12 bg-yellow-100 rounded-full flex items-center justify-center">
                    <i class="fas fa-clock text-yellow-600 text-xl"></i>
                </div>
            </div>
        </div>

        <div class="bg-white rounded-lg shadow p-6">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-gray-500 text-sm">Accepted</p>
                    <p class="text-3xl font-bold text-green-600">{{ $acceptedSkpi }}</p>
                </div>
                <div class="w-12 h-12 bg-green-100 rounded-full flex items-center justify-center">
                    <i class="fas fa-check text-green-600 text-xl"></i>
                </div>
            </div>
        </div>
    </div>

    @if ($activePeriod)
        <div class="bg-green-50 border border-green-200 rounded-lg p-4 mb-6">
            <h4 class="font-semibold text-green-800 mb-2"><i class="fas fa-info-circle mr-2"></i>Periode Input Aktif</h4>
            <p class="text-green-700">
                <strong>{{ $activePeriod->nama }}</strong><br>
                {{ $activePeriod->tanggal_mulai->format('d M Y') }} - {{ $activePeriod->tanggal_selesai->format('d M Y') }}
            </p>
        </div>
    @else
        <div class="bg-yellow-50 border border-yellow-200 rounded-lg p-4 mb-6">
            <p class="text-yellow-800"><i class="fas fa-exclamation-triangle mr-2"></i>Tidak ada periode input aktif saat
                ini</p>
        </div>
    @endif

    <div class="bg-white rounded-lg shadow">
        <div class="p-6 border-b">
            <h3 class="text-lg font-semibold">SKPI Terbaru</h3>
        </div>
        <div class="overflow-x-auto">
            <table class="w-full">
                <thead class="bg-gray-50">
                    <tr>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Kategori</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Kegiatan</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Status</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Tanggal</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-200">
                    @forelse($recentSkpi as $skpi)
                        <tr class="hover:bg-gray-50">
                            <td class="px-6 py-4">{{ $skpi->kategori->nama }}</td>
                            <td class="px-6 py-4">{{ $skpi->nama_kegiatan }}</td>
                            <td class="px-6 py-4">
                                @php
                                    $colors = [
                                        'draft' => 'gray',
                                        'submitted' => 'yellow',
                                        'accepted' => 'green',
                                        'rejected' => 'red',
                                    ];
                                    $color = $colors[$skpi->status] ?? 'gray';
                                @endphp
                                <span
                                    class="px-2 py-1 bg-{{ $color }}-100 text-{{ $color }}-800 rounded-full text-xs font-medium">
                                    {{ ucfirst($skpi->status) }}
                                </span>
                            </td>
                            <td class="px-6 py-4 text-sm text-gray-500">{{ $skpi->created_at->format('d M Y') }}</td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="4" class="px-6 py-8 text-center text-gray-500">Belum ada data SKPI</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
@endsection
