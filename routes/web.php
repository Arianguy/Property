<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\RoleController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\PropertyController;
use App\Http\Controllers\PermissionController;

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
});


Route::middleware(['auth', 'role:Super Admin'])->group(function () {
    Route::prefix('admin')->name('admin.')->group(function () {
        // User Management
        Route::resource('users', UserController::class);
        // Role Management
        Route::resource('roles', RoleController::class);
        // Permission Management
        Route::resource('permissions', PermissionController::class);
    });
});

// Property Management Routes
Route::middleware(['auth'])->group(function () {
    Route::prefix('properties')->name('properties.')->group(function () {
        Route::get('/', [PropertyController::class, 'index'])
            ->middleware('permission:view property')
            ->name('index');

        Route::get('/create', [PropertyController::class, 'create'])
            ->middleware('permission:create property')
            ->name('create');

        Route::post('/', [PropertyController::class, 'store'])
            ->middleware('permission:create property')
            ->name('store');

        Route::get('/{property}', [PropertyController::class, 'show'])
            ->middleware('permission:view property')
            ->name('show');

        Route::get('/{property}/edit', [PropertyController::class, 'edit'])
            ->middleware('permission:edit property')
            ->name('edit'); // Add the 'edit' route here

        Route::put('/{property}', [PropertyController::class, 'update'])
            ->middleware('permission:edit property')
            ->name('update'); // Add the 'update' route for saving edits

        Route::delete('/{property}', [PropertyController::class, 'destroy'])
            ->middleware('permission:delete property')
            ->name('destroy');

        Route::get('/edit/search', [PropertyController::class, 'editSearch'])
            ->middleware('permission:edit property')
            ->name('edit.search'); // Ensure this route is included

        Route::get('/{id}/download-sales-deed', [PropertyController::class, 'downloadSalesDeed'])
            ->name('downloadSalesDeed')
            ->middleware('auth');
    });
});



require __DIR__ . '/auth.php';
