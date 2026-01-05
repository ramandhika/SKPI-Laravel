@extends('layouts.app')
@section('title', 'Review SKPI')
@section('page-title', 'Review SKPI Mahasiswa')

@section('sidebar')
<a href="{{ route('dosen.dashboard') }}" class="block px-6 py-3 hover:bg-indigo-700 transition">
    <i class="fas fa-home mr-3"></i> Dashboard
</a>
<a href="{{ route('dosen.skpi.index') }}" class="block px-6 py-3 bg-indigo-900 border-l-4 border-white">
    <i class="fas fa-clipboard-check mr-3"></i> Review SKPI
</a>
@endsection

@section('content')
<div class="mb-6 bg-indigo-50 border border-indigo-200 rounded-lg p-4">
    <p class="text-indigo-900"><i class="fas fa-info-circle mr-2"></i>Anda mengelola: <strong>{{ $programStudi->nama }}</strong></p>
</div>

<div class="mb-6 flex justify-between">
    <form method="GET" class="flex gap-2">
        <input type="text" name="search" value="{{ request('search') }}" placeholder="Cari NIM/Nama..." class="px-4 py-2 border rounded-lg">
        <select name="status" class="px-4 py-2 border rounded-lg">
            <option value="">Semua Status</option>
            <option value="submitted" {{ request('status')=='submitted'?'selected':'' }}>Submitted</option>
            <option value="accepted" {{ request('status')=='accepted'?'selected':'' }}>Accepted</option>
            <option value="rejected" {{ request('status')=='rejected'?'selected':'' }}>Rejected</option>
        </select>
        <button type="submit" class="px-4 py-2 bg-gray-600 text-white rounded-lg hover:bg-gray-700">
            <i class="fas fa-search"></i> Cari
        </button>
    </form>
    @if(request('status') == 'submitted' || !request('status'))
    <button onclick="document.getElementById('bulkModal').classList.remove('hidden')" class="px-4 py-2 bg-green-600 text-white rounded-lg hover:bg-green-700">
        <i class="fas fa-tasks mr-2"></i> Bulk Review
    </button>
    @endif
</div>

<div class="bg-white rounded-lg shadow overflow-hidden">
    <table class="w-full">
        <thead class="bg-gray-50">
            <tr>
                @if(request('status') == 'submitted' || !request('status'))
                <th class="px-6 py-3 text-left"><input type="checkbox" id="selectAll"></th>
                @endif
                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Mahasiswa</th>
                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Kategori</th>
                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Kegiatan</th>
                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Status</th>
                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Aksi</th>
            </tr>
        </thead>
        <tbody class="divide-y divide-gray-200">
            @forelse($skpis as $skpi)
            <tr class="hover:bg-gray-50">
                @if(request('status') == 'submitted' || !request('status'))
                <td class="px-6 py-4">
                    @if($skpi->status == 'submitted')
                    <input type="checkbox" name="skpi_ids[]" value="{{ $skpi->id }}" class="skpi-checkbox">
                    @endif
                </td>
                @endif
                <td class="px-6 py-4">
                    <div>
                        <p class="font-medium">{{ $skpi->user->name }}</p>
                        <p class="text-sm text-gray-500">{{ $skpi->user->nim }}</p>
                    </div>
                </td>
                <td class="px-6 py-4">
                    <div>
                        <p class="font-medium">{{ $skpi->kategori->nama }}</p>
                        <p class="text-sm text-gray-500">{{ $skpi->subKategori->nama }}</p>
                    </div>
                </td>
                <td class="px-6 py-4">{{ $skpi->nama_kegiatan }}</td>
                <td class="px-6 py-4">
                    @php $colors=['draft'=>'gray','submitted'=>'yellow','accepted'=>'green','rejected'=>'red'];
                         $color=$colors[$skpi->status]??'gray'; @endphp
                    <span class="px-2 py-1 bg-{{$color}}-100 text-{{$color}}-800 rounded-full text-xs font-medium">
                        {{ ucfirst($skpi->status) }}
                    </span>
                </td>
                <td class="px-6 py-4">
                    <a href="{{ route('dosen.skpi.show', $skpi) }}" class="text-blue-600 hover:text-blue-800">
                        <i class="fas fa-eye"></i> Detail
                    </a>
                </td>
            </tr>
            @empty
            <tr><td colspan="6" class="px-6 py-8 text-center text-gray-500">Tidak ada data SKPI</td></tr>
            @endforelse
        </tbody>
    </table>
</div>
<div class="mt-4">{{ $skpis->links() }}</div>

<!-- Bulk Review Modal -->
<div id="bulkModal" class="hidden fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center z-50">
    <div class="bg-white rounded-lg p-6 max-w-md w-full">
        <h3 class="text-lg font-semibold mb-4">Bulk Review SKPI</h3>
        <form id="bulkForm" action="{{ route('dosen.skpi.bulk-review') }}" method="POST">
            @csrf
            <div id="selectedCount" class="mb-4 text-sm text-gray-600"></div>
            <div class="mb-4">
                <label class="block text-gray-700 mb-2">Keputusan <span class="text-red-500">*</span></label>
                <select name="status" required class="w-full px-3 py-2 border rounded">
                    <option value="">Pilih</option>
                    <option value="accepted">Accept</option>
                    <option value="rejected">Reject</option>
                </select>
            </div>
            <div class="mb-4">
                <label class="block text-gray-700 mb-2">Catatan</label>
                <textarea name="catatan_dosen" rows="3" class="w-full px-3 py-2 border rounded"></textarea>
            </div>
            <div class="flex justify-end gap-2">
                <button type="button" onclick="document.getElementById('bulkModal').classList.add('hidden')" class="px-4 py-2 bg-gray-300 rounded">
                    Batal
                </button>
                <button type="submit" class="px-4 py-2 bg-indigo-600 text-white rounded hover:bg-indigo-700">
                    Submit Review
                </button>
            </div>
        </form>
    </div>
</div>

@push('scripts')
<script>
document.getElementById('selectAll')?.addEventListener('change', function() {
    document.querySelectorAll('.skpi-checkbox').forEach(cb => cb.checked = this.checked);
});

document.getElementById('bulkForm')?.addEventListener('submit', function(e) {
    const checked = document.querySelectorAll('.skpi-checkbox:checked');
    if (checked.length === 0) {
        e.preventDefault();
        alert('Pilih minimal 1 SKPI');
        return;
    }
    checked.forEach(cb => {
        const input = document.createElement('input');
        input.type = 'hidden';
        input.name = 'skpi_ids[]';
        input.value = cb.value;
        this.appendChild(input);
    });
});

document.querySelectorAll('.skpi-checkbox').forEach(cb => {
    cb.addEventListener('change', function() {
        const count = document.querySelectorAll('.skpi-checkbox:checked').length;
        document.getElementById('selectedCount').textContent = count + ' SKPI dipilih';
    });
});
</script>
@endpush
@endsection