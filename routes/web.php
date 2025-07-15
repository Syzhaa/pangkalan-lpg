<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\MemberRegistrationController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\VariantController;
use App\Http\Controllers\Admin\BrandController;
use App\Http\Controllers\Admin\ProductController;
use App\Http\Controllers\Admin\TransactionController;
use App\Http\Controllers\Admin\ReportController;
use App\Http\Controllers\Admin\MemberController;
use App\Http\Controllers\Admin\TestimonialController;
use App\Http\Controllers\Admin\SettingController;

use App\Http\Controllers\HomeController;
/*
|--------------------------------------------------------------------------
| Rute Publik
|--------------------------------------------------------------------------
|
| Rute yang dapat diakses oleh semua pengunjung tanpa perlu login.
|
*/



Route::get('/', [HomeController::class, 'index'])->name('home');

// Pendaftaran Member (tanpa login)
Route::get('/pendaftaran-member', [MemberRegistrationController::class, 'create'])->name('member.register');
Route::post('/pendaftaran-member', [MemberRegistrationController::class, 'store'])->name('member.store');


/*
|--------------------------------------------------------------------------
| Rute Admin Panel
|--------------------------------------------------------------------------
|
| Semua rute ini dilindungi oleh middleware 'auth' dan 'admin'.
|
*/

Route::prefix('admin')->middleware(['auth', 'admin'])->group(function () {

    // Dashboard
    Route::get('/', [DashboardController::class, 'index'])->name('admin.dashboard');

    // Manajemen Data Master
    Route::resource('variants', VariantController::class);
    Route::resource('brands', BrandController::class);
    Route::resource('products', ProductController::class);
    Route::resource('testimonials', TestimonialController::class);
    Route::get('settings', [SettingController::class, 'index'])->name('settings.index');
    Route::post('settings', [SettingController::class, 'update'])->name('settings.update');

    // Manajemen Member
    Route::get('members/pending', [MemberController::class, 'pending'])->name('members.pending');
    Route::patch('members/{user}/approve', [MemberController::class, 'approve'])->name('members.approve');
    Route::get('members', [MemberController::class, 'index'])->name('members.index');
    Route::delete('members/{user}', [MemberController::class, 'destroy'])->name('members.destroy');
    Route::get('members/create', [MemberController::class, 'create'])->name('members.create');
    Route::post('members', [MemberController::class, 'store'])->name('members.store');
    Route::get('members/{user}/edit', [MemberController::class, 'edit'])->name('members.edit');
    Route::put('members/{user}', [MemberController::class, 'update'])->name('members.update');

    // Manajemen Transaksi (POS)
    Route::get('transactions', [TransactionController::class, 'index'])->name('transactions.index');
    Route::get('transactions/create', [TransactionController::class, 'create'])->name('transactions.create');
    Route::post('transactions', [TransactionController::class, 'store'])->name('transactions.store');
    Route::get('transactions/{transaction}', [TransactionController::class, 'show'])->name('transactions.show');
    Route::get('transactions/{transaction}/print', [TransactionController::class, 'print'])->name('transactions.print');
    Route::patch('transactions/{transaction}/update-status', [TransactionController::class, 'updateStatus'])->name('transactions.update_status');

    // Laporan
    Route::prefix('reports')->name('reports.')->group(function () {
        Route::get('sales', [ReportController::class, 'sales'])->name('sales');
        Route::get('sales/export', [ReportController::class, 'exportSales'])->name('sales.export');
        Route::get('profit-loss', [ReportController::class, 'profitAndLoss'])->name('profit_loss');
    });
});

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

// File yang berisi rute login, logout, forgot password, dll.
require __DIR__ . '/auth.php';