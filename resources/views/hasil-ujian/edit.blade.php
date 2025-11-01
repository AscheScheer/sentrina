@php
$rolePrefix = request()->is('admin/*') ? 'admin' : 'staff';
@endphp

<x-app-layout>
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">
                        <h4>Edit Hasil Ujian</h4>
                    </div>
                    <div class="card-body">
                        @if (session('error'))
                        <div class="alert alert-danger alert-dismissible fade show" role="alert">
                            {{ session('error') }}
                            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                        </div>
                        @endif

                        <form action="{{ route($rolePrefix.'.hasil-ujian.update', $hasilUjian->id) }}" method="POST">
                            @csrf
                            @method('PUT')

                            <div class="row">
                                <div class="col-md-6 mb-3">
                                    <label for="user_search_input" class="form-label">Nama Santri <span class="text-danger">*</span></label>
                                    <div class="position-relative">
                                        <input type="text"
                                            class="form-control @error('user_id') is-invalid @enderror"
                                            id="user_search_input"
                                            placeholder="Cari nama santri..."
                                            value="{{ old('user_id') ? $users->find(old('user_id'))->name ?? '' : ($hasilUjian->user->name ?? '') }}"
                                            autocomplete="off">
                                        <input type="hidden" name="user_id" id="selected_user_id"
                                            value="{{ old('user_id') ?? $hasilUjian->user_id }}" required>

                                        <div id="user_search_dropdown" class="user-search-dropdown">
                                            @foreach($users as $user)
                                            <div class="user-search-option"
                                                data-user-id="{{ $user->id }}"
                                                data-user-name="{{ $user->name }}">
                                                <div class="fw-semibold">{{ $user->name }}</div>
                                                <small class="text-muted">
                                                    {{ $user->kelompok->nama_kelompok ?? 'Tidak ada kelompok' }}
                                                </small>
                                            </div>
                                            @endforeach
                                        </div>
                                    </div>
                                    @error('user_id')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                    <div id="user_validation_error" class="text-danger" style="display: none;">
                                        <small>Silakan pilih santri dari daftar.</small>
                                    </div>
                                </div>

                                <div class="col-md-6 mb-3">
                                    <label for="tanggal" class="form-label">Tanggal Ujian</label>
                                    <input type="date" name="tanggal" id="tanggal"
                                        class="form-control @error('tanggal') is-invalid @enderror"
                                        value="{{ old('tanggal') ?? $hasilUjian->tanggal }}"
                                        placeholder="Kosongkan jika tidak ingin mengubah">
                                    @error('tanggal')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                    <small class="form-text text-muted">Kosongkan jika tidak ingin mengubah tanggal</small>
                                </div>
                            </div>

                            @if(Auth::guard('admin')->check() && isset($staffList))
                            <div class="row">
                                <div class="col-md-6 mb-3">
                                    <label for="staff_id" class="form-label">Staff Penguji <span class="text-danger">*</span></label>
                                    <select name="staff_id" id="staff_id" class="form-control @error('staff_id') is-invalid @enderror" required>
                                        <option value="">-- Pilih Staff --</option>
                                        @foreach($staffList as $staff)
                                        <option value="{{ $staff->id }}"
                                            {{ (old('staff_id') ?? $hasilUjian->staff_id) == $staff->id ? 'selected' : '' }}>
                                            {{ $staff->name }}
                                        </option>
                                        @endforeach
                                    </select>
                                    @error('staff_id')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="col-md-6 mb-3">
                                    <!-- Empty column for spacing -->
                                </div>
                            </div>
                            @endif

                            <div class="row">
                                <div class="col-md-6 mb-3">
                                    <label for="juz" class="form-label">Juz yang Diuji <span class="text-danger">*</span></label>
                                    <select name="juz" id="juz" class="form-control @error('juz') is-invalid @enderror" required>
                                        <option value="">-- Pilih Juz --</option>
                                        @for($i = 1; $i <= 30; $i++)
                                            <option value="Juz {{ $i }}"
                                            {{ (old('juz') ?? $hasilUjian->juz) == "Juz $i" ? 'selected' : '' }}>
                                            Juz {{ $i }}
                                            </option>
                                            @endfor
                                    </select>
                                    @error('juz')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="col-md-6 mb-3">
                                    <label for="keterangan" class="form-label">Keterangan</label>
                                    <textarea name="keterangan" id="keterangan" rows="3"
                                        class="form-control @error('keterangan') is-invalid @enderror"
                                        placeholder="Masukkan keterangan (opsional)">{{ old('keterangan') ?? $hasilUjian->keterangan }}</textarea>
                                    @error('keterangan')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>

                            <!-- Info staff yang menginput -->
                            <div class="row">
                                <div class="col-12 mb-3">
                                    <div class="alert alert-info">
                                        <strong>Info:</strong> Data ini diinput oleh <strong>{{ $hasilUjian->staff->name ?? 'Unknown' }}</strong>
                                        pada {{ \Carbon\Carbon::parse($hasilUjian->created_at)->format('d M Y H:i') }}
                                        @if($hasilUjian->created_at != $hasilUjian->updated_at)
                                        <br><small>Terakhir diupdate: {{ \Carbon\Carbon::parse($hasilUjian->updated_at)->format('d M Y H:i') }}</small>
                                        @endif
                                    </div>
                                </div>
                            </div>

                            <div class="d-flex justify-content-between">
                                <a href="{{ route($rolePrefix.'.hasil-ujian.index') }}" class="btn btn-secondary">
                                    Kembali
                                </a>
                                <button type="submit" class="btn btn-primary">
                                    Update Hasil Ujian
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <style>
        /* Custom styling for user search dropdown */
        .user-search-dropdown {
            position: absolute;
            top: 100%;
            left: 0;
            right: 0;
            background: white;
            border: 1px solid #ced4da;
            border-top: none;
            border-radius: 0 0 0.375rem 0.375rem;
            max-height: 200px;
            overflow-y: auto;
            z-index: 1050;
            display: none;
        }

        .user-search-option {
            padding: 0.5rem 0.75rem;
            cursor: pointer;
            border-bottom: 1px solid #f0f0f0;
            transition: background-color 0.15s ease-in-out;
        }

        .user-search-option:hover,
        .user-search-option:focus {
            background-color: #e9ecef;
            outline: none;
        }

        .user-search-option:last-child {
            border-bottom: none;
        }

        /* Custom styling for Select2 (for remaining dropdowns) */
        .select2-container--default .select2-selection--single {
            height: 38px;
            border: 1px solid #ced4da;
            border-radius: 0.375rem;
            padding: 0.25rem 0.5rem;
            font-size: 1rem;
        }

        .select2-container--default .select2-selection--single .select2-selection__rendered {
            line-height: 28px;
            color: #495057;
        }

        .select2-container--default .select2-selection--single .select2-selection__arrow {
            height: 36px;
        }

        .select2-dropdown {
            border: 1px solid #ced4da;
            border-radius: 0.375rem;
        }

        .select2-container--default .select2-search--dropdown .select2-search__field {
            border: 1px solid #ced4da;
            border-radius: 0.375rem;
            padding: 0.25rem 0.5rem;
        }

        .select2-container.select2-container--default.select2-container--open {
            z-index: 9999;
        }

        .card {
            box-shadow: 0 0.125rem 0.25rem rgba(0, 0, 0, 0.075);
            border: 1px solid rgba(0, 0, 0, 0.125);
            border-radius: 0.375rem;
        }

        .card-header {
            background-color: #f8f9fa;
            border-bottom: 1px solid rgba(0, 0, 0, 0.125);
            padding: 0.75rem 1.25rem;
        }

        .card-body {
            padding: 1.25rem;
        }
    </style>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // User search functionality
            const userSearchInput = document.getElementById('user_search_input');
            const userSearchDropdown = document.getElementById('user_search_dropdown');
            const selectedUserIdInput = document.getElementById('selected_user_id');
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

                // Clear hidden input if search doesn't match any user exactly
                let exactMatch = false;
                userSearchOptions.forEach(option => {
                    if (option.getAttribute('data-user-name').toLowerCase() === searchTerm) {
                        selectedUserIdInput.value = option.getAttribute('data-user-id');
                        exactMatch = true;
                    }
                });
                if (!exactMatch) {
                    selectedUserIdInput.value = '';
                }
            });

            // Handle user selection
            userSearchOptions.forEach(option => {
                option.addEventListener('click', function() {
                    const userId = this.getAttribute('data-user-id');
                    const userName = this.getAttribute('data-user-name');

                    userSearchInput.value = userName;
                    selectedUserIdInput.value = userId;
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
                    const visibleOptions = Array.from(userSearchOptions).filter(option =>
                        option.style.display !== 'none'
                    );
                    if (visibleOptions.length > 0) {
                        visibleOptions[0].click();
                    }
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

        $(document).ready(function() {
            // Initialize Select2 for juz dropdown only
            $('#juz').select2({
                placeholder: "-- Pilih Juz --",
                allowClear: true,
                width: '100%'
            });

            // Initialize Select2 for staff dropdown if exists
            if ($('#staff_id').length) {
                $('#staff_id').select2({
                    placeholder: "-- Pilih Staff --",
                    allowClear: true,
                    width: '100%'
                });
            }

            // Form validation on submit
            $('form').on('submit', function(e) {
                const selectedUserId = document.getElementById('selected_user_id').value;
                const userValidationError = document.getElementById('user_validation_error');

                if (!selectedUserId) {
                    e.preventDefault();
                    userValidationError.style.display = 'block';
                    document.getElementById('user_search_input').focus();
                    return false;
                } else {
                    userValidationError.style.display = 'none';
                }
            });
        });
    </script>
</x-app-layout>
