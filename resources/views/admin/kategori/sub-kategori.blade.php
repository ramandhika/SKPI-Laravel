@extends('layouts.app')

@section('title', 'Sub Kategori')
@section('page-title', 'Detail Sub Kategori')

@section('content')

    <div class="mb-8">
        <a href="{{ route('admin.kategori.index') }}"
            class="inline-flex items-center text-sm font-medium text-slate-500 hover:text-[#0F7287] mb-6 transition">
            <div
                class="w-8 h-8 rounded-full bg-white border border-slate-200 flex items-center justify-center mr-2 shadow-sm">
                <i class="fas fa-arrow-left"></i>
            </div>
            Kembali ke Kategori Induk
        </a>

        <div
            class="bg-[#0F7287] rounded-2xl p-6 md:p-8 text-white shadow-xl relative overflow-hidden flex flex-col md:flex-row justify-between items-end md:items-center gap-4">
            <div
                class="absolute top-0 right-0 w-64 h-64 bg-white/10 rounded-full blur-3xl -mr-16 -mt-16 pointer-events-none">
            </div>

            <div class="relative z-10">
                <div class="flex items-center gap-2 mb-2 text-[#fbc21d] text-xs font-bold uppercase tracking-wider">
                    <i class="fas fa-layer-group"></i> Parent Category
                </div>
                <h2 class="text-3xl font-bold mb-1">{{ $kategori->nama }}</h2>
                <p class="text-[#d4f3ff] text-sm max-w-2xl">
                    {{ $kategori->deskripsi ?? 'Kelola sub-kategori dan poin penilaian untuk kategori ini.' }}</p>
            </div>

            <button onclick="document.getElementById('createModal').classList.remove('hidden')"
                class="relative z-10 inline-flex items-center px-5 py-3 bg-white text-[#0F7287] font-bold rounded-xl hover:bg-[#f0f9fc] transition shadow-md whitespace-nowrap">
                <i class="fas fa-plus mr-2"></i> Tambah Sub
            </button>
        </div>
    </div>

    <div class="bg-white rounded-2xl shadow-sm border border-slate-100 overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full text-left border-collapse">
                <thead>
                    <tr class="bg-slate-50 text-slate-500 text-xs uppercase tracking-wider border-b border-slate-100">
                        <th class="px-6 py-4 font-semibold">Nama Sub Kategori</th>
                        <th class="px-6 py-4 font-semibold">Deskripsi</th>
                        <th class="px-6 py-4 font-semibold text-center">Poin / Nilai</th>
                        <th class="px-6 py-4 font-semibold text-center">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100">
                    @forelse($subKategoris as $sub)
                        <tr class="hover:bg-slate-50/80 transition duration-150">
                            <td class="px-6 py-4 align-top">
                                <p class="text-sm font-bold text-slate-800">{{ $sub->nama }}</p>
                                @if ($sub->nama_en)
                                    <p class="text-xs text-slate-500 italic mt-0.5">{{ $sub->nama_en }}</p>
                                @endif
                            </td>
                            <td class="px-6 py-4 align-top">
                                <p class="text-sm text-slate-600 line-clamp-2">{{ $sub->deskripsi ?? '-' }}</p>
                            </td>
                            <td class="px-6 py-4 align-top text-center">
                                <span
                                    class="inline-flex items-center px-3 py-1 rounded-full text-xs font-bold bg-emerald-50 text-emerald-600 border border-emerald-100">
                                    {{ $sub->nilai }} Poin
                                </span>
                            </td>
                            <td class="px-6 py-4 align-top text-center">
                                <div class="flex items-center justify-center gap-2">
                                    <button
                                        onclick="editSubKategori({{ $sub->id }}, '{{ addslashes($sub->nama) }}', '{{ addslashes($sub->nama_en) }}', '{{ addslashes($sub->deskripsi) }}', {{ $sub->nilai }})"
                                        class="p-2 rounded-lg text-amber-500 hover:bg-amber-50 hover:text-amber-600 transition"
                                        title="Edit">
                                        <i class="fas fa-edit"></i>
                                    </button>

                                    <form action="{{ route('admin.kategori.sub-kategori.destroy', [$kategori, $sub]) }}"
                                        method="POST" class="inline"
                                        onsubmit="return confirm('Yakin ingin menghapus sub-kategori ini?')">
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
                                        <i class="fas fa-list-ul text-2xl text-slate-300"></i>
                                    </div>
                                    <p class="text-sm font-medium">Belum ada sub kategori.</p>
                                </div>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

    <div id="createModal"
        class="hidden fixed inset-0 z-50 flex items-center justify-center bg-slate-900/50 backdrop-blur-sm transition-opacity">
        <div class="bg-white rounded-2xl shadow-2xl w-full max-w-lg p-6 transform transition-all scale-100">
            <div class="flex justify-between items-center mb-6 border-b border-slate-100 pb-4">
                <h3 class="text-lg font-bold text-slate-800">Tambah Sub Kategori</h3>
                <button onclick="document.getElementById('createModal').classList.add('hidden')"
                    class="text-slate-400 hover:text-slate-600">
                    <i class="fas fa-times text-xl"></i>
                </button>
            </div>

            <form action="{{ route('admin.kategori.sub-kategori.store', $kategori) }}" method="POST">
                @csrf
                <div class="space-y-4">
                    <div>
                        <label class="block text-sm font-bold text-slate-700 mb-2">Nama Sub (Indonesia) <span
                                class="text-rose-500">*</span></label>
                        <input type="text" name="nama" required
                            class="w-full px-4 py-2.5 bg-slate-50 border border-slate-200 rounded-xl focus:bg-white focus:ring-2 focus:ring-[#0C6C85]/20 focus:border-[#0C6C85] transition outline-none">
                    </div>
                    <div>
                        <label class="block text-sm font-bold text-slate-700 mb-2">Nama Sub (English)</label>
                        <input type="text" name="nama_en"
                            class="w-full px-4 py-2.5 bg-slate-50 border border-slate-200 rounded-xl focus:bg-white focus:ring-2 focus:ring-[#0C6C85]/20 focus:border-[#0C6C85] transition outline-none">
                    </div>
                    <div>
                        <label class="block text-sm font-bold text-slate-700 mb-2">Bobot Nilai <span
                                class="text-rose-500">*</span></label>
                        <input type="number" name="nilai" min="0" value="0" required
                            class="w-full px-4 py-2.5 bg-slate-50 border border-slate-200 rounded-xl focus:bg-white focus:ring-2 focus:ring-[#0C6C85]/20 focus:border-[#0C6C85] transition outline-none">
                    </div>
                    <div>
                        <label class="block text-sm font-bold text-slate-700 mb-2">Deskripsi</label>
                        <textarea name="deskripsi" rows="3"
                            class="w-full px-4 py-2.5 bg-slate-50 border border-slate-200 rounded-xl focus:bg-white focus:ring-2 focus:ring-[#0C6C85]/20 focus:border-[#0C6C85] transition outline-none resize-none"></textarea>
                    </div>
                </div>

                <div class="flex gap-3 mt-8">
                    <button type="button" onclick="document.getElementById('createModal').classList.add('hidden')"
                        class="flex-1 px-4 py-2.5 bg-white border border-slate-200 text-slate-600 font-semibold rounded-xl hover:bg-slate-50 transition">
                        Batal
                    </button>
                    <button type="submit"
                        class="flex-1 px-4 py-2.5 bg-[#0F7287] text-white font-semibold rounded-xl hover:bg-[#064D62] transition shadow-lg shadow-[#0C6C85]/30">
                        Simpan
                    </button>
                </div>
            </form>
        </div>
    </div>

    <div id="editModal"
        class="hidden fixed inset-0 z-50 flex items-center justify-center bg-slate-900/50 backdrop-blur-sm transition-opacity">
        <div class="bg-white rounded-2xl shadow-2xl w-full max-w-lg p-6 transform transition-all scale-100">
            <div class="flex justify-between items-center mb-6 border-b border-slate-100 pb-4">
                <h3 class="text-lg font-bold text-slate-800">Edit Sub Kategori</h3>
                <button onclick="document.getElementById('editModal').classList.add('hidden')"
                    class="text-slate-400 hover:text-slate-600">
                    <i class="fas fa-times text-xl"></i>
                </button>
            </div>

            <form id="editForm" method="POST">
                @csrf
                @method('PUT')
                <div class="space-y-4">
                    <div>
                        <label class="block text-sm font-bold text-slate-700 mb-2">Nama Sub (Indonesia) <span
                                class="text-rose-500">*</span></label>
                        <input type="text" id="edit_nama" name="nama" required
                            class="w-full px-4 py-2.5 bg-slate-50 border border-slate-200 rounded-xl focus:bg-white focus:ring-2 focus:ring-[#0C6C85]/20 focus:border-[#0C6C85] transition outline-none">
                    </div>
                    <div>
                        <label class="block text-sm font-bold text-slate-700 mb-2">Nama Sub (English)</label>
                        <input type="text" id="edit_nama_en" name="nama_en"
                            class="w-full px-4 py-2.5 bg-slate-50 border border-slate-200 rounded-xl focus:bg-white focus:ring-2 focus:ring-[#0C6C85]/20 focus:border-[#0C6C85] transition outline-none">
                    </div>
                    <div>
                        <label class="block text-sm font-bold text-slate-700 mb-2">Bobot Nilai <span
                                class="text-rose-500">*</span></label>
                        <input type="number" id="edit_nilai" name="nilai" min="0" value="0" required
                            class="w-full px-4 py-2.5 bg-slate-50 border border-slate-200 rounded-xl focus:bg-white focus:ring-2 focus:ring-[#0C6C85]/20 focus:border-[#0C6C85] transition outline-none">
                    </div>
                    <div>
                        <label class="block text-sm font-bold text-slate-700 mb-2">Deskripsi</label>
                        <textarea id="edit_deskripsi" name="deskripsi" rows="3"
                            class="w-full px-4 py-2.5 bg-slate-50 border border-slate-200 rounded-xl focus:bg-white focus:ring-2 focus:ring-[#0C6C85]/20 focus:border-[#0C6C85] transition outline-none resize-none"></textarea>
                    </div>
                </div>

                <div class="flex gap-3 mt-8">
                    <button type="button" onclick="document.getElementById('editModal').classList.add('hidden')"
                        class="flex-1 px-4 py-2.5 bg-white border border-slate-200 text-slate-600 font-semibold rounded-xl hover:bg-slate-50 transition">
                        Batal
                    </button>
                    <button type="submit"
                        class="flex-1 px-4 py-2.5 bg-amber-500 text-white font-semibold rounded-xl hover:bg-amber-600 transition shadow-lg shadow-amber-500/30">
                        Update
                    </button>
                </div>
            </form>
        </div>
    </div>

    @push('scripts')
        <script>
            function editSubKategori(id, nama, nama_en, deskripsi, nilai) {
                document.getElementById('edit_nama').value = nama;
                document.getElementById('edit_nama_en').value = nama_en || '';
                document.getElementById('edit_deskripsi').value = deskripsi || '';
                document.getElementById('edit_nilai').value = nilai || 0;

                // Set action URL dinamically
                document.getElementById('editForm').action = `/admin/kategori/{{ $kategori->id }}/sub-kategori/${id}`;

                document.getElementById('editModal').classList.remove('hidden');
            }
        </script>
    @endpush

@endsection
