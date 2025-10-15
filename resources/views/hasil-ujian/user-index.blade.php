<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Hasil Ujian Saya') }}
        </h2>
    </x-slot>

    <div class="relative overflow-x-auto shadow-md sm:rounded-lg container">
        <div class="relative p-3">
            <div style="overflow-x: auto; white-space: nowrap;" class="mb-3">
                {{ $hasilUjian->links() }}
            </div>

            <!-- Statistics Cards -->
            <div class="grid grid-cols-1 md:grid-cols-3 gap-4 mb-6">
                <div class="bg-blue-50 border border-blue-200 rounded-lg p-4 text-center">
                    <div class="text-2xl font-bold text-blue-600">{{ $hasilUjian->total() }}</div>
                    <div class="text-sm text-blue-700">Total Ujian</div>
                </div>
                <div class="bg-green-50 border border-green-200 rounded-lg p-4 text-center">
                    <div class="text-2xl font-bold text-green-600">
                        {{ $hasilUjian->groupBy('juz')->count() }}
                    </div>
                    <div class="text-sm text-green-700">Juz Berbeda</div>
                </div>
                <div class="bg-purple-50 border border-purple-200 rounded-lg p-4 text-center">
                    <div class="text-2xl font-bold text-purple-600">
                        {{ $hasilUjian->where('tanggal', '>=', now()->startOfMonth())->count() }}
                    </div>
                    <div class="text-sm text-purple-700">Ujian Bulan Ini</div>
                </div>
            </div>
        </div>

        @if (session('success'))
        <div class="alert alert-success alert-dismissible fade show mx-3" role="alert">
            {{ session('success') }}
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
                @if(request()->hasAny(['tanggal', 'juz', 'staff']))
                <div class="d-flex align-items-center gap-2">
                    <span class="text-sm text-gray-600">Filter aktif:</span>
                    @if(request('tanggal'))
                        <span class="badge bg-primary">Tanggal: {{ request('tanggal') }}</span>
                    @endif
                    @if(request('juz'))
                        <span class="badge bg-success">Juz: {{ request('juz') }}</span>
                    @endif
                    @if(request('staff'))
                        <span class="badge bg-info">Staff: {{ request('staff') }}</span>
                    @endif
                    <a href="{{ route('hasil-ujian.index') }}" class="btn btn-sm btn-outline-secondary">
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
                    <form action="{{ route('hasil-ujian.index') }}" method="GET">
                        <div class="modal-body">
                            <div class="row g-3">
                                <div class="col-12">
                                    <label for="modal_tanggal" class="form-label">Filter Tanggal</label>
                                    <input type="date" name="tanggal" id="modal_tanggal"
                                           value="{{ request('tanggal') }}" class="form-control">
                                </div>
                                <div class="col-12">
                                    <label for="modal_juz" class="form-label">Filter Juz</label>
                                    <select name="juz" id="modal_juz" class="form-select">
                                        <option value="">-- Semua Juz --</option>
                                        @for($i = 1; $i <= 30; $i++)
                                            <option value="Juz {{ $i }}" {{ request('juz') == "Juz $i" ? 'selected' : '' }}>
                                                Juz {{ $i }}
                                            </option>
                                        @endfor
                                    </select>
                                </div>
                                <div class="col-12">
                                    <label for="modal_staff" class="form-label">Filter Staff Penguji</label>
                                    <select name="staff" id="modal_staff" class="form-select">
                                        <option value="">-- Semua Staff --</option>
                                        @foreach($staffList as $staff)
                                            <option value="{{ $staff }}" {{ request('staff') == $staff ? 'selected' : '' }}>
                                                {{ $staff }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
                            <a href="{{ route('hasil-ujian.index') }}" class="btn btn-outline-warning">Reset Filter</a>
                            <button type="submit" class="btn btn-primary">Terapkan Filter</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        @if ($hasilUjian->isEmpty())
        <div class="text-black p-3 rounded mb-3 text-center">
            <div class="py-8">
                <div class="text-6xl mb-4">📚</div>
                <h3 class="text-lg font-medium text-gray-900 mb-2">Belum Ada Hasil Ujian</h3>
                <p class="text-gray-600">Data hasil ujian hafalan Anda belum tersedia. Silakan hubungi staff untuk melakukan ujian.</p>
            </div>
        </div>
        @else
        <table class="w-full text-sm text-left rtl:text-right text-gray-500 dark:text-gray-400 container" style="color: black;">
            <thead class="text-sm text-gray-700 uppercase dark:bg-gray-800" style="background-color: #cad7ed;">
                <tr class="border-t border-b dark:border-gray-700">
                    <th class="px-6 py-3 text-center">No</th>
                    <th class="px-6 py-3 text-center">Juz</th>
                    <th class="px-6 py-3 text-center">Tanggal</th>
                    <th class="px-6 py-3 text-center">Staff Penguji</th>
                    <th class="px-6 py-3 text-center">Keterangan</th>
                    <th class="px-6 py-3 text-center">Status</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($hasilUjian as $item)
                <tr class="bg-white border-b dark:bg-gray-800 dark:border-gray-700 hover:bg-gray-50">
                    <td class="px-6 py-3 text-center">
                        {{ $loop->iteration + ($hasilUjian->currentPage() - 1) * $hasilUjian->perPage() }}
                    </td>
                    <td class="px-6 py-3 text-center">
                        <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium bg-green-100 text-green-800">
                            {{ $item->juz }}
                        </span>
                    </td>
                    <td class="px-6 py-3 text-center">
                        <div class="font-medium">{{ \Carbon\Carbon::parse($item->tanggal)->format('d M Y') }}</div>
                        <div class="text-xs text-gray-500">{{ \Carbon\Carbon::parse($item->tanggal)->format('l') }}</div>
                    </td>
                    <td class="px-6 py-3 text-center">
                        <div class="font-medium">{{ $item->staff->name ?? '-' }}</div>
                    </td>
                    <td class="px-6 py-3 text-center">
                        @if($item->keterangan)
                            <div class="max-w-xs mx-auto">
                                <span class="inline-block bg-gray-100 rounded-lg px-3 py-1 text-sm">
                                    {{ $item->keterangan }}
                                </span>
                            </div>
                        @else
                            <span class="text-gray-400">-</span>
                        @endif
                    </td>
                    <td class="px-6 py-3 text-center">
                        @php
                            $isRecent = \Carbon\Carbon::parse($item->tanggal)->diffInDays(now()) <= 7;
                        @endphp
                        @if($isRecent)
                            <span class="inline-flex items-center px-2 py-1 rounded-full text-xs font-medium bg-blue-100 text-blue-800">
                                🆕 Baru
                            </span>
                        @else
                            <span class="inline-flex items-center px-2 py-1 rounded-full text-xs font-medium bg-gray-100 text-gray-800">
                                ✅ Selesai
                            </span>
                        @endif
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
        @endif

        <!-- Progress Summary -->
        @if (!$hasilUjian->isEmpty())
        <div class="bg-white rounded-lg shadow-sm p-6 mt-6 mx-3">
            <h3 class="text-lg font-medium text-gray-900 mb-4">📊 Ringkasan Progress</h3>
            <div class="grid grid-cols-2 md:grid-cols-5 gap-4">
                @php
                    $juzProgress = [];
                    foreach($hasilUjian as $ujian) {
                        $juzNumber = (int) str_replace('Juz ', '', $ujian->juz);
                        if ($juzNumber >= 1 && $juzNumber <= 30) {
                            $juzProgress[$juzNumber] = true;
                        }
                    }
                @endphp

                @for($juz = 1; $juz <= 30; $juz++)
                    <div class="text-center p-2 rounded {{ isset($juzProgress[$juz]) ? 'bg-green-100 text-green-800' : 'bg-gray-100 text-gray-500' }}">
                        <div class="font-medium text-sm">Juz {{ $juz }}</div>
                        <div class="text-xs mt-1">
                            {{ isset($juzProgress[$juz]) ? '✅ Selesai' : '⏳ Belum' }}
                        </div>
                    </div>
                @endfor
            </div>

            <div class="mt-4 text-center">
                <div class="text-sm text-gray-600">
                    Progress: <strong>{{ count($juzProgress) }} dari 30 Juz</strong>
                    ({{ round((count($juzProgress) / 30) * 100, 1) }}%)
                </div>
                <div class="w-full bg-gray-200 rounded-full h-3 mt-2">
                    <div class="bg-green-600 h-3 rounded-full transition-all duration-300 progress-bar-user"
                         data-width="{{ (count($juzProgress) / 30) * 100 }}"></div>
                </div>
            </div>
        </div>
        @endif
    </div>

    <style>
        .grid {
            display: grid;
        }
        .grid-cols-1 {
            grid-template-columns: repeat(1, minmax(0, 1fr));
        }
        .grid-cols-2 {
            grid-template-columns: repeat(2, minmax(0, 1fr));
        }
        .gap-4 {
            gap: 1rem;
        }

        @media (min-width: 768px) {
            .md\:grid-cols-3 {
                grid-template-columns: repeat(3, minmax(0, 1fr));
            }
            .md\:grid-cols-5 {
                grid-template-columns: repeat(5, minmax(0, 1fr));
            }
        }

        .text-center {
            text-align: center;
        }
        .font-bold {
            font-weight: 700;
        }
        .font-medium {
            font-weight: 500;
        }
        .text-2xl {
            font-size: 1.5rem;
            line-height: 2rem;
        }
        .text-lg {
            font-size: 1.125rem;
            line-height: 1.75rem;
        }
        .text-sm {
            font-size: 0.875rem;
            line-height: 1.25rem;
        }
        .text-xs {
            font-size: 0.75rem;
            line-height: 1rem;
        }

        .max-w-xs {
            max-width: 20rem;
        }
        .mx-auto {
            margin-left: auto;
            margin-right: auto;
        }

        .inline-flex {
            display: inline-flex;
        }
        .items-center {
            align-items: center;
        }

        .rounded-lg {
            border-radius: 0.5rem;
        }
        .rounded-full {
            border-radius: 9999px;
        }

        .transition-all {
            transition-property: all;
            transition-timing-function: cubic-bezier(0.4, 0, 0.2, 1);
        }
        .duration-300 {
            transition-duration: 300ms;
        }
    </style>

    <script>
        $(document).ready(function() {
            // Initialize Select2 for modal dropdowns
            $('#filterModal').on('shown.bs.modal', function () {
                $('#modal_juz').select2({
                    placeholder: "-- Semua Juz --",
                    allowClear: true,
                    width: '100%',
                    dropdownParent: $('#filterModal')
                });

                $('#modal_staff').select2({
                    placeholder: "-- Semua Staff --",
                    allowClear: true,
                    width: '100%',
                    dropdownParent: $('#filterModal')
                });
            });

            $('#filterModal').on('hidden.bs.modal', function () {
                $('#modal_juz').select2('destroy');
                $('#modal_staff').select2('destroy');
            });

            // Animate progress bar
            const progressBar = document.querySelector('.progress-bar-user');
            if (progressBar) {
                const width = progressBar.getAttribute('data-width');
                setTimeout(() => {
                    progressBar.style.width = width + '%';
                }, 100);
            }
        });
    </script>
</x-app-layout>
