@extends('layouts.app')

@section('title', 'Kelola Periode Input')
@section('page-title', 'Periode Input SKPI')

@section('content')

    <div class="mb-8 flex flex-col sm:flex-row justify-between items-start sm:items-center gap-4">
        <div class="flex items-center gap-3">
            <div class="p-3 bg-indigo-50 rounded-xl text-indigo-600">
                <i class="fas fa-calendar-alt text-xl"></i>
            </div>
            <div>
                <h3 class="font-bold text-slate-800">Daftar Periode</h3>
                <p class="text-sm text-slate-500">Atur jadwal pembukaan input SKPI.</p>
            </div>
        </div>

        <a href="{{ route('admin.periode.create') }}"
            class="inline-flex items-center justify-center px-5 py-2.5 bg-indigo-600 text-white font-bold rounded-xl hover:bg-indigo-700 transition shadow-lg shadow-indigo-500/30">
            <i class="fas fa-plus mr-2"></i> Tambah Periode
        </a>
    </div>

    <div class="bg-white rounded-2xl shadow-sm border border-slate-100 overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full text-left border-collapse">
                <thead>
                    <tr class="bg-slate-50 text-slate-500 text-xs uppercase tracking-wider border-b border-slate-100">
                        <th class="px-6 py-4 font-semibold">Nama Periode</th>
                        <th class="px-6 py-4 font-semibold">Jadwal Mulai</th>
                        <th class="px-6 py-4 font-semibold">Jadwal Selesai</th>
                        <th class="px-6 py-4 font-semibold text-center">Status Aktif</th>
                        <th class="px-6 py-4 font-semibold text-center">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100">
                    @forelse($periodes as $periode)
                        <tr class="hover:bg-slate-50/80 transition duration-150">
                            <td class="px-6 py-4">
                                <span class="text-sm font-bold text-slate-700">{{ $periode->nama }}</span>
                            </td>
                            <td class="px-6 py-4">
                                <div class="flex items-center gap-2 text-slate-600 text-sm">
                                    <i class="far fa-calendar-check text-emerald-500"></i>
                                    {{ $periode->tanggal_mulai->format('d M Y') }}
                                </div>
                            </td>
                            <td class="px-6 py-4">
                                <div class="flex items-center gap-2 text-slate-600 text-sm">
                                    <i class="far fa-calendar-times text-rose-500"></i>
                                    {{ $periode->tanggal_selesai->format('d M Y') }}
                                </div>
                            </td>
                            <td class="px-6 py-4 text-center">
                                <form action="{{ route('admin.periode.toggle', $periode) }}" method="POST"
                                    class="inline-block">
                                    @csrf
                                    <button type="submit"
                                        class="group relative inline-flex items-center justify-center px-3 py-1 rounded-full text-xs font-bold transition {{ $periode->is_active ? 'bg-emerald-100 text-emerald-700 hover:bg-emerald-200' : 'bg-slate-100 text-slate-500 hover:bg-slate-200' }}"
                                        title="Klik untuk mengubah status">
                                        <span
                                            class="w-2 h-2 rounded-full mr-1.5 {{ $periode->is_active ? 'bg-emerald-500' : 'bg-slate-400' }}"></span>
                                        {{ $periode->is_active ? 'Active' : 'Inactive' }}
                                    </button>
                                </form>
                            </td>
                            <td class="px-6 py-4 text-center">
                                <div class="flex items-center justify-center gap-2">
                                    <a href="{{ route('admin.periode.edit', $periode) }}"
                                        class="p-2 rounded-lg text-amber-500 hover:bg-amber-50 hover:text-amber-600 transition"
                                        title="Edit">
                                        <i class="fas fa-edit"></i>
                                    </a>
                                    <form action="{{ route('admin.periode.destroy', $periode) }}" method="POST"
                                        class="inline" onsubmit="return confirm('Yakin ingin menghapus periode ini?')">
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
                            <td colspan="5" class="px-6 py-12 text-center">
                                <div class="flex flex-col items-center justify-center text-slate-400">
                                    <div class="w-16 h-16 bg-slate-50 rounded-full flex items-center justify-center mb-3">
                                        <i class="fas fa-clock text-2xl text-slate-300"></i>
                                    </div>
                                    <p class="text-sm font-medium">Belum ada periode yang dibuat.</p>
                                </div>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <div class="p-4 border-t border-slate-100 bg-slate-50">
            {{ $periodes->links() }}
        </div>
    </div>

@endsection
