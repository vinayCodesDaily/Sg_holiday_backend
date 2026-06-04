<?php

use Illuminate\Support\Facades\Route;

use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\PackageController;
use App\Http\Controllers\Api\EnquiryController;

use App\Http\Controllers\Admin\PackageController as AdminPackageController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\DestinationController;
use App\Http\Controllers\Admin\SourceController;
use App\Http\Controllers\Admin\TripTypeController;
use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\Admin\SettingController;
use App\Http\Controllers\Admin\BannerController;
use App\Http\Controllers\Admin\TestimonialController;
use App\Http\Controllers\Admin\CmsPageController;

use App\Http\Controllers\Admin\ActivityLogController;



/*
|--------------------------------------------------------------------------
| Public Routes
|--------------------------------------------------------------------------
*/

Route::get('/test', function () {
    return response()->json([
        'message' => 'API Working'
    ]);
});

Route::get('/pages/{slug}', [CmsPageController::class, 'getBySlug']);

Route::get('/testimonials', [TestimonialController::class, 'index']);
Route::get('/packages', [PackageController::class, 'index']);
Route::get('/packages/{slug}', [PackageController::class, 'show']);
Route::get('/destinations', [DestinationController::class, 'index']);
Route::get('/destinations/{id}', [DestinationController::class, 'show']);

Route::get('/trip-types', [
    TripTypeController::class,
    'index'
]);

Route::get('/trip-types/{id}', [
    TripTypeController::class,
    'show'
]);

Route::post('/enquiries', [EnquiryController::class, 'store']);

/*
|--------------------------------------------------------------------------
| Protected Routes
|--------------------------------------------------------------------------
*/
Route::post('/login', [AuthController::class, 'login']);
Route::get('/profile', [AuthController::class, 'profile'])
    ->middleware('auth:sanctum');

Route::middleware('auth:sanctum')->group(function () {

    Route::post('/logout', [AuthController::class, 'logout']);

    /*
    |--------------------------------------------------------------------------
    | Super Admin + Admin + Manager
    |--------------------------------------------------------------------------
    */

    Route::middleware('role:super-admin,admin,manager')->group(function () {

        Route::get('/admin/dashboard/metrics', [
            DashboardController::class,
            'getMetrics'
        ]);

        Route::get('/admin/packages', [
            AdminPackageController::class,
            'index'
        ]);

        Route::get('/admin/packages/{id}', [
            AdminPackageController::class,
            'show'
        ]);

        Route::post('/admin/packages', [
            AdminPackageController::class,
            'store'
        ]);

        Route::post('/admin/packages/{id}', [
            AdminPackageController::class,
            'update'
        ]);

        Route::get('/admin/enquiries', [
            AdminPackageController::class,
            'listEnquiries'
        ]);

        Route::patch('/admin/enquiries/{id}', [
            AdminPackageController::class,
            'updateEnquiryStatus'
        ]);
    });
    Route::get('/admin/destinations', [DestinationController::class, 'index']);
    Route::get('/admin/destinations/{id}', [DestinationController::class, 'show']);
    Route::post('/admin/destinations', [DestinationController::class, 'store']);
    Route::post('/admin/destinations/{id}', [DestinationController::class, 'update']);
    Route::delete('/admin/destinations/{id}', [DestinationController::class, 'destroy']);

    Route::get('/admin/trip-types', [
        TripTypeController::class,
        'index'
    ]);

    Route::get('/admin/trip-types/{id}', [
        TripTypeController::class,
        'show'
    ]);

    Route::post('/admin/trip-types', [
        TripTypeController::class,
        'store'
    ]);

    Route::post('/admin/trip-types/{id}', [
        TripTypeController::class,
        'update'
    ]);

    Route::delete('/admin/trip-types/{id}', [
        TripTypeController::class,
        'destroy'
    ]);


    Route::get('/admin/pages', [CmsPageController::class, 'index']);
    Route::post('/admin/pages', [CmsPageController::class, 'store']);
    Route::get('/admin/pages/{id}', [CmsPageController::class, 'show']);
    Route::put('/admin/pages/{id}', [CmsPageController::class, 'update']);
    Route::delete('/admin/pages/{id}', [CmsPageController::class, 'destroy']);

    /*
    |--------------------------------------------------------------------------
    | Super Admin + Admin Only
    |--------------------------------------------------------------------------
    */

    Route::middleware('role:super-admin,admin')->group(function () {

        Route::get('/admin/users', [UserController::class, 'index']);

        Route::get('/admin/users/{id}', [UserController::class, 'show']);

        Route::post('/admin/users', [UserController::class, 'store']);

        Route::post('/admin/users/{id}', [UserController::class, 'update']);

        Route::delete('/admin/users/{id}', [UserController::class, 'destroy']);

        Route::delete('/admin/packages/{id}', [
            AdminPackageController::class,
            'destroy'
        ]);

        Route::get(
            '/admin/settings',
            [SettingController::class, 'show']
        );

        Route::post(
            '/admin/settings',
            [SettingController::class, 'update']
        );

        Route::get('/admin/banners', [BannerController::class, 'index']);
        Route::post('/admin/banners', [BannerController::class, 'store']);
        Route::post('/admin/banners/{id}', [BannerController::class, 'update']);
        Route::delete('/admin/banners/{id}', [BannerController::class, 'destroy']);


        Route::get('/admin/testimonials', [TestimonialController::class, 'index']);
        Route::post('/admin/testimonials', [TestimonialController::class, 'store']);
        Route::put('/admin/testimonials/{id}', [TestimonialController::class, 'update']);
        Route::delete('/admin/testimonials/{id}', [TestimonialController::class, 'destroy']);


        Route::get('/admin/activity-logs', [ActivityLogController::class, 'index']);
    Route::get('/admin/activity-logs/{id}', [ActivityLogController::class, 'show']);
    Route::delete('/admin/activity-logs/{id}', [ActivityLogController::class, 'destroy']);
    });
});
