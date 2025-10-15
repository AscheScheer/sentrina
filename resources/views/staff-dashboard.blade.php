<x-app-layout>

<div class="container-fluid px-4 mt-4">
    <!-- Welcome Card -->
    <div class="row mb-4">
        <div class="col-12">
            <div class="card border-0 shadow-lg bg-gradient-to-r from-emerald-500 to-green-600 text-white overflow-hidden">
                <div class="card-body p-4 position-relative">
                    <div class="row align-items-center">
                        <div class="col-md-8">
                            <h4 class="fw-bold mb-2">
                                <i class="fas fa-book-open me-2"></i>
                                Manajemen Setoran Tahfidz
                            </h4>
                            <p class="mb-0 opacity-90">
                                Kelola dan pantau progress setoran santri dengan mudah dan efisien
                            </p>
                        </div>
                        <div class="col-md-4 text-end d-none d-md-block">
                            <button onclick="toggleForm()" class="btn btn-light btn-lg hover-lift">
                                <i class="fas fa-plus me-2"></i>
                                Tambah Setoran
                            </button>
                        </div>
                        <div class="col-12 d-md-none mt-3">
                            <button onclick="toggleForm()" class="btn btn-light btn-lg w-100 hover-lift">
                                <i class="fas fa-plus me-2"></i>
                                Tambah Setoran
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Data Setoran Terbaru -->
    <div class="row">
        <div class="col-12">
            <div class="card border-0 shadow-sm">
                <div class="card-header bg-light border-0 py-3">
                    <h5 class="mb-0 fw-bold text-dark">
                        <i class="fas fa-list text-primary me-2"></i>
                        Data Setoran Terbaru
                    </h5>
                </div>
                <div class="card-body p-0">
                    <div class="table-responsive">
                        <table class="table table-hover mb-0">
                            <thead class="table-light">
                                <tr>
                                    <th class="px-4 py-3 fw-semibold">
                                        <i class="fas fa-hashtag text-muted me-2"></i>No
                                    </th>
                                    <th class="px-4 py-3 fw-semibold">
                                        <i class="fas fa-user text-primary me-2"></i>Nama Santri
                                    </th>
                                    <th class="px-4 py-3 fw-semibold">
                                        <i class="fas fa-book text-success me-2"></i>Surat
                                    </th>
                                    <th class="px-4 py-3 fw-semibold">
                                        <i class="fas fa-bookmark text-warning me-2"></i>Ayat/Halaman
                                    </th>
                                    <th class="px-4 py-3 fw-semibold">
                                        <i class="fas fa-quran text-info me-2"></i>Juz
                                    </th>
                                    <th class="px-4 py-3 fw-semibold">
                                        <i class="fas fa-calendar text-secondary me-2"></i>Tanggal
                                    </th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse ($latestLaporan as $index => $laporan)
                                <tr class="hover-row">
                                    <td class="px-4 py-3">
                                        <span class="badge bg-light text-dark rounded-pill">{{ $index + 1 }}</span>
                                    </td>
                                    <td class="px-4 py-3">
                                        <div class="d-flex align-items-center">                                            <span class="fw-medium">{{ $laporan->user->name ?? '-' }}</span>
                                        </div>
                                    </td>
                                    <td class="px-4 py-3">
                                        <span class="text-success fw-medium">{{ $laporan->suratRelasi->nama ?? '-' }}</span>
                                    </td>
                                    <td class="px-4 py-3">
                                        <span class="badge bg-warning bg-opacity-20 text-black">{{ $laporan->ayat_halaman ?? '-' }}</span>
                                    </td>
                                    <td class="px-4 py-3">
                                        <span class="badge bg-info bg-opacity-20 text-black">{{ $laporan->juz ?? '-' }}</span>
                                    </td>
                                    <td class="px-4 py-3">
                                        <small class="text-muted">
                                            <i class="fas fa-calendar-day me-1"></i>
                                            {{ \Carbon\Carbon::parse($laporan->tanggal)->format('d M Y') }}
                                        </small>
                                    </td>
                                </tr>
                                @empty
                                <tr>
                                    <td colspan="6" class="text-center py-5">
                                        <div class="text-muted">
                                            <i class="fas fa-inbox fa-3x mb-3 opacity-50"></i>
                                            <h6 class="text-muted">Belum ada data setoran</h6>
                                            <p class="mb-0">Mulai tambahkan data setoran santri</p>
                                        </div>
                                    </td>
                                </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Modal Form -->
<div class="modal fade" id="formLaporan" tabindex="-1" aria-labelledby="formLaporanLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content border-0 shadow-lg">
            <div class="modal-header bg-gradient-to-r from-green-500 to-teal-500 text-white border-0">
                <h5 class="modal-title fw-bold" id="formLaporanLabel">
                    <i class="fas fa-plus-circle me-2"></i>
                    Tambah Laporan Setoran
                </h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body p-4">
                <form id="laporanForm" action="{{ route('staff.laporan.store') }}" method="POST">
                    @csrf

                    <!-- User Search -->
                    <div class="mb-4 position-relative">
                        <label for="user_search" class="form-label fw-semibold text-dark">
                            <i class="fas fa-user text-primary me-2"></i>Nama Santri
                        </label>
                        <input type="text" id="user_search" placeholder="Ketik nama santri untuk mencari..."
                            class="form-control form-control-lg border-2" autocomplete="off" required>
                        <input type="hidden" name="user_id" id="user_id" required>

                        <!-- Dropdown untuk hasil pencarian -->
                        <div id="user_dropdown" class="position-absolute w-100 bg-white border rounded-bottom shadow-lg"
                             style="max-height: 200px; overflow-y: auto; z-index: 1000; display: none;">
                            @foreach ($users as $user)
                            <div class="user-option px-3 py-2 hover-item border-bottom cursor-pointer"
                                data-user-id="{{ $user->id }}" data-user-name="{{ $user->name }}">
                                <div class="fw-medium">{{ $user->name }}</div>
                                <small class="text-muted">NIS: {{ $user->nis ?? '-' }}</small>
                            </div>
                            @endforeach
                        </div>
                    </div>

                    <!-- Pilih Surat -->
                    <div class="mb-4">
                        <label for="surat_id" class="form-label fw-semibold text-dark">
                            <i class="fas fa-book text-success me-2"></i>Surat
                        </label>
                        <select name="surat_id" id="surat_id" class="form-select form-select-lg border-2" required>
                            <option disabled selected>-- Pilih Surat --</option>
                            @foreach ($surat as $s)
                            <option value="{{ $s->id }}">{{ $s->nama }}</option>
                            @endforeach
                        </select>
                    </div>

                    <div class="row">
                        <div class="col-md-6">
                            <!-- Ayat / Halaman -->
                            <div class="mb-4">
                                <label for="ayat_halaman" class="form-label fw-semibold text-dark">
                                    <i class="fas fa-bookmark text-warning me-2"></i>Ayat / Halaman
                                </label>
                                <input type="text" name="ayat_halaman" id="ayat_halaman"
                                    value="{{ old('ayat_halaman') }}" class="form-control form-control-lg border-2"
                                    placeholder="Contoh: Ayat 1-10" required>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <!-- Juz -->
                            <div class="mb-4">
                                <label for="juz" class="form-label fw-semibold text-dark">
                                    <i class="fas fa-quran text-info me-2"></i>Juz
                                </label>
                                <input type="text" name="juz" id="juz" value="{{ old('juz') }}"
                                    class="form-control form-control-lg border-2" placeholder="Contoh: Juz 1">
                            </div>
                        </div>
                    </div>

                    <!-- Tanggal -->
                    <div class="mb-4">
                        <label for="tanggal" class="form-label fw-semibold text-dark">
                            <i class="fas fa-calendar text-secondary me-2"></i>Tanggal Setoran
                        </label>
                        <input type="date" name="tanggal" id="tanggal"
                            value="{{ old('tanggal', \Carbon\Carbon::now()->format('Y-m-d')) }}"
                            class="form-control form-control-lg border-2" required>
                    </div>

                    <!-- Keterangan -->
                    <div class="mb-4">
                        <label for="keterangan" class="form-label fw-semibold text-dark">
                            <i class="fas fa-comment text-muted me-2"></i>Keterangan (Opsional)
                        </label>
                        <textarea name="keterangan" id="keterangan" rows="3"
                            class="form-control border-2" placeholder="Tambahkan catatan atau keterangan...">{{ old('keterangan') }}</textarea>
                    </div>
                </form>
            </div>
            <div class="modal-footer border-0 px-4 pb-4">
                <button type="button" class="btn btn-secondary btn-lg px-4" data-bs-dismiss="modal">
                    <i class="fas fa-times me-2"></i>Batal
                </button>
                <button type="submit" form="laporanForm" class="btn btn-success btn-lg px-4">
                    <i class="fas fa-save me-2"></i>Simpan Setoran
                </button>
            </div>
        </div>
    </div>
</div>

<style>
/* Card Hover Effects */
.hover-card {
    transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
    border: 1px solid rgba(0,0,0,0.08);
}

.hover-card:hover {
    transform: translateY(-5px);
    box-shadow: 0 15px 30px rgba(0,0,0,0.12) !important;
}

.hover-lift {
    transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
    border: 2px solid transparent;
}

.hover-lift:hover {
    transform: translateY(-2px);
    box-shadow: 0 10px 20px rgba(0,0,0,0.15);
}

/* Table Row Hover */
.hover-row {
    transition: all 0.2s ease;
}

.hover-row:hover {
    background-color: rgba(0,123,255,0.05) !important;
    transform: translateX(5px);
}

/* Avatar Circle */
.avatar-circle {
    width: 40px;
    height: 40px;
    border-radius: 50%;
    background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
    display: flex;
    align-items: center;
    justify-content: center;
    color: white;
    font-weight: bold;
    font-size: 14px;
}

/* Hover Item */
.hover-item:hover {
    background-color: rgba(0,123,255,0.1) !important;
}

/* Gradient Backgrounds */
.bg-gradient-to-r.from-green-600.to-teal-600 {
    background: linear-gradient(135deg, #059669 0%, #0d9488 100%);
}

.bg-gradient-to-r.from-emerald-500.to-green-600 {
    background: linear-gradient(135deg, #10b981 0%, #059669 100%);
}

.bg-gradient-to-r.from-green-500.to-teal-500 {
    background: linear-gradient(135deg, #10b981 0%, #14b8a6 100%);
}

/* Icon Animations */
.fa-pulse {
    animation: pulse 2s ease-in-out infinite;
}

/* Form Enhancements */
.form-control:focus, .form-select:focus {
    border-color: #10b981;
    box-shadow: 0 0 0 0.2rem rgba(16, 185, 129, 0.25);
}

/* Button Hover Effects */
.btn:hover {
    transform: translateY(-1px);
}

/* Cursor Pointer */
.cursor-pointer {
    cursor: pointer;
}

/* Modal Enhancements */
.modal-content {
    border-radius: 15px;
    overflow: hidden;
}

.modal-header {
    border-radius: 15px 15px 0 0;
}

/* Responsive */
@media (max-width: 768px) {
    .avatar-circle {
        width: 35px;
        height: 35px;
        font-size: 12px;
    }

    .table td, .table th {
        padding: 0.5rem;
        font-size: 0.875rem;
    }
}
</style>

<script>
function toggleForm() {
    const modal = new bootstrap.Modal(document.getElementById('formLaporan'));
    modal.show();
}

// User Search Functionality
document.addEventListener('DOMContentLoaded', function() {
    const userSearch = document.getElementById('user_search');
    const userDropdown = document.getElementById('user_dropdown');
    const userIdInput = document.getElementById('user_id');
    const userOptions = document.querySelectorAll('.user-option');

    // Show dropdown when input is focused
    userSearch.addEventListener('focus', function() {
        userDropdown.style.display = 'block';
        filterUsers(''); // Show all users initially
    });

    // Filter users as user types
    userSearch.addEventListener('input', function() {
        const searchTerm = this.value.toLowerCase();
        filterUsers(searchTerm);
        userDropdown.style.display = 'block';

        // Clear hidden input if search is cleared
        if (searchTerm === '') {
            userIdInput.value = '';
        }
    });

    // Handle user selection
    userOptions.forEach(option => {
        option.addEventListener('click', function() {
            const userId = this.getAttribute('data-user-id');
            const userName = this.getAttribute('data-user-name');

            userSearch.value = userName;
            userIdInput.value = userId;
            userDropdown.style.display = 'none';
        });
    });

    // Hide dropdown when clicking outside
    document.addEventListener('click', function(e) {
        if (!userSearch.contains(e.target) && !userDropdown.contains(e.target)) {
            userDropdown.style.display = 'none';
        }
    });

    // Filter function
    function filterUsers(searchTerm) {
        userOptions.forEach(option => {
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
    userSearch.addEventListener('keydown', function(e) {
        const visibleOptions = Array.from(userOptions).filter(option =>
            option.style.display !== 'none'
        );

        if (e.key === 'ArrowDown') {
            e.preventDefault();
            if (visibleOptions.length > 0) {
                visibleOptions[0].classList.add('bg-primary');
                visibleOptions[0].classList.add('text-white');
                visibleOptions[0].focus();
            }
        }
    });

    // Handle keyboard navigation in dropdown
    userOptions.forEach((option, index) => {
        option.addEventListener('keydown', function(e) {
            const visibleOptions = Array.from(userOptions).filter(opt =>
                opt.style.display !== 'none'
            );
            const currentIndex = visibleOptions.indexOf(this);

            if (e.key === 'ArrowDown') {
                e.preventDefault();
                const nextIndex = (currentIndex + 1) % visibleOptions.length;
                this.classList.remove('bg-primary', 'text-white');
                visibleOptions[nextIndex].classList.add('bg-primary', 'text-white');
                visibleOptions[nextIndex].focus();
            } else if (e.key === 'ArrowUp') {
                e.preventDefault();
                const prevIndex = currentIndex === 0 ? visibleOptions.length - 1 : currentIndex - 1;
                this.classList.remove('bg-primary', 'text-white');
                visibleOptions[prevIndex].classList.add('bg-primary', 'text-white');
                visibleOptions[prevIndex].focus();
            } else if (e.key === 'Enter') {
                e.preventDefault();
                this.click();
            }
        });
    });
});
    </script>
</x-app-layout>
