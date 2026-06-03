<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\API\PackageController;
use App\Http\Controllers\Admin\PackageController as AdminPackageController;
use App\Http\Controllers\API\EnquiryController;
use App\Http\Controllers\API\AuthController;
use App\Http\Controllers\Admin\DashboardController;




Route::get('/test', function () {
    return response()->json([
        'message' => 'API Working'
    ]);
});

// Public routes for the front-end holiday website
Route::get('/packages', [PackageController::class, 'index']);
Route::get('/packages/{slug}', [PackageController::class, 'show']);

// Admin Content Operations Dashboard Endpoints
Route::post('/admin/packages', [AdminPackageController::class, 'store']);

// Public enquiry endpoint for the customer frontend website
Route::post('/enquiries', [EnquiryController::class, 'store']);


// Admin Enquiry Management Endpoints
Route::get('/admin/enquiries', [AdminPackageController::class, 'listEnquiries']);
Route::patch('/admin/enquiries/{id}', [AdminPackageController::class, 'updateEnquiryStatus']);

Route::prefix('admin')
    ->middleware('auth:sanctum')
    ->group(function () {

        Route::apiResource(
            'packages',
            PackageController::class
        );

        Route::get(
            'enquiries',
            [PackageController::class, 'listEnquiries']
        );

        Route::put(
            'enquiries/{id}/status',
            [PackageController::class, 'updateEnquiryStatus']
        );
    });


    Route::middleware('auth:sanctum')->group(function () {
    
    // Auth Management
    Route::post('/logout', [AuthController::class, 'logout']);

    /* Tier 1 & 2: Package creation and modification (Super Admin + Admin + Manager) */
    Route::middleware('role:super_admin,admin,manager')->group(function () {
        Route::get('/admin/packages', [AdminPackageController::class, 'index']);
        Route::get('/admin/packages/{id}', [AdminPackageController::class, 'show']);
        Route::post('/admin/packages', [AdminPackageController::class, 'store']);
        Route::post('/admin/packages/{id}', [AdminPackageController::class, 'update']);
        Route::get('/admin/enquiries', [AdminPackageController::class, 'listEnquiries']);
        Route::patch('/admin/enquiries/{id}', [AdminPackageController::class, 'updateEnquiryStatus']);
    });

    /* Tier 3: High-level Destructive Actions (Strictly Super Admin + Admin Only) */
    Route::middleware('role:super_admin,admin')->group(function () {
        Route::delete('/admin/packages/{id}', [AdminPackageController::class, 'destroy']);
    });
    
});


Route::middleware('auth:sanctum')->group(function () {
    
    // Auth Management
    Route::post('/logout', [AuthController::class, 'logout']);

    /* Multi-Role Level Access (Super Admin + Admin + Manager) */
    Route::middleware('role:super_admin,admin,manager')->group(function () {
        // Main Admin Dashboard Metrics Stream
        Route::get('/admin/dashboard/metrics', [DashboardController::class, 'getMetrics']);

        // Package Management & Enquiry Review Rules
        Route::get('/admin/packages', [AdminPackageController::class, 'index']);
        Route::get('/admin/packages/{id}', [AdminPackageController::class, 'show']);
        Route::post('/admin/packages', [AdminPackageController::class, 'store']);
        Route::post('/admin/packages/{id}', [AdminPackageController::class, 'update']);
        Route::get('/admin/enquiries', [AdminPackageController::class, 'listEnquiries']);
        Route::patch('/admin/enquiries/{id}', [AdminPackageController::class, 'updateEnquiryStatus']);
    });

    /* Strict Higher Admin Management Operations */
    Route::middleware('role:super_admin,admin')->group(function () {
        Route::delete('/admin/packages/{id}', [AdminPackageController::class, 'destroy']);
    });
});
