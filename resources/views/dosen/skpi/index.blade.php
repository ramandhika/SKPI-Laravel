@extends('layouts.app')

@section('title', 'Review SKPI')
@section('page-title', 'Review SKPI Mahasiswa')

@section('content')

    <div class="mb-6 bg-white border border-slate-200 rounded-xl p-4 flex items-center justify-between shadow-sm">
        <div class="flex items-center gap-3">
            <div class="w-10 h-10 bg-[#f0f9fc] rounded-full flex items-center justify-center text-[#0F7287]">
                <i class="fas fa-university"></i>
            </div>
            <div>
                <p class="text-xs text-slate-500 uppercase font-bold">Program Studi</p>
                <p class="font-bold text-slate-800">{{ $programStudi->nama }}</p>
            </div>
        </div>

        @if (request('status') == 'submitted' || !request('status'))
            <button onclick="document.getElementById('bulkModal').classList.remove('hidden')"
                class="hidden md:inline-flex items-center gap-2 px-4 py-2 bg-[#0F7287] text-white text-sm font-semibold rounded-lg hover:bg-[#064D62] transition shadow-sm hover:shadow-md">
                <i class="fas fa-check-double"></i> Bulk Review
            </button>
        @endif
    </div>

    <div class="bg-white p-4 rounded-xl border border-slate-200 shadow-sm mb-6">
        <form method="GET" class="flex flex-col md:flex-row gap-4">
            <div class="relative flex-1">
                <i class="fas fa-search absolute left-4 top-3.5 text-slate-400"></i>
                <input type="text" name="search" value="{{ request('search') }}" placeholder="Cari Nama atau NIM..."
                    class="w-full pl-10 pr-4 py-3 bg-slate-50 border border-slate-200 rounded-lg focus:bg-white focus:ring-2 focus:ring-[#0C6C85]/20 focus:border-[#0C6C85] transition outline-none">
            </div>

            <div class="w-full md:w-48">
                <select name="status"
                    class="w-full px-4 py-3 bg-slate-50 border border-slate-200 rounded-lg focus:bg-white focus:ring-2 focus:ring-[#0C6C85]/20 focus:border-[#0C6C85] transition outline-none appearance-none cursor-pointer">
                    <option value="">Semua Status</option>
                    <option value="submitted" {{ request('status') == 'submitted' ? 'selected' : '' }}>⏳ Menunggu</option>
                    <option value="accepted" {{ request('status') == 'accepted' ? 'selected' : '' }}>✅ Disetujui</option>
                    <option value="rejected" {{ request('status') == 'rejected' ? 'selected' : '' }}>❌ Ditolak</option>
                </select>
            </div>

            <button type="submit"
                class="px-6 py-3 bg-slate-800 text-white font-semibold rounded-lg hover:bg-slate-900 transition">
                Filter
            </button>
        </form>
    </div>

    <div class="bg-white rounded-2xl shadow-sm border border-slate-100 overflow-hidden">
        <form id="bulkForm" action="{{ route('dosen.skpi.bulk-review') }}" method="POST">
            @csrf

            <div class="overflow-x-auto">
                <table class="w-full text-left border-collapse">
                    <thead>
                        <tr class="bg-slate-50 text-slate-500 text-xs uppercase tracking-wider border-b border-slate-100">
                            @if (request('status') == 'submitted' || !request('status'))
                                <th class="px-6 py-4 w-10 text-center">
                                    <input type="checkbox" id="selectAll"
                                        class="rounded border-slate-300 text-[#0F7287] focus:ring-[#0C6C85] cursor-pointer">
                                </th>
                            @endif
                            <th class="px-6 py-4 font-semibold">Mahasiswa</th>
                            <th class="px-6 py-4 font-semibold">Detail SKPI</th>
                            <th class="px-6 py-4 font-semibold text-center">Status</th>
                            <th class="px-6 py-4 font-semibold text-center">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-100">
                        @forelse($skpis as $skpi)
                            <tr class="hover:bg-slate-50/80 transition group">
                                @if (request('status') == 'submitted' || !request('status'))
                                    <td class="px-6 py-4 text-center">
                                        @if ($skpi->status == 'submitted')
                                            <input type="checkbox" name="skpi_ids[]" value="{{ $skpi->id }}"
                                                class="skpi-checkbox rounded border-slate-300 text-[#0F7287] focus:ring-[#0C6C85] cursor-pointer">
                                        @endif
                                    </td>
                                @endif
                                <td class="px-6 py-4">
                                    <div class="flex items-center gap-3">
                                        <div
                                            class="w-10 h-10 rounded-full bg-slate-100 flex items-center justify-center text-slate-500 font-bold text-xs">
                                            {{ substr($skpi->user->name, 0, 2) }}
                                        </div>
                                        <div>
                                            <p class="text-sm font-bold text-slate-700">{{ $skpi->user->name }}</p>
                                            <p class="text-xs text-slate-500 font-mono">{{ $skpi->user->nim }}</p>
                                        </div>
                                    </div>
                                </td>
                                <td class="px-6 py-4">
                                    <span
                                        class="inline-block px-2 py-0.5 rounded text-[10px] font-bold bg-[#f0f9fc] text-[#0F7287] mb-1">
                                        {{ $skpi->kategori->nama }}
                                    </span>
                                    <p class="text-sm font-medium text-slate-800">{{ $skpi->nama_kegiatan }}</p>
                                    <p class="text-xs text-slate-500 mt-0.5">{{ $skpi->subKategori->nama }}</p>
                                </td>
                                <td class="px-6 py-4 text-center">
                                    @php
                                        $statusClasses = [
                                            'submitted' => 'bg-amber-100 text-amber-700 border-amber-200',
                                            'accepted' => 'bg-emerald-100 text-emerald-700 border-emerald-200',
                                            'rejected' => 'bg-rose-100 text-rose-700 border-rose-200',
                                        ];
                                        $class =
                                            $statusClasses[$skpi->status] ??
                                            'bg-slate-100 text-slate-600 border-slate-200';
                                    @endphp
                                    <span
                                        class="inline-flex items-center px-3 py-1 rounded-full text-xs font-bold border {{ $class }}">
                                        {{ ucfirst($skpi->status) }}
                                    </span>
                                </td>
                                <td class="px-6 py-4 text-center">
                                    <a href="{{ route('dosen.skpi.show', $skpi) }}"
                                        class="inline-flex items-center justify-center w-8 h-8 rounded-lg bg-white border border-slate-200 text-slate-500 hover:text-[#0F7287] hover:border-[#fbc21d] transition shadow-sm">
                                        <i class="fas fa-eye"></i>
                                    </a>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="6" class="px-6 py-12 text-center">
                                    <div class="flex flex-col items-center justify-center text-slate-400">
                                        <div
                                            class="w-16 h-16 bg-slate-50 rounded-full flex items-center justify-center mb-3">
                                            <i class="fas fa-search text-2xl text-slate-300"></i>
                                        </div>
                                        <p class="text-sm font-medium">Tidak ada data SKPI ditemukan.</p>
                                    </div>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            <div class="p-4 border-t border-slate-100 bg-slate-50">
                {{ $skpis->links() }}
            </div>
        </form>
    </div>

    <div id="bulkModal" class="hidden fixed inset-0 z-50 flex items-center justify-center bg-slate-900/50 backdrop-blur-sm"
        x-cloak>
        <div class="bg-white rounded-2xl shadow-2xl w-full max-w-md p-6 transform transition-all scale-100">
            <div class="flex justify-between items-center mb-4">
                <h3 class="text-lg font-bold text-slate-800">Bulk Review Action</h3>
                <button onclick="document.getElementById('bulkModal').classList.add('hidden')"
                    class="text-slate-400 hover:text-slate-600">
                    <i class="fas fa-times text-xl"></i>
                </button>
            </div>

            <div
                class="bg-[#f0f9fc] border border-[#d4f3ff] rounded-lg p-3 mb-4 text-[#064D62] text-sm flex items-center gap-2">
                <i class="fas fa-info-circle"></i>
                <span id="selectedCountText">0 SKPI terpilih</span>
            </div>

            <div class="space-y-4">
                <div>
                    <label class="block text-sm font-semibold text-slate-700 mb-1">Keputusan</label>
                    <div class="grid grid-cols-2 gap-3">
                        <label class="cursor-pointer">
                            <input type="radio" name="status" value="accepted" form="bulkForm" class="peer sr-only"
                                required>
                            <div
                                class="p-3 text-center rounded-xl border-2 border-slate-200 text-slate-500 peer-checked:border-emerald-500 peer-checked:bg-emerald-50 peer-checked:text-emerald-600 transition hover:bg-slate-50">
                                <i class="fas fa-check-circle mb-1 block text-lg"></i> Accept
                            </div>
                        </label>
                        <label class="cursor-pointer">
                            <input type="radio" name="status" value="rejected" form="bulkForm" class="peer sr-only"
                                required>
                            <div
                                class="p-3 text-center rounded-xl border-2 border-slate-200 text-slate-500 peer-checked:border-rose-500 peer-checked:bg-rose-50 peer-checked:text-rose-600 transition hover:bg-slate-50">
                                <i class="fas fa-times-circle mb-1 block text-lg"></i> Reject
                            </div>
                        </label>
                    </div>
                </div>

                <div>
                    <label class="block text-sm font-semibold text-slate-700 mb-1">Catatan Tambahan</label>
                    <textarea name="catatan_dosen" form="bulkForm" rows="3"
                        class="w-full px-3 py-2 bg-slate-50 border border-slate-200 rounded-lg focus:bg-white focus:ring-2 focus:ring-[#0C6C85]/20 focus:border-[#0C6C85] transition outline-none resize-none"
                        placeholder="Opsional..."></textarea>
                </div>
            </div>

            <div class="mt-6 flex gap-3">
                <button onclick="document.getElementById('bulkModal').classList.add('hidden')"
                    class="flex-1 px-4 py-2.5 bg-white border border-slate-200 text-slate-600 font-semibold rounded-xl hover:bg-slate-50 transition">
                    Batal
                </button>
                <button type="submit" form="bulkForm"
                    class="flex-1 px-4 py-2.5 bg-[#0F7287] text-white font-semibold rounded-xl hover:bg-[#064D62] transition shadow-lg shadow-[#0C6C85]/30">
                    Konfirmasi
                </button>
            </div>
        </div>
    </div>

    @push('scripts')
        <script>
            const selectAll = document.getElementById('selectAll');
            const checkboxes = document.querySelectorAll('.skpi-checkbox');
            const countText = document.getElementById('selectedCountText');

            if (selectAll) {
                selectAll.addEventListener('change', function() {
                    checkboxes.forEach(cb => cb.checked = this.checked);
                    updateCount();
                });
            }

            checkboxes.forEach(cb => {
                cb.addEventListener('change', updateCount);
            });

            function updateCount() {
                const count = document.querySelectorAll('.skpi-checkbox:checked').length;
                if (countText) countText.textContent = count + ' SKPI terpilih';
            }

            // Modal Validation
            document.getElementById('bulkForm').addEventListener('submit', function(e) {
                const checked = document.querySelectorAll('.skpi-checkbox:checked');
                if (checked.length === 0) {
                    e.preventDefault();
                    alert('Pilih minimal 1 data SKPI terlebih dahulu!');
                    document.getElementById('bulkModal').classList.add('hidden');
                }
            });
        </script>
    @endpush
@endsection
