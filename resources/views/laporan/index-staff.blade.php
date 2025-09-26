@php
$routelaporan = route('staff.laporan.index');
@endphp
<x-app-layout>
    <div class="relative overflow-x-auto shadow-md sm:rounded-lg container">
        <div class="relative p-3 ">
            <div style="overflow-x: auto; white-space: nowrap;" class="mb-3">
                {{ $laporan->links() }}
            </div>
            <a href="{{ route('staff.laporan.create') }}"
                style="margin-bottom: 10px; display: inline-block;">
                <button class="btn btn-primary">Tambah Laporan</button>
            </a>
        </div>

        @if (session('success'))
        <div class="alert alert-success alert-dismissible fade show mx-3" role="alert">
            {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
        @endif

        @if (session('error'))
        <div class="alert alert-danger alert-dismissible fade show mx-3" role="alert">
            {{ session('error') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
        @endif
        <!-- Filter Button and Active Filters Display -->
        <div class="flex items-center justify-between mb-4 px-3">
            <div class="flex items-center gap-3">
                <button type="button" class="btn btn-outline-primary" data-bs-toggle="modal" data-bs-target="#filterModal">
                    🔍 Filter Data
                </button>

                <!-- Active Filters Display -->
                @if(request()->hasAny(['tanggal', 'username', 'kelompok']))
                <div class="d-flex align-items-center gap-2">
                    <span class="text-sm text-gray-600">Filter aktif:</span>
                    @if(request('tanggal'))
                        <span class="badge bg-primary">Tanggal: {{ request('tanggal') }}</span>
                    @endif
                    @if(request('username'))
                        <span class="badge bg-success">Nama: {{ request('username') }}</span>
                    @endif
                    @if(request('kelompok'))
                        <span class="badge bg-info">Kelompok: {{ request('kelompok') }}</span>
                    @endif
                    <a href="{{ $routelaporan }}" class="btn btn-sm btn-outline-secondary">
                        ✖ Reset
                    </a>
                </div>
                @endif
            </div>
        </div>

        <!-- Filter Modal -->
        <div class="modal fade" id="filterModal" tabindex="-1" aria-labelledby="filterModalLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="filterModalLabel">Filter Laporan</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <form action="{{ route('staff.laporan.index') }}" method="GET">
                        <div class="modal-body">
                            <div class="row g-3">
                                <div class="col-12">
                                    <label for="modal_tanggal" class="form-label">Filter Tanggal</label>
                                    <input type="date" name="tanggal" id="modal_tanggal"
                                           value="{{ request('tanggal') }}" class="form-control">
                                </div>
                                <div class="col-12">
                                    <label for="modal_username" class="form-label">Filter Nama</label>
                                    <select name="username" id="modal_username" class="form-select">
                                        <option value="">-- Pilih User --</option>
                                        @foreach($users as $user)
                                            <option value="{{ $user->name }}" {{ request('username') == $user->name ? 'selected' : '' }}>
                                                {{ $user->name }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="col-12">
                                    <label for="modal_kelompok" class="form-label">Filter Kelompok</label>
                                    <select name="kelompok" id="modal_kelompok" class="form-select">
                                        <option value="">-- Pilih Kelompok --</option>
                                        @foreach($kelompoks as $kelompok)
                                            <option value="{{ $kelompok->nama }}" {{ request('kelompok') == $kelompok->nama ? 'selected' : '' }}>
                                                {{ $kelompok->nama }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
                            <a href="{{ $routelaporan }}" class="btn btn-outline-warning">Reset Filter</a>
                            <button type="submit" class="btn btn-primary">Terapkan Filter</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
        @if ($laporan->isEmpty())
        <div class="text-black p-3 rounded mb-3 text-center">
            Data laporan belum tersedia!
        </div>
        @else
        <table class="w-full text-sm text-left rtl:text-right text-gray-500 dark:text-gray-400 container" style="color: black;">
            <thead class="text-sm text-gray-700 uppercase  dark:bg-gray-800" style="background-color: #cad7ed;">
                <tr class="border-t border-b dark:border-gray-700">
                    <th class="px-6 py-3 text-center">No</th>
                    <th class="px-6 py-3 text-center">Nama</th>
                    <th class="px-6 py-3 text-center">Kelompok</th>
                    <th class="px-6 py-3 text-center">Surat</th>
                    <th class="px-6 py-3 text-center">Ayat/Halaman</th>
                    <th class="px-6 py-3 text-center">Juz</th>
                    <th class="px-6 py-3 text-center">Staff</th>
                    <th class="px-6 py-3 text-center">Tanggal</th>
                    <th class="px-6 py-3 text-center">Keterangan</th>
                    <th class="px-6 py-3 text-center">Action</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($laporan as $item)
                <tr class="bg-white border-b dark:bg-gray-800 dark:border-gray-700 hover:bg-gray-50">
                    <td class="px-6 py-3 text-center">
                        {{ $loop->iteration + ($laporan->currentPage() - 1) * $laporan->perPage() }}
                    </td>
                    <td class="px-6 py-3 text-center">
                        {{ $item->user->name ?? 'Error' }}
                    </td>
                    <td class="px-6 py-3 text-center">
                        {{ $item->user->kelompok->nama ?? '-' }}
                    </td>
                    <td class="px-6 py-3 text-center">
                        {{ $item->suratRelasi->nama ?? 'Error' }}
                    </td>
                    <td class="px-6 py-3 text-center">
                        {{ $item->ayat_halaman }}
                    </td>
                    <td class="px-6 py-3 text-center">
                        {{ $item->juz ?? '-' }}
                    </td>
                    <td class="px-6 py-3 text-center">
                        {{ $item->staff->name ?? '-' }}
                    </td>
                    <td class="px-6 py-3 text-center">
                        {{ \Carbon\Carbon::parse($item->tanggal)->format('d M Y') }}
                    </td>
                    <td class="px-6 py-3 text-center">
                        {{ $item->keterangan ?? '-' }}
                    </td>
                    <td class="px-6 py-3 text-center space-x-2">
                        <a href="{{ route('staff.laporan.edit', $item->id) }}" class="text-blue-600 hover:text-blue-900">Edit</a>
                        <form action="{{ route('staff.laporan.destroy', $item->id) }}" method="POST"
                            style="display:inline-block;"
                            onsubmit="return confirm('Apakah Anda yakin ingin menghapus laporan ini?');">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="text-red-600 hover:text-red-900">Hapus</button>
                        </form>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
        <div class="bg-[#cad7ed] p-2 mb-5 rounded-b-[10px] text-center">
            <form action="{{ route('staff.export.pdf') }}" method="get" target="_blank"
                class="flex flex-col sm:flex-row items-center justify-center gap-2 sm:gap-4 mt-4 mb-4 px-3 w-full">
                <input type="date" name="start_date" class="border rounded px-2 py-1 text-sm w-full sm:w-auto" required>
                <p class="m-0">Sampai</p>
                <input type="date" name="end_date" class="border rounded px-2 py-1 text-sm w-full sm:w-auto" value="{{ \Carbon\Carbon::now()->format('Y-m-d') }}" required>
                <x-primary-button type="submit" class="w-full sm:w-auto">
                    Export ke PDF
                </x-primary-button>
            </form>
        </div>
        @endif
    </div>

    <style>
        /* Custom styling for Select2 to match the existing form styling */
        .select2-container--default .select2-selection--single {
            height: 38px;
            border: 1px solid #d1d5db;
            border-radius: 0.375rem;
            padding: 0.25rem 0.5rem;
            font-size: 0.875rem;
        }

        .select2-container--default .select2-selection--single .select2-selection__rendered {
            line-height: 28px;
            color: #374151;
        }

        .select2-container--default .select2-selection--single .select2-selection__arrow {
            height: 36px;
        }

        .select2-dropdown {
            border: 1px solid #d1d5db;
            border-radius: 0.375rem;
        }

        .select2-container--default .select2-search--dropdown .select2-search__field {
            border: 1px solid #d1d5db;
            border-radius: 0.375rem;
            padding: 0.25rem 0.5rem;
        }
    </style>

    <script>
        $(document).ready(function() {
            // Initialize Select2 for modal dropdowns
            $('#filterModal').on('shown.bs.modal', function () {
                // Initialize Select2 for the username dropdown in modal
                $('#modal_username').select2({
                    placeholder: "-- Pilih User --",
                    allowClear: true,
                    width: '100%',
                    dropdownParent: $('#filterModal')
                });

                // Initialize Select2 for the kelompok dropdown in modal
                $('#modal_kelompok').select2({
                    placeholder: "-- Pilih Kelompok --",
                    allowClear: true,
                    width: '100%',
                    dropdownParent: $('#filterModal')
                });
            });

            // Destroy Select2 when modal is hidden to prevent conflicts
            $('#filterModal').on('hidden.bs.modal', function () {
                $('#modal_username').select2('destroy');
                $('#modal_kelompok').select2('destroy');
            });
        });
    </script>
</x-app-layout>
