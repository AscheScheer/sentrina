<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\StaffLoginController;
use App\Http\Controllers\Auth\AdminLoginController;
use App\Http\Controllers\LaporanController;
use App\Http\Controllers\AdminLaporanController;
use App\Http\Controllers\StaffLaporanController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\StaffController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\StaffDashboardController;
use App\Http\Controllers\AdminDashboardController;
use App\Http\Controllers\ExportController;
use App\Http\Controllers\StaffExportController;
use App\Http\Controllers\AdminExportController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\Auth\KepsekLoginController;
use App\Http\Controllers\KepsekDashboardController;
use App\Http\Controllers\KepsekLaporanController;
use App\Http\Controllers\UserImportController;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
    Route::resource('laporan', LaporanController::class);
    Route::get('/export-pdf', [ExportController::class, 'exportPdf'])->name('export.pdf');
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
    Route::get('/profile', [UserController::class, 'editProfile'])->name('profile.edit');
    Route::post('/profile', [UserController::class, 'updateProfile'])->name('profile.update');
});

// Staff login routes
Route::get('/staff/login', [StaffLoginController::class, 'showLoginForm'])->name('staff.login');
Route::post('/staff/login', [StaffLoginController::class, 'login'])->name('staff.login.submit');
Route::post('/staff/logout', [StaffLoginController::class, 'logout'])->name('staff.logout');

// Staff dashboard (after login)
Route::middleware('auth:staff')->group(function () {
    Route::get('/staff/dashboard', function () {
        return view('staff-dashboard');
    })->name('staff.dashboard');
    Route::get('/staff/laporan', function () {
        return view('laporan.index-staff');
    })->name('staff.laporan.index');
    Route::get('/staff/laporan', [StaffLaporanController::class, 'index'])->name('staff.laporan.index');
    Route::get('/staff/laporan/create', [StaffLaporanController::class, 'create'])->name('staff.laporan.create');
    Route::post('/staff/laporan', [StaffLaporanController::class, 'store'])->name('staff.laporan.store');
    Route::get('/staff/laporan/{laporan}/edit', [StaffLaporanController::class, 'edit'])->name('staff.laporan.edit');
    Route::put('/staff/laporan/{laporan}', [StaffLaporanController::class, 'update'])->name('staff.laporan.update');
    Route::delete('/staff/laporan/{laporan}', [StaffLaporanController::class, 'destroy'])->name('staff.laporan.destroy');
    Route::get('/staff/dashboard', [StaffDashboardController::class, 'index'])->name('staff.dashboard');
    Route::get('/staffexport-pdf', [StaffExportController::class, 'exportPdf'])->name('staff.export.pdf');
    Route::get('/staff/profile', [StaffController::class, 'editProfile'])->name('staff.profile.edit');
    Route::post('/staff/profile', [StaffController::class, 'updateProfile'])->name('staff.profile.update');
});
// Admin login routes
Route::get('/admin/login', [AdminLoginController::class, 'showLoginForm'])->name('admin.login');
Route::post('/admin/login', [AdminLoginController::class, 'login'])->name('admin.login.submit');
Route::post('/admin/logout', [AdminLoginController::class, 'logout'])->name('admin.logout');

// Admin dashboard (after login)
Route::middleware('auth:admin')->group(function () {
    Route::get('/admin/dashboard', function () {
        return view('admin-dashboard');
    })->name('admin.dashboard');
    Route::get('/admin/laporan', function () {
        return view('laporan.index-admin');
    })->name('admin.laporan.index');
    Route::get('/admin/laporan', [AdminLaporanController::class, 'index'])->name('admin.laporan.index');
    Route::get('/admin/laporan/create', [AdminLaporanController::class, 'create'])->name('admin.laporan.create');
    Route::post('/admin/laporan', [AdminLaporanController::class, 'store'])->name('admin.laporan.store');
    Route::get('/admin/laporan/{laporan}/edit', [AdminLaporanController::class, 'edit'])->name('admin.laporan.edit');
    Route::put('/admin/laporan/{laporan}', [AdminLaporanController::class, 'update'])->name('admin.laporan.update');
    Route::delete('/admin/laporan/{laporan}', [AdminLaporanController::class, 'destroy'])->name('admin.laporan.destroy');
    Route::prefix('admin')->name('admin.')->group(function () {
        Route::resource('users', UserController::class);
        Route::resource('staff', StaffController::class);
        Route::resource('admin', AdminController::class);
    });
    Route::get('/admin/dashboard', [AdminDashboardController::class, 'index'])->name('admin.dashboard');
    Route::get('/admin/export-pdf', [AdminExportController::class, 'exportPdf'])->name('admin.export.pdf');
    Route::get('/admin/profile', [AdminController::class, 'editProfile'])->name('admin.profile.edit');
    Route::post('/admin/profile', [AdminController::class, 'updateProfile'])->name('admin.profile.update');
});

// Kepsek login routes
Route::get('/kepsek/login', [App\Http\Controllers\Auth\KepsekLoginController::class, 'showLoginForm'])->name('kepsek.login');
Route::post('/kepsek/login', [App\Http\Controllers\Auth\KepsekLoginController::class, 'login'])->name('kepsek.login.submit');
Route::post('/kepsek/logout', [App\Http\Controllers\Auth\KepsekLoginController::class, 'logout'])->name('kepsek.logout');

// Kepsek dashboard (after login)
Route::middleware('auth:kepsek')->group(function () {
    Route::get('/kepsek/dashboard', function () {
        return view('kepsek-dashboard');
    })->name('kepsek.dashboard');
    // Add more kepsek routes here as needed
    Route::get('/kepsek/dashboard', [App\Http\Controllers\KepsekDashboardController::class, 'index'])->name('kepsek.dashboard');
    Route::get('/kepsek/laporan', [KepsekLaporanController::class, 'index'])->name('kepsek.laporan.index');
    Route::get('/kepsek/users', [UserController::class, 'index'])->name('kepsek.users.index');
    Route::get('/kepsek/staff', [StaffController::class, 'index'])->name('kepsek.staff.index');
    Route::get('/kepsek/admin', [AdminController::class, 'index'])->name('kepsek.admin.index');
    Route::get('/kepsek/export-pdf', [App\Http\Controllers\ExportController::class, 'exportPdf'])->name('kepsek.export.pdf');
    Route::get('/kepsek/profile', [App\Http\Controllers\KepsekController::class, 'editProfile'])->name('kepsek.profile.edit');
    Route::post('/kepsek/profile', [App\Http\Controllers\KepsekController::class, 'updateProfile'])->name('kepsek.profile.update');
});
Route::get('/users/import', [UserImportController::class, 'index'])->name('users.import');
Route::post('/users/import', [UserImportController::class, 'import'])->name('users.import.store');


require __DIR__ . '/auth.php';
