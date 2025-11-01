@php
$routelaporan = route('kepsek.laporan.index');
@endphp
<x-app-layout>
    <div class="relative overflow-x-auto shadow-md sm:rounded-lg container">
        <div class="relative p-3">
            <!-- Header with back button -->
            <div class="d-flex align-items-center justify-content-between mb-4">
                <div>
                    <h2 class="h4 mb-1">📄 Export Laporan ke PDF (Kepala Sekolah)</h2>
                    <p class="text-muted mb-0">Pilih filter dan rentang tanggal untuk export laporan</p>
                </div>
                <a href="{{ $routelaporan }}" class="btn btn-outline-secondary">
                    ← Kembali ke Laporan
                </a>
            </div>
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

        <!-- Export Form -->
        <div class="row justify-content-center px-3">
            <div class="col-12 col-lg-8">
                <div class="card shadow-sm">
                    <div class="card-header bg-light">
                        <h5 class="card-title mb-0">🔧 Pengaturan Export</h5>
                    </div>
                    <div class="card-body p-4">
                        <form action="{{ route('kepsek.export.pdf') }}" method="get" target="_blank" id="exportForm">
                            <div class="row g-4">
                                <!-- Rentang Tanggal -->
                                <div class="col-12">
                                    <label class="form-label fw-bold">📅 Rentang Tanggal <span class="text-danger">*</span></label>
                                    <div class="row g-3">
                                        <div class="col-md-6">
                                            <input type="date" name="start_date" class="form-control" required>
                                            <small class="text-muted">Tanggal Mulai</small>
                                        </div>
                                        <div class="col-md-6">
                                            <input type="date" name="end_date" class="form-control" value="{{ \Carbon\Carbon::now()->format('Y-m-d') }}" required>
                                            <small class="text-muted">Tanggal Akhir</small>
                                        </div>
                                    </div>
                                </div>
                                                                <!-- Quick Actions -->
                                <div class="card border-light bg-light">
                                    <div class="card-body p-3">
                                        <h6 class="card-title">⚡ Aksi Cepat</h6>
                                        <div class="row g-2">
                                            <div class="col-md-4">
                                                <button type="button" class="btn btn-outline-primary btn-sm w-100" onclick="setTodayDate()">
                                                    📅 Hari Ini
                                                </button>
                                            </div>
                                            <div class="col-md-4">
                                                <button type="button" class="btn btn-outline-primary btn-sm w-100" onclick="setThisWeek()">
                                                    📊 Minggu Ini
                                                </button>
                                            </div>
                                            <div class="col-md-4">
                                                <button type="button" class="btn btn-outline-primary btn-sm w-100" onclick="setThisMonth()">
                                                    📈 Bulan Ini
                                                </button>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <!-- Filter Nama Santri -->
                                <div class="col-12">
                                    <label for="export_user_search" class="form-label fw-bold">👤 Filter Nama Santri (Opsional)</label>
                                    <div class="position-relative">
                                        <input type="text"
                                               id="export_user_search"
                                               class="form-control"
                                               placeholder="Ketik nama santri untuk mencari..."
                                               autocomplete="off">
                                        <input type="hidden" name="username" id="export_selected_username">

                                        <!-- Dropdown untuk hasil pencarian -->
                                        <div id="export_user_dropdown" class="position-absolute w-100 bg-white border border-secondary rounded shadow-lg"
                                             style="top: 100%; z-index: 1050; max-height: 200px; overflow-y: auto; display: none;">
                                            @foreach ($users as $user)
                                                <div class="export-user-option px-3 py-2 border-bottom cursor-pointer"
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
                                    <small class="text-muted">Kosongkan untuk export semua santri</small>
                                </div>

                                <!-- Filter Kelompok -->
                                <div class="col-12">
                                    <label for="export_kelompok" class="form-label fw-bold">👥 Filter Kelompok (Opsional)</label>
                                    <select name="kelompok" id="export_kelompok" class="form-select">
                                        <option value="">-- Semua Kelompok --</option>
                                        @foreach($kelompoks as $kelompok)
                                        <option value="{{ $kelompok->nama }}">{{ $kelompok->nama }}</option>
                                        @endforeach
                                    </select>
                                    <small class="text-muted">Kosongkan untuk export semua kelompok</small>
                                </div>

                                <!-- Preview Info -->
                                <div class="col-12">
                                    <div class="alert alert-info">
                                        <div class="d-flex align-items-center">
                                            <i class="fas fa-info-circle me-2"></i>
                                            <div>
                                                <strong>📋 Informasi Export:</strong>
                                                <ul class="mb-0 mt-1">
                                                    <li>File PDF akan terbuka di tab baru</li>
                                                    <li>Data yang di-export sesuai dengan filter yang dipilih</li>
                                                    <li>Pastikan rentang tanggal sudah benar</li>
                                                </ul>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <!-- Action Buttons -->
                                <div class="col-12">
                                    <div class="d-flex gap-3 justify-content-end">
                                        <a href="{{ $routelaporan }}" class="btn btn-secondary btn-lg">
                                            Batal
                                        </a>
                                        <button type="submit" class="btn btn-success btn-lg">
                                        Generate PDF
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>

        <!-- Quick Actions -->

    </div>

    <style>
        /* Custom styling for search dropdown */
        #export_user_dropdown {
            border: 1px solid #dee2e6;
            border-radius: 0.375rem;
            box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1);
        }

        .export-user-option {
            transition: background-color 0.15s ease-in-out;
        }

        .export-user-option:hover {
            background-color: #f8f9fa !important;
        }

        .export-user-option:last-child {
            border-bottom: none !important;
        }

        /* Focus styling for input */
        #export_user_search:focus {
            border-color: #0d6efd;
            outline: 0;
            box-shadow: 0 0 0 0.2rem rgba(13, 110, 253, 0.25);
        }

        /* Mobile responsive adjustments */
        @media (max-width: 768px) {
            #export_user_dropdown {
                max-height: 150px;
                font-size: 0.875rem;
            }

            .export-user-option {
                padding: 0.5rem 0.75rem;
            }
        }
    </style>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const exportUserSearch = document.getElementById('export_user_search');
            const exportUserDropdown = document.getElementById('export_user_dropdown');
            const exportSelectedUsername = document.getElementById('export_selected_username');
            const exportUserOptions = document.querySelectorAll('.export-user-option');

            // Show dropdown when input is focused
            exportUserSearch.addEventListener('focus', function() {
                exportUserDropdown.style.display = 'block';
                filterExportUsers(''); // Show all users initially
            });

            // Filter users as user types
            exportUserSearch.addEventListener('input', function() {
                const searchTerm = this.value.toLowerCase();
                filterExportUsers(searchTerm);
                exportUserDropdown.style.display = 'block';

                // Update hidden input
                exportSelectedUsername.value = this.value;
            });

            // Handle user selection
            exportUserOptions.forEach(option => {
                option.addEventListener('click', function() {
                    const userName = this.getAttribute('data-user-name');

                    exportUserSearch.value = userName;
                    exportSelectedUsername.value = userName;
                    exportUserDropdown.style.display = 'none';
                });
            });

            // Hide dropdown when clicking outside
            document.addEventListener('click', function(e) {
                if (!exportUserSearch.contains(e.target) && !exportUserDropdown.contains(e.target)) {
                    exportUserDropdown.style.display = 'none';
                }
            });

            // Filter function
            function filterExportUsers(searchTerm) {
                exportUserOptions.forEach(option => {
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
            exportUserSearch.addEventListener('keydown', function(e) {
                const visibleOptions = Array.from(exportUserOptions).filter(option =>
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
                    document.getElementById('exportForm').submit();
                }
            });

            // Handle keyboard navigation in dropdown
            exportUserOptions.forEach((option, index) => {
                option.setAttribute('tabindex', '0');
                option.addEventListener('keydown', function(e) {
                    const visibleOptions = Array.from(exportUserOptions).filter(opt =>
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

        // Quick date functions
        function setTodayDate() {
            const today = new Date().toISOString().split('T')[0];
            document.querySelector('input[name="start_date"]').value = today;
            document.querySelector('input[name="end_date"]').value = today;
        }

        function setThisWeek() {
            const today = new Date();
            const monday = new Date(today);
            monday.setDate(today.getDate() - today.getDay() + 1);

            document.querySelector('input[name="start_date"]').value = monday.toISOString().split('T')[0];
            document.querySelector('input[name="end_date"]').value = today.toISOString().split('T')[0];
        }

        function setThisMonth() {
            const today = new Date();
            const firstDay = new Date(today.getFullYear(), today.getMonth(), 1);

            document.querySelector('input[name="start_date"]').value = firstDay.toISOString().split('T')[0];
            document.querySelector('input[name="end_date"]').value = today.toISOString().split('T')[0];
        }
    </script>
</x-app-layout>
