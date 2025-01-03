<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\Auth\AuthenticatedSessionController;

// Public routes
Route::get('/', function () {
    return view('auth.login');
});

// Dashboard route for authenticated users
Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

// Authenticated routes
Route::middleware('auth')->group(function () {
    // Profile routes
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    // Dashboard routes
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

    // Admin-only routes using the role middleware
    Route::middleware(\App\Http\Middleware\CheckRole::class . ':admin')->group(function () {
        // Add Employee and Client
        Route::post('/admin/add-employee', [DashboardController::class, 'addEmployee']);
        Route::post('/admin/add-client', [DashboardController::class, 'addClient']);

        // Edit and Delete User
        Route::get('/admin/edit-user/{id}', [DashboardController::class, 'editUser'])->name('admin.edit-user');
        Route::post('/admin/edit-user/{id}', [DashboardController::class, 'updateUser'])->name('admin.update-user');
        Route::delete('/admin/delete-user/{id}', [DashboardController::class, 'deleteUser'])->name('admin.delete-user');
    });
});

// Include authentication routes
require __DIR__ . '/auth.php';
