@extends('layouts.app')

@section('title', 'Kelola Mahasiswa')
@section('page-title', 'Data Mahasiswa')

@section('content')

    <div class="mb-6 flex flex-col lg:flex-row justify-between items-start lg:items-center gap-4">

        <form method="GET" class="w-full lg:w-auto flex flex-col sm:flex-row gap-3">
            <div class="relative min-w-[240px]">
                <i class="fas fa-search absolute left-4 top-3.5 text-slate-400"></i>
                <input type="text" name="search" value="{{ request('search') }}" placeholder="Cari NIM atau Nama..."
                    class="w-full pl-10 pr-4 py-3 bg-white border border-slate-200 rounded-xl focus:ring-2 focus:ring-indigo-500/20 focus:border-indigo-500 transition outline-none shadow-sm">
            </div>

            <div class="relative min-w-[200px]">
                <i class="fas fa-graduation-cap absolute left-4 top-3.5 text-slate-400"></i>
                <select name="program_studi"
                    class="w-full pl-10 pr-10 py-3 bg-white border border-slate-200 rounded-xl focus:ring-2 focus:ring-indigo-500/20 focus:border-indigo-500 transition outline-none shadow-sm appearance-none cursor-pointer">
                    <option value="">Semua Prodi</option>
                    @foreach ($programStudis as $prodi)
                        <option value="{{ $prodi->id }}" {{ request('program_studi') == $prodi->id ? 'selected' : '' }}>
                            {{ $prodi->nama }}
                        </option>
                    @endforeach
                </select>
                <i class="fas fa-chevron-down absolute right-4 top-4 text-slate-400 text-xs pointer-events-none"></i>
            </div>

            <button type="submit"
                class="px-5 py-3 bg-slate-800 text-white font-bold rounded-xl hover:bg-slate-900 transition shadow-lg shadow-slate-300/50">
                <i class="fas fa-filter"></i>
            </button>
        </form>

        <div class="flex flex-wrap gap-3 w-full lg:w-auto justify-end">
            <button onclick="document.getElementById('importModal').classList.remove('hidden')"
                class="inline-flex items-center justify-center px-4 py-3 bg-emerald-50 text-emerald-600 font-bold rounded-xl border border-emerald-100 hover:bg-emerald-100 transition">
                <i class="fas fa-file-import mr-2"></i> Import
            </button>

            <a href="{{ route('admin.export.mahasiswa') }}"
                class="inline-flex items-center justify-center px-4 py-3 bg-blue-50 text-blue-600 font-bold rounded-xl border border-blue-100 hover:bg-blue-100 transition">
                <i class="fas fa-file-excel mr-2"></i> Export
            </a>

            <a href="{{ route('admin.mahasiswa.create') }}"
                class="inline-flex items-center justify-center px-5 py-3 bg-indigo-600 text-white font-bold rounded-xl hover:bg-indigo-700 transition shadow-lg shadow-indigo-500/30">
                <i class="fas fa-plus mr-2"></i> Tambah
            </a>
        </div>
    </div>

    <div class="bg-white rounded-2xl shadow-sm border border-slate-100 overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full text-left border-collapse">
                <thead>
                    <tr class="bg-slate-50 text-slate-500 text-xs uppercase tracking-wider border-b border-slate-100">
                        <th class="px-6 py-4 font-semibold">Mahasiswa</th>
                        <th class="px-6 py-4 font-semibold">Email</th>
                        <th class="px-6 py-4 font-semibold">Program Studi</th>
                        <th class="px-6 py-4 font-semibold text-right">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100">
                    @forelse($mahasiswas as $mahasiswa)
                        <tr class="hover:bg-slate-50/80 transition duration-150">
                            <td class="px-6 py-4">
                                <div class="flex items-center gap-3">
                                    <div
                                        class="w-10 h-10 rounded-full bg-indigo-50 text-indigo-600 flex items-center justify-center font-bold text-sm border border-indigo-100">
                                        {{ substr($mahasiswa->name, 0, 2) }}
                                    </div>
                                    <div>
                                        <p class="text-sm font-bold text-slate-700">{{ $mahasiswa->name }}</p>
                                        <p class="text-xs text-slate-500 font-mono">{{ $mahasiswa->nim }}</p>
                                    </div>
                                </div>
                            </td>
                            <td class="px-6 py-4">
                                <span class="text-sm text-slate-600">{{ $mahasiswa->email }}</span>
                            </td>
                            <td class="px-6 py-4">
                                <span
                                    class="inline-flex items-center px-2.5 py-0.5 rounded-lg text-xs font-bold bg-slate-100 text-slate-600 border border-slate-200">
                                    {{ $mahasiswa->programStudi ? $mahasiswa->programStudi->nama : '-' }}
                                </span>
                            </td>
                            <td class="px-6 py-4 text-right">
                                <div class="flex items-center justify-end gap-2">
                                    <a href="{{ route('admin.mahasiswa.edit', $mahasiswa) }}"
                                        class="p-2 rounded-lg text-amber-500 hover:bg-amber-50 hover:text-amber-600 transition"
                                        title="Edit">
                                        <i class="fas fa-edit"></i>
                                    </a>
                                    <form action="{{ route('admin.mahasiswa.destroy', $mahasiswa) }}" method="POST"
                                        class="inline"
                                        onsubmit="return confirm('Yakin ingin menghapus data mahasiswa ini?')">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit"
                                            class="p-2 rounded-lg text-rose-400 hover:bg-rose-50 hover:text-rose-600 transition"
                                            title="Hapus">
                                            <i class="fas fa-trash-alt"></i>
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="4" class="px-6 py-12 text-center">
                                <div class="flex flex-col items-center justify-center text-slate-400">
                                    <div class="w-16 h-16 bg-slate-50 rounded-full flex items-center justify-center mb-3">
                                        <i class="fas fa-user-slash text-2xl text-slate-300"></i>
                                    </div>
                                    <p class="text-sm font-medium">Tidak ada data mahasiswa ditemukan.</p>
                                </div>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <div class="p-4 border-t border-slate-100 bg-slate-50">
            {{ $mahasiswas->links() }}
        </div>
    </div>

    <div id="importModal"
        class="hidden fixed inset-0 z-50 flex items-center justify-center bg-slate-900/50 backdrop-blur-sm transition-opacity">
        <div class="bg-white rounded-2xl shadow-2xl w-full max-w-md p-6 transform transition-all scale-100">
            <div class="flex justify-between items-center mb-6">
                <h3 class="text-lg font-bold text-slate-800">Import Data Mahasiswa</h3>
                <button onclick="document.getElementById('importModal').classList.add('hidden')"
                    class="text-slate-400 hover:text-slate-600">
                    <i class="fas fa-times text-xl"></i>
                </button>
            </div>

            <form action="{{ route('admin.mahasiswa.import') }}" method="POST" enctype="multipart/form-data">
                @csrf

                <div class="mb-6">
                    <div
                        class="relative border-2 border-dashed border-slate-300 rounded-xl p-6 text-center hover:bg-slate-50 transition hover:border-indigo-400 cursor-pointer group">
                        <input type="file" name="file" accept=".csv,.xlsx,.xls" required
                            class="absolute inset-0 w-full h-full opacity-0 cursor-pointer">
                        <i class="fas fa-cloud-upload-alt text-3xl text-slate-400 mb-2 group-hover:text-indigo-500"></i>
                        <p class="text-sm font-medium text-slate-600">Klik untuk upload file</p>
                        <p class="text-xs text-slate-400 mt-1">.CSV, .XLSX, .XLS</p>
                    </div>
                    <div class="mt-3 bg-blue-50 border border-blue-100 rounded-lg p-3 text-xs text-blue-700">
                        <i class="fas fa-info-circle mr-1"></i> Format Header: name, email, nim, password, program_studi_id
                    </div>
                </div>

                <div class="flex gap-3">
                    <button type="button" onclick="document.getElementById('importModal').classList.add('hidden')"
                        class="flex-1 px-4 py-2.5 bg-white border border-slate-200 text-slate-600 font-semibold rounded-xl hover:bg-slate-50 transition">
                        Batal
                    </button>
                    <button type="submit"
                        class="flex-1 px-4 py-2.5 bg-emerald-600 text-white font-semibold rounded-xl hover:bg-emerald-700 transition shadow-lg shadow-emerald-500/30">
                        Proses Import
                    </button>
                </div>
            </form>
        </div>
    </div>

@endsection
