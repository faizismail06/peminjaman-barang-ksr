<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\ItemController;
use App\Http\Controllers\BorrowingController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

// Public Routes
Route::get('/', [HomeController::class, 'index'])->name('home');
Route::get('/katalog', [HomeController::class, 'katalog'])->name('katalog');

// Borrowing Routes (Public)
Route::get('/borrowings', [BorrowingController::class, 'index'])->name('borrowings.index');
Route::get('/borrowings/create', [BorrowingController::class, 'create'])->name('borrowings.create');
Route::post('/borrowings', [BorrowingController::class, 'store'])->name('borrowings.store');
Route::get('/borrowings/success', [BorrowingController::class, 'success'])->name('borrowings.success');

// Auth Routes
Route::get('/login', [AuthController::class, 'showLoginForm'])->name('login')->middleware('guest');
Route::post('/login', [AuthController::class, 'login'])->middleware('guest');
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

// Admin Routes (Protected)
Route::middleware(['auth'])->prefix('admin')->name('admin.')->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

    // Item Management
    Route::resource('items', ItemController::class);

    // Borrowing Management
    Route::get('/borrowings', [BorrowingController::class, 'adminIndex'])->name('borrowings.index');
    Route::get('/borrowings/{borrowing}', [BorrowingController::class, 'show'])->name('borrowings.show');
    Route::post('/borrowings/{borrowing}/approve', [BorrowingController::class, 'approve'])->name('borrowings.approve');
    Route::post('/borrowings/{borrowing}/reject', [BorrowingController::class, 'reject'])->name('borrowings.reject');
    Route::post('/borrowings/{borrowing}/returned', [BorrowingController::class, 'returned'])->name('borrowings.returned');
});
