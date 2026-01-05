@extends('layouts.app')
@section('title', 'Dashboard Dosen')
@section('page-title', 'Dashboard Dosen/Kaprodi')

{{-- @section('sidebar')
    <p class="px-4 text-xs font-semibold text-slate-500 uppercase tracking-wider mb-2 mt-4">Menu Mahasiswa</p>

    <a href="#"
        class="flex items-center gap-3 px-4 py-3 text-sm font-medium rounded-xl transition-all duration-200 
   {{ request()->routeIs('mahasiswa.dashboard') ? 'bg-indigo-600 text-white shadow-lg shadow-indigo-500/30' : 'text-slate-400 hover:bg-slate-800 hover:text-white' }}">
        <i class="fas fa-home w-5 text-center"></i>
        <span>Dashboard</span>
    </a>

    <a href="#"
        class="flex items-center gap-3 px-4 py-3 text-sm font-medium rounded-xl transition-all duration-200 text-slate-400 hover:bg-slate-800 hover:text-white">
        <i class="fas fa-file-upload w-5 text-center"></i>
        <span>Input SKPI</span>
    </a>
@endsection --}}

@section('content')
    <div class="mb-6 bg-indigo-50 border border-indigo-200 rounded-lg p-4">
        <h3 class="font-semibold text-indigo-900"><i class="fas fa-graduation-cap mr-2"></i>Program Studi:
            {{ $programStudi->nama }}</h3>
        <p class="text-sm text-indigo-700 mt-1">Kode: {{ $programStudi->kode }}</p>
    </div>

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
                    <p class="text-gray-500 text-sm">Perlu Review</p>
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

        <div class="bg-white rounded-lg shadow p-6">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-gray-500 text-sm">Rejected</p>
                    <p class="text-3xl font-bold text-red-600">{{ $rejectedSkpi }}</p>
                </div>
                <div class="w-12 h-12 bg-red-100 rounded-full flex items-center justify-center">
                    <i class="fas fa-times text-red-600 text-xl"></i>
                </div>
            </div>
        </div>
    </div>

    <div class="bg-white rounded-lg shadow">
        <div class="p-6 border-b">
            <div class="flex items-center justify-between">
                <h3 class="text-lg font-semibold">SKPI Terbaru</h3>
                <a href="{{ route('dosen.skpi.index') }}" class="text-indigo-600 hover:text-indigo-800">
                    Lihat Semua <i class="fas fa-arrow-right ml-1"></i>
                </a>
            </div>
        </div>
        <div class="overflow-x-auto">
            <table class="w-full">
                <thead class="bg-gray-50">
                    <tr>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Mahasiswa</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Kategori</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Kegiatan</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Status</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Tanggal</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-200">
                    @forelse($recentSkpi as $skpi)
                        <tr class="hover:bg-gray-50">
                            <td class="px-6 py-4">
                                <div>
                                    <p class="font-medium">{{ $skpi->user->name }}</p>
                                    <p class="text-sm text-gray-500">{{ $skpi->user->nim }}</p>
                                </div>
                            </td>
                            <td class="px-6 py-4">{{ $skpi->kategori->nama }}</td>
                            <td class="px-6 py-4">{{ $skpi->nama_kegiatan }}</td>
                            <td class="px-6 py-4">
                                @php$colors = [
                                                                            'draft' => 'gray',
                                                                            'submitted' => 'yellow',
                                                                            'accepted' => 'green',
                                                                            'rejected' => 'red',
                                                                        ];
                                                                $color = $colors[$skpi->status] ?? 'gray'; @endphp ?>
                                <span
                                    class="px-2 py-1 bg-{{ $color }}-100 text-{{ $color }}-800 rounded-full text-xs font-medium">
                                    {{ ucfirst($skpi->status) }}
                                </span>
                            </td>
                            <td class="px-6 py-4 text-sm text-gray-500">{{ $skpi->created_at->format('d M Y') }}</td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="px-6 py-8 text-center text-gray-500">Belum ada data SKPI</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
@endsection
