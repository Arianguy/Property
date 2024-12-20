<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\RoleController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\TenantController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\PropertyController;
use App\Http\Controllers\PermissionController;
use App\Http\Controllers\ContractController;
use App\Http\Controllers\TransactionController;

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

// User Management Routes
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

// Tenant Management Routes
Route::middleware(['auth'])->group(function () {
    Route::prefix('tenants')->name('tenants.')->group(function () {
        Route::get('/', [TenantController::class, 'index'])
            ->middleware('permission:view tenants')
            ->name('index');

        Route::get('/create', [TenantController::class, 'create'])
            ->middleware('permission:create tenants')
            ->name('create');

        Route::post('/', [TenantController::class, 'store'])
            ->middleware('permission:create tenants')
            ->name('store');

        Route::get('/{tenant}', [TenantController::class, 'show'])
            ->middleware('permission:view tenants')
            ->name('show');

        Route::get('/{tenant}/documents/{media}/{type}', [TenantController::class, 'viewDocument'])
            ->name('documents.view');
        Route::get('/{tenant}/documents/download/{media}/{type}', [TenantController::class, 'downloadDocument'])
            ->name('documents.download');

        Route::get('/{tenant}/edit', [TenantController::class, 'edit'])
            ->middleware('permission:edit tenants')
            ->name('edit');

        Route::put('/{tenant}', [TenantController::class, 'update'])
            ->middleware('permission:edit tenants')
            ->name('update');

        Route::delete('/{tenant}', [TenantController::class, 'destroy'])
            ->middleware('permission:delete tenants')
            ->name('destroy');

        Route::get('/edit/search', [TenantController::class, 'editSearch'])
            ->middleware('permission:edit tenants')
            ->name('edit.search'); // Ensure this route is included

        // Route::get('/{id}/download-sales-deed', [TenantController::class, 'downloadSalesDeed'])
        //     ->name('downloadSalesDeed')
        //     ->middleware('auth');
    });
});

// Contract Management Routes
Route::middleware(['auth'])->group(function () {
    Route::prefix('contracts')->name('contracts.')->group(function () {
        // List/renewal routes first (no parameters)
        Route::get('/renew', [ContractController::class, 'renewalList'])
            ->middleware('permission:create contracts')
            ->name('renew');

        // Then routes with parameters
        Route::get('/{contract}/renew', [ContractController::class, 'renewForm'])
            ->middleware('permission:create contracts')
            ->name('renew-form');

        Route::get('/', [ContractController::class, 'index'])
            ->middleware('permission:view contracts')
            ->name('index');

        Route::get('/create', [ContractController::class, 'create'])
            ->middleware('permission:create contracts')
            ->name('create');

        Route::post('/', [ContractController::class, 'store'])
            ->middleware('permission:create contracts')
            ->name('store');

        Route::get('/{contract}', [ContractController::class, 'show'])
            ->middleware('permission:view contracts')
            ->name('show');

        Route::get('/{contract}/edit', [ContractController::class, 'edit'])
            ->middleware('permission:edit contracts')
            ->name('edit');

        Route::put('/{contract}', [ContractController::class, 'update'])
            ->middleware('permission:edit contracts')
            ->name('update');

        Route::delete('/{contract}', [ContractController::class, 'destroy'])
            ->middleware('permission:delete contracts')
            ->name('destroy');

        // Route for viewing documents
        Route::get('/{contract}/documents/{media}', [ContractController::class, 'viewDocument'])
            ->name('documents.view');

        // Route for downloading documents
        Route::get('/{contract}/documents/download/{media}', [ContractController::class, 'downloadDocument'])
            ->name('documents.download'); // Ensure this line is present

        Route::post('/{contract}/renew', [ContractController::class, 'processRenewal'])
            ->middleware('permission:create contracts')
            ->name('process-renewal');

        // // Route to display the renewal form
        // Route::get('/contracts/{contract}/renew', [ContractController::class, 'renewForm'])
        //     ->middleware('permission:renew contracts')
        //     ->name('contracts.renew-form');

        // // Route to process the renewal
        // Route::post('/contracts/{contract}/renew', [ContractController::class, 'processRenewal'])
        //     ->middleware('permission:renew contracts')
        //     ->name('contracts.process-renewal');

        // // Route to display the renewal list
        // Route::get('/contracts/renewal-list', [ContractController::class, 'renewalList'])
        //     ->middleware('permission:view contracts')
        //     ->name('contracts.renewal-list');

        // Terminate route
        Route::put('/{contract}/terminate', [ContractController::class, 'terminate'])
            ->middleware(['permission:create contracts'])
            ->name('terminate');
    });
});
Route::middleware(['auth'])->group(function () {
    Route::prefix('transactions')->name('transactions.')->group(function () {

        Route::get('/', [TransactionController::class, 'index'])
            ->middleware('permission:view property')
            ->name('index');

        Route::get('/create/{contract}', [TransactionController::class, 'create'])
            ->middleware('permission:create transactions')
            ->name('create');

        Route::post('/', [TransactionController::class, 'store'])
            ->middleware('permission:create transactions')
            ->name('store');
    });
});

require __DIR__ . '/auth.php';
