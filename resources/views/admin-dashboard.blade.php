<x-app-layout>

<div class="container-fluid px-4 mt-2">
    <!-- Welcome Card -->
    <div class="row mb-4">
        <div class="col-12">
            <div class="card border-0 shadow-lg bg-gradient-to-r from-emerald-500 to-teal-600 text-white overflow-hidden">
                <div class="card-body p-4 position-relative">
                    <div class="row align-items-center">
                        <div class="col-md-8">
                            <h3 class="fw-bold mb-2">
                                <i class="fas fa-crown me-2"></i>
                                Selamat Datang, Admin!
                            </h3>
                            <p class="mb-0 opacity-90">
                                Kelola data pengguna, staff, dan pantau aktivitas sistem tahfidz dengan dashboard yang comprehensive
                            </p>
                        </div>
                        <div class="col-md-4 text-end d-none d-md-block">
                            <i class="fas fa-user-shield fa-4x opacity-25"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Statistics Cards -->
    <div class="row g-4 mb-4">
        <!-- Total Users Card -->
        <div class="col-lg-4 col-md-6">
            <div class="card border-0 shadow-sm h-100 hover-card">
                <div class="card-body p-4">
                    <div class="d-flex align-items-center">
                        <div class="flex-shrink-0 p-3 bg-primary bg-opacity-10 rounded-3">
                            <i class="fas fa-users fa-2x text-primary"></i>
                        </div>
                        <div class="flex-grow-1 ms-3">
                            <h6 class="text-muted mb-1 fw-semibold">Total Users</h6>
                            <h2 class="fw-bold text-primary mb-0">{{ number_format($jumlahUser) }}</h2>
                            <small class="text-success">
                                <i class="fas fa-arrow-up"></i> Santri Aktif
                            </small>
                        </div>
                    </div>
                </div>
                <div class="card-footer bg-primary bg-opacity-5 border-0 py-2">
                    <small class="text-white" sty>
                        <i class="fas fa-info-circle me-1"></i>
                        Jumlah santri yang terdaftar
                    </small>
                </div>
            </div>
        </div>

        <!-- Total Staff Card -->
        <div class="col-lg-4 col-md-6">
            <div class="card border-0 shadow-sm h-100 hover-card">
                <div class="card-body p-4">
                    <div class="d-flex align-items-center">
                        <div class="flex-shrink-0 p-3 bg-success bg-opacity-10 rounded-3">
                            <i class="fas fa-chalkboard-teacher fa-2x text-success"></i>
                        </div>
                        <div class="flex-grow-1 ms-3">
                            <h6 class="text-muted mb-1 fw-semibold">Total Staff</h6>
                            <h2 class="fw-bold text-success mb-0">{{ number_format($jumlahStaff) }}</h2>
                            <small class="text-info">
                                <i class="fas fa-check-circle"></i> Pengajar Aktif
                            </small>
                        </div>
                    </div>
                </div>
                <div class="card-footer bg-success bg-opacity-5 border-0 py-2">
                    <small class="text-white">
                        <i class="fas fa-info-circle me-1"></i>
                        Staff pengajar tahfidz
                    </small>
                </div>
            </div>
        </div>

        <!-- Total Admin Card -->
        <div class="col-lg-4 col-md-6">
            <div class="card border-0 shadow-sm h-100 hover-card">
                <div class="card-body p-4">
                    <div class="d-flex align-items-center">
                        <div class="flex-shrink-0 p-3 bg-warning bg-opacity-10 rounded-3">
                            <i class="fas fa-user-cog fa-2x text-warning"></i>
                        </div>
                        <div class="flex-grow-1 ms-3">
                            <h6 class="text-muted mb-1 fw-semibold">Total Admin</h6>
                            <h2 class="fw-bold text-warning mb-0">{{ number_format($jumlahAdmin) }}</h2>
                            <small class="text-danger">
                                <i class="fas fa-shield-alt"></i> Super User
                            </small>
                        </div>
                    </div>
                </div>
                <div class="card-footer bg-warning bg-opacity-5 border-0 py-2">
                    <small class="text-muted">
                        <i class="fas fa-info-circle me-1"></i>
                        Staff Admin
                    </small>
                </div>
            </div>
        </div>
    </div>

    <!-- Quick Actions -->
    <div class="row mb-4">
        <div class="col-12">
            <div class="card border-0 shadow-sm">
                <div class="card-header bg-light border-0 py-3">
                    <h5 class="mb-0 fw-bold text-dark">
                        <i class="fas fa-bolt text-warning me-2"></i>
                        Quick Actions
                    </h5>
                </div>
                <div class="card-body p-4">
                    <div class="row g-3">
                        <div class="col-md-3 col-sm-6">
                            <a href="{{ route('admin.users.index') }}" class="btn btn-outline-primary btn-lg w-100 h-100 d-flex flex-column align-items-center justify-content-center text-decoration-none hover-lift">
                                <i class="fas fa-users fa-2x mb-2"></i>
                                <span class="fw-semibold">Kelola User</span>
                                <small class="text-muted">Manage santri</small>
                            </a>
                        </div>
                        <div class="col-md-3 col-sm-6">
                            <a href="{{ route('admin.staff.index') }}" class="btn btn-outline-success btn-lg w-100 h-100 d-flex flex-column align-items-center justify-content-center text-decoration-none hover-lift">
                                <i class="fas fa-chalkboard-teacher fa-2x mb-2"></i>
                                <span class="fw-semibold">Kelola Staff</span>
                                <small class="text-muted">Manage pengajar</small>
                            </a>
                        </div>
                        <div class="col-md-3 col-sm-6">
                            <a href="{{ route('admin.hasil-ujian.index') }}" class="btn btn-outline-info btn-lg w-100 h-100 d-flex flex-column align-items-center justify-content-center text-decoration-none hover-lift">
                                <i class="fas fa-clipboard-list fa-2x mb-2"></i>
                                <span class="fw-semibold">Hasil Ujian</span>
                                <small class="text-muted">Monitor ujian</small>
                            </a>
                        </div>
                        <div class="col-md-3 col-sm-6">
                            <a href="{{ route('admin.laporan.index') }}" class="btn btn-outline-warning btn-lg w-100 h-100 d-flex flex-column align-items-center justify-content-center text-decoration-none hover-lift">
                                <i class="fas fa-chart-bar fa-2x mb-2"></i>
                                <span class="fw-semibold">Laporan</span>
                                <small class="text-muted">View reports</small>
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- System Info -->
    <div class="row">
        <div class="col-12">
            <div class="card border-0 shadow-sm">
                <div class="card-body p-4 text-center">
                    <div class="row align-items-center">
                        <div>
                            <h5 class="fw-bold text-dark mb-2">
                                <i class="fas fa-cog text-primary me-2"></i>
                                Sentri App
                            </h5>
                            <p class="text-muted mb-0">
                                Dashboard admin untuk mengelola data santri, staff, dan monitoring laporan tahfidz
                            </p>
                        </div>
                    </div>
                </div>
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
    transform: translateY(-8px);
    box-shadow: 0 20px 40px rgba(0,0,0,0.12) !important;
    border-color: rgba(0,0,0,0.15);
}

.hover-lift {
    transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
    border: 2px solid transparent;
}

.hover-lift:hover {
    transform: translateY(-5px);
    box-shadow: 0 15px 30px rgba(0,0,0,0.15);
    border-color: rgba(255,255,255,0.2);
}

/* Gradient Backgrounds */
.bg-gradient-to-r.from-blue-600.to-purple-600 {
    background: linear-gradient(135deg, #2563eb 0%, #9333ea 100%);
}

.bg-gradient-to-r.from-emerald-500.to-teal-600 {
    background: linear-gradient(135deg, #10b981 0%, #0d9488 100%);
    position: relative;
    overflow: hidden;
}

.bg-gradient-to-r.from-emerald-500.to-teal-600::before {
    content: '';
    position: absolute;
    top: 0;
    left: 0;
    right: 0;
    bottom: 0;
    background: url('data:image/svg+xml,<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 100 100"><defs><pattern id="grain" width="100" height="100" patternUnits="userSpaceOnUse"><circle cx="50" cy="50" r="1" fill="rgba(255,255,255,0.1)"/></pattern></defs><rect width="100" height="100" fill="url(%23grain)"/></svg>');
    opacity: 0.3;
}

/* Icon Animations */
.fa-crown, .fa-user-shield {
    animation: float 3s ease-in-out infinite;
}

@keyframes float {
    0%, 100% { transform: translateY(0px); }
    50% { transform: translateY(-10px); }
}

/* Card Icon Background Pulse */
.flex-shrink-0 {
    position: relative;
    overflow: hidden;
}

.flex-shrink-0::before {
    content: '';
    position: absolute;
    top: 50%;
    left: 50%;
    width: 0;
    height: 0;
    background: rgba(255,255,255,0.2);
    border-radius: 50%;
    transform: translate(-50%, -50%);
    transition: all 0.5s ease;
}

.hover-card:hover .flex-shrink-0::before {
    width: 100px;
    height: 100px;
}

/* Number Counter Animation */
.fw-bold {
    display: inline-block;
    transition: all 0.3s ease;
}

.hover-card:hover .fw-bold {
    transform: scale(1.1);
    color: #ffffff !important;
}

/* Quick Action Button Styles */
.btn-outline-primary:hover,
.btn-outline-success:hover,
.btn-outline-info:hover,
.btn-outline-warning:hover {
    transform: translateY(-3px) scale(1.02);
}

/* Header Gradient Animation */
.bg-gradient-to-r.from-blue-600.to-purple-600 {
    background-size: 200% 200%;
    animation: gradientShift 8s ease infinite;
}

@keyframes gradientShift {
    0% { background-position: 0% 50%; }
    50% { background-position: 100% 50%; }
    100% { background-position: 0% 50%; }
}

/* Welcome Card Pattern */
.bg-gradient-to-r.from-emerald-500.to-teal-600 {
    background-size: 200% 200%;
    animation: gradientShift 10s ease infinite;
}

/* Pulse Animation for Icons */
.fa-pulse {
    animation: pulse 2s ease-in-out infinite;
}

/* Statistics Counter Animation */
@keyframes countUp {
    from { opacity: 0; transform: translateY(20px); }
    to { opacity: 1; transform: translateY(0); }
}

.fw-bold {
    animation: countUp 0.8s ease-out;
}

/* Grid Pattern Animation */
@keyframes gridMove {
    0% { transform: translate(0, 0); }
    100% { transform: translate(40px, 40px); }
}

#grid {
    animation: gridMove 20s linear infinite;
}

/* Responsive adjustments */
@media (max-width: 768px) {
    .hover-card:hover {
        transform: translateY(-3px);
    }

    .hover-lift:hover {
        transform: translateY(-2px);
    }

    .fa-4x {
        font-size: 2.5rem !important;
    }

    .container-fluid {
        padding-left: 15px;
        padding-right: 15px;
    }

    .card-body {
        padding: 1.5rem !important;
    }

    .display-4 {
        font-size: 2rem !important;
    }
}

@media (max-width: 576px) {
    .btn-lg {
        padding: 0.75rem 1rem;
        font-size: 0.9rem;
    }

    .fa-2x {
        font-size: 1.5rem !important;
    }

    .col-md-3 {
        margin-bottom: 1rem;
    }
}

/* Loading shimmer effect */
.card-body {
    position: relative;
    overflow: hidden;
}

.card-body::before {
    content: '';
    position: absolute;
    top: 0;
    left: -100%;
    width: 100%;
    height: 100%;
    background: linear-gradient(90deg, transparent, rgba(255,255,255,0.1), transparent);
    transition: left 0.5s;
}

.hover-card:hover .card-body::before {
    left: 100%;
}
</style>
</x-app-layout>
