@php
$routelaporan = route('laporan.index');
@endphp
<x-app-layout>
    <div class="relative overflow-x-auto shadow-md sm:rounded-lg container">
        <div style="overflow-x: auto; white-space: nowrap;" class="mb-3">
            {{ $laporan->links() }}
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
        <!-- Filter Controls -->
        <div class="row mb-4 px-3">
            <div class="col-12">
                <div class="card shadow-sm">
                    <div class="card-body p-3">
                        <div class="row g-3 align-items-end">
                            <!-- Quick Name Search -->
                            <div class="col-md-4">
                                <form action="{{ route('kepsek.laporan.index') }}" method="GET" class="d-inline w-100" id="searchForm">
                                    <!-- Preserve existing filters -->
                                    @if(request('tanggal'))
                                    <input type="hidden" name="tanggal" value="{{ request('tanggal') }}">
                                    @endif
                                    @if(request('kelompok'))
                                    <input type="hidden" name="kelompok" value="{{ request('kelompok') }}">
                                    @endif

                                    <label for="user_search_input" class="form-label fw-bold text-sm">🔍 Cari Nama</label>
                                    <div class="position-relative">
                                        <div class="input-group">
                                            <input type="text"
                                                   id="user_search_input"
                                                   class="form-control"
                                                   placeholder="Ketik nama santri untuk mencari..."
                                                   value="{{ request('username') }}"
                                                   autocomplete="off">
                                            <input type="hidden" name="username" id="selected_username" value="{{ request('username') }}">
                                            <button type="submit" class="btn btn-primary btn-sm">
                                                Cari
                                            </button>
                                        </div>

                                        <!-- Dropdown untuk hasil pencarian -->
                                        <div id="user_search_dropdown" class="position-absolute w-100 bg-white border border-secondary rounded shadow-lg"
                                             style="top: 100%; z-index: 1050; max-height: 200px; overflow-y: auto; display: none;">
                                            @foreach ($users as $user)
                                                <div class="user-search-option px-3 py-2 border-bottom cursor-pointer"
                                                     style="cursor: pointer;"
                                                     data-user-name="{{ $user->name }}"
                                                     onmouseover="this.style.backgroundColor='#f8f9fa'"
                                                     onmouseout="this.style.backgroundColor='white'">
                                                    <div class="fw-medium">{{ $user->name }}</div>
                                                    <div class="text-muted small">NIS: {{ $user->nis ?? '-' }}</div>
                                                </div>
                                            @endforeach
                                        </div>
                                    </div>
                                </form>
                            </div>

                            <!-- Filter Buttons -->
                            <div class="col-md-4">
                                <label class="form-label fw-bold text-sm">Filter & Export</label>
                                <div class="btn-group w-100" role="group">
                                    <button type="button" class="btn btn-outline-primary btn-sm" data-bs-toggle="modal" data-bs-target="#filterModal">
                                        📊 Filter
                                    </button>
                                    <a href="{{ route('kepsek.export.form') }}" class="btn btn-outline-success btn-sm">
                                        📄 Export
                                    </a>
                                </div>
                            </div>
                        </div>

                        <!-- Active Filters Display -->
                        @if(request()->hasAny(['tanggal', 'username', 'kelompok']))
                        <div class="mt-3 pt-2 border-top">
                            <div class="d-flex align-items-center gap-2 flex-wrap">
                                <span class="text-sm text-muted fw-bold">Filter aktif:</span>
                                @if(request('tanggal'))
                                <span class="badge bg-primary">Tanggal: {{ request('tanggal') }}</span>
                                @endif
                                @if(request('username'))
                                <span class="badge bg-success">Nama: {{ request('username') }}</span>
                                @endif
                                @if(request('kelompok'))
                                <span class="badge bg-info">Kelompok: {{ request('kelompok') }}</span>
                                @endif
                                <a href="{{ $routelaporan }}" class="btn btn-outline-secondary btn-sm">
                                    ↻ Reset Semua Filter
                                </a>
                            </div>
                        </div>
                        @endif
                    </div>
                </div>
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
                    <form action="{{ route('kepsek.laporan.index') }}" method="GET">
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
        <table class="w-full text-sm text-left rtl:text-right text-gray-500 dark:text-gray-400 container" >
            <thead class="text-sm text-gray-700 uppercase dark:bg-gray-200">
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
                </tr>
            </thead>
            <tbody>
                @foreach ($laporan as $item)
                <tr class="bg-white border-b dark:bg-gray-800 dark:border-gray-700 hover:bg-gray-50" style="color: black;">
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
                </tr>
                @endforeach
            </tbody>
        </table>

        @endif
    </div>

    <style>
        /* Custom styling for search dropdown */
        #user_search_dropdown {
            border: 1px solid #dee2e6;
            border-radius: 0.375rem;
            box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1);
        }

        .user-search-option {
            transition: background-color 0.15s ease-in-out;
        }

        .user-search-option:hover {
            background-color: #f8f9fa !important;
        }

        .user-search-option:last-child {
            border-bottom: none !important;
        }

        /* Focus styling for input */
        #user_search_input:focus {
            border-color: #0d6efd;
            outline: 0;
            box-shadow: 0 0 0 0.2rem rgba(13, 110, 253, 0.25);
        }

        /* Mobile responsive adjustments */
        @media (max-width: 768px) {
            #user_search_dropdown {
                max-height: 150px;
                font-size: 0.875rem;
            }

            .user-search-option {
                padding: 0.5rem 0.75rem;
            }
        }
    </style>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const userSearchInput = document.getElementById('user_search_input');
            const userSearchDropdown = document.getElementById('user_search_dropdown');
            const selectedUsernameInput = document.getElementById('selected_username');
            const userSearchOptions = document.querySelectorAll('.user-search-option');

            // Show dropdown when input is focused
            userSearchInput.addEventListener('focus', function() {
                userSearchDropdown.style.display = 'block';
                filterUsers(''); // Show all users initially
            });

            // Filter users as user types
            userSearchInput.addEventListener('input', function() {
                const searchTerm = this.value.toLowerCase();
                filterUsers(searchTerm);
                userSearchDropdown.style.display = 'block';

                // Update hidden input
                selectedUsernameInput.value = this.value;
            });

            // Handle user selection
            userSearchOptions.forEach(option => {
                option.addEventListener('click', function() {
                    const userName = this.getAttribute('data-user-name');

                    userSearchInput.value = userName;
                    selectedUsernameInput.value = userName;
                    userSearchDropdown.style.display = 'none';
                });
            });

            // Hide dropdown when clicking outside
            document.addEventListener('click', function(e) {
                if (!userSearchInput.contains(e.target) && !userSearchDropdown.contains(e.target)) {
                    userSearchDropdown.style.display = 'none';
                }
            });

            // Filter function
            function filterUsers(searchTerm) {
                userSearchOptions.forEach(option => {
                    const userName = option.getAttribute('data-user-name').toLowerCase();
                    const userText = option.textContent.toLowerCase();

                    if (userName.includes(searchTerm) || userText.includes(searchTerm)) {
                        option.style.display = 'block';
                    } else {
                        option.style.display = 'none';
                    }
                });
            }

            // Keyboard navigation
            userSearchInput.addEventListener('keydown', function(e) {
                const visibleOptions = Array.from(userSearchOptions).filter(option =>
                    option.style.display !== 'none'
                );

                if (e.key === 'ArrowDown') {
                    e.preventDefault();
                    if (visibleOptions.length > 0) {
                        visibleOptions[0].style.backgroundColor = '#e9ecef';
                        visibleOptions[0].focus();
                    }
                } else if (e.key === 'Enter') {
                    e.preventDefault();
                    document.getElementById('searchForm').submit();
                }
            });

            // Handle keyboard navigation in dropdown
            userSearchOptions.forEach((option, index) => {
                option.setAttribute('tabindex', '0');
                option.addEventListener('keydown', function(e) {
                    const visibleOptions = Array.from(userSearchOptions).filter(opt =>
                        opt.style.display !== 'none'
                    );
                    const currentIndex = visibleOptions.indexOf(this);

                    if (e.key === 'ArrowDown') {
                        e.preventDefault();
                        const nextIndex = (currentIndex + 1) % visibleOptions.length;
                        this.style.backgroundColor = 'white';
                        visibleOptions[nextIndex].style.backgroundColor = '#e9ecef';
                        visibleOptions[nextIndex].focus();
                    } else if (e.key === 'ArrowUp') {
                        e.preventDefault();
                        const prevIndex = currentIndex === 0 ? visibleOptions.length - 1 : currentIndex - 1;
                        this.style.backgroundColor = 'white';
                        visibleOptions[prevIndex].style.backgroundColor = '#e9ecef';
                        visibleOptions[prevIndex].focus();
                    } else if (e.key === 'Enter') {
                        e.preventDefault();
                        this.click();
                    }
                });
            });
        });

        // Initialize Select2 only for filter modal
        $(document).ready(function() {
            $('#filterModal').on('shown.bs.modal', function() {
                $('#modal_username').select2({
                    placeholder: "-- Pilih User --",
                    allowClear: true,
                    width: '100%',
                    dropdownParent: $('#filterModal')
                });

                $('#modal_kelompok').select2({
                    placeholder: "-- Pilih Kelompok --",
                    allowClear: true,
                    width: '100%',
                    dropdownParent: $('#filterModal')
                });
            });

            // Cleanup when modal is hidden
            $('#filterModal').on('hidden.bs.modal', function() {
                $('#modal_username').select2('destroy');
                $('#modal_kelompok').select2('destroy');
            });
        });
    </script>
</x-app-layout>
