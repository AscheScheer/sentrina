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
                                    <label for="user_id" class="form-label">Nama Santri <span class="text-danger">*</span></label>
                                    <select name="user_id" id="user_id" class="form-control @error('user_id') is-invalid @enderror" required>
                                        <option value="">-- Pilih Santri --</option>
                                        @foreach($users as $user)
                                            <option value="{{ $user->id }}"
                                                {{ (old('user_id') ?? $hasilUjian->user_id) == $user->id ? 'selected' : '' }}>
                                                {{ $user->name }} - {{ $user->kelompok->nama ?? 'No Group' }}
                                            </option>
                                        @endforeach
                                    </select>
                                    @error('user_id')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="col-md-6 mb-3">
                                    <label for="tanggal" class="form-label">Tanggal Ujian <span class="text-danger">*</span></label>
                                    <input type="date" name="tanggal" id="tanggal"
                                           class="form-control @error('tanggal') is-invalid @enderror"
                                           value="{{ old('tanggal') ?? $hasilUjian->tanggal }}" required>
                                    @error('tanggal')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
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
        /* Custom styling for Select2 */
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
        $(document).ready(function() {
            // Initialize Select2 for user dropdown
            $('#user_id').select2({
                placeholder: "-- Pilih Santri --",
                allowClear: true,
                width: '100%',
                templateResult: function(data) {
                    if (!data.id) {
                        return data.text;
                    }

                    var $result = $('<span>' + data.text + '</span>');
                    return $result;
                },
                templateSelection: function(data) {
                    return data.text;
                }
            });

            // Initialize Select2 for juz dropdown
            $('#juz').select2({
                placeholder: "-- Pilih Juz --",
                allowClear: true,
                width: '100%'
            });
        });
    </script>
</x-app-layout>
