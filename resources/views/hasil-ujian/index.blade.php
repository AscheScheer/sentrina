@php
$routeHasilUjian = request()->is('admin/*') ? route('admin.hasil-ujian.index') :
(request()->is('kepsek/*') ? route('kepsek.hasil-ujian.index') : route('staff.hasil-ujian.index'));
$rolePrefix = request()->is('admin/*') ? 'admin' : (request()->is('kepsek/*') ? 'kepsek' : 'staff');
@endphp

<x-app-layout>
    <div class="relative overflow-x-auto shadow-md sm:rounded-lg container">
        <div class="relative p-3 ">
            <div style="overflow-x: auto; white-space: nowrap;" class="mb-3">
                <x-pagination-responsive :paginator="$hasilUjian" />
            </div>
            @if (!auth()->guard('kepsek')->check())
            <div class="d-flex gap-2 mb-3">
                <a href="{{ route($rolePrefix.'.hasil-ujian.create') }}" class="btn btn-primary">
                    Tambah Hasil Ujian
                </a>
                <button type="button" class="btn btn-success" data-bs-toggle="modal" data-bs-target="#importModal">
                    📥 Import Excel
                </button>
            </div>
            @endif
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
                    <a href="{{ $routeHasilUjian }}" class="btn btn-sm btn-outline-secondary">
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
                        <h5 class="modal-title" id="filterModalLabel">Filter Hasil Ujian</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <form action="{{ route($rolePrefix.'.hasil-ujian.index') }}" method="GET">
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
                            <a href="{{ $routeHasilUjian }}" class="btn btn-outline-warning">Reset Filter</a>
                            <button type="submit" class="btn btn-primary">Terapkan Filter</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        <!-- Import Modal -->
        <div class="modal fade" id="importModal" tabindex="-1" aria-labelledby="importModalLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="importModalLabel">Import Hasil Ujian dari Excel</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <form action="{{ route($rolePrefix.'.hasil-ujian.import') }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        <div class="modal-body">
                            <div class="mb-3">
                                <label for="file" class="form-label">Pilih File Excel (.xlsx)</label>
                                <div class="px-2 py-2" style="overflow-x: auto; background-color: #f8f9fa; border: 1px solid #ced4da; border-radius: 0.375rem;">
                                    <input type="file" name="file" id="file" class="form-control" accept=".xlsx,.xls" required>
                                </div>
                                <div class="form-text">
                                    Format file: .xlsx atau .xls (maksimal 2MB)
                                </div>
                            </div>

                            <div class="alert alert-info">
                                <h6 class="mb-2">📋 Format Excel yang diperlukan:</h6>
                                <ul class="mb-0 small">
                                    <li><strong>Kolom A (nama):</strong> Nama lengkap santri</li>
                                    <li><strong>Kolom B (tanggal):</strong> Tanggal ujian (format: YYYY-MM-DD)</li>
                                    <li><strong>Kolom C (juz):</strong> Juz yang diuji (contoh: Juz 1)</li>
                                    <li><strong>Kolom D (keterangan):</strong> Keterangan ujian (opsional)</li>
                                </ul>
                            </div>

                            <div class="alert alert-warning">
                                <small>
                                    <strong>⚠️ Catatan:</strong><br>
                                    • Baris pertama harus berisi header kolom<br>
                                    • Nama santri harus sesuai dengan data yang ada di sistem<br>
                                    • Data yang tidak valid akan dilewati
                                </small>
                            </div>

                            @if(Auth::guard('admin')->check())
                            <div class="mb-3">
                                <label for="import_staff_id" class="form-label">Staff Penguji <span class="text-danger">*</span></label>
                                <select name="staff_id" id="import_staff_id" class="form-control" required>
                                    <option value="">-- Pilih Staff --</option>
                                    @foreach(\App\Models\Staff::all() as $staff)
                                        <option value="{{ $staff->id }}">{{ $staff->name }}</option>
                                    @endforeach
                                </select>
                                <div class="form-text">
                                    Pilih staff yang akan dicatat sebagai penguji untuk semua data yang diimport
                                </div>
                            </div>
                            @endif
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                            <a href="{{ route($rolePrefix.'.hasil-ujian.template') }}" class="btn btn-outline-info">
                                📄 Download Template
                            </a>
                            <button type="submit" class="btn btn-success">
                                📥 Import Data
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        @if ($hasilUjian->isEmpty())
        <div class="text-black p-3 rounded mb-3 text-center">
            Data hasil ujian belum tersedia!
        </div>
        @else
        <table class="w-full text-sm text-left rtl:text-right text-gray-500 dark:text-gray-400 container" style="color: black;">
            <thead class="text-sm text-gray-700 uppercase  dark:bg-gray-800" style="background-color: #cad7ed;">
                <tr class="border-t border-b dark:border-gray-700">
                    <th class="px-6 py-3 text-center">No</th>
                    <th class="px-6 py-3 text-center">Nama</th>
                    <th class="px-6 py-3 text-center">Kelompok</th>
                    <th class="px-6 py-3 text-center">Juz</th>
                    <th class="px-6 py-3 text-center">Staff</th>
                    <th class="px-6 py-3 text-center">Tanggal</th>
                    <th class="px-6 py-3 text-center">Keterangan</th>
                    @if (!auth()->guard('kepsek')->check())
                    <th class="px-6 py-3 text-center">Action</th>
                    @endif
                </tr>
            </thead>
            <tbody>
                @foreach ($hasilUjian as $item)
                <tr class="bg-white border-b dark:bg-gray-800 dark:border-gray-700 hover:bg-gray-50">
                    <td class="px-6 py-3 text-center">
                        {{ $loop->iteration + ($hasilUjian->currentPage() - 1) * $hasilUjian->perPage() }}
                    </td>
                    <td class="px-6 py-3 text-center">
                        {{ $item->user->name ?? 'Error' }}
                    </td>
                    <td class="px-6 py-3 text-center">
                        {{ $item->user->kelompok->nama ?? '-' }}
                    </td>
                    <td class="px-6 py-3 text-center">
                        <span class="badge bg-success">{{ $item->juz }}</span>
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
                    @if (!auth()->guard('kepsek')->check())
                    <td class="px-6 py-3 text-center space-x-2">
                        <a href="{{ route($rolePrefix.'.hasil-ujian.edit', $item->id) }}" class="text-blue-600 hover:text-blue-900">Edit</a>
                        <form action="{{ route($rolePrefix.'.hasil-ujian.destroy', $item->id) }}" method="POST"
                            style="display:inline-block;"
                            onsubmit="return confirm('Apakah Anda yakin ingin menghapus hasil ujian ini?');">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="text-red-600 hover:text-red-900">Hapus</button>
                        </form>
                    </td>
                    @endif
                </tr>
                @endforeach
            </tbody>
        </table>
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
            $('#filterModal').on('shown.bs.modal', function() {
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
            $('#filterModal').on('hidden.bs.modal', function() {
                $('#modal_username').select2('destroy');
                $('#modal_kelompok').select2('destroy');
            });
        });
    </script>
</x-app-layout>
