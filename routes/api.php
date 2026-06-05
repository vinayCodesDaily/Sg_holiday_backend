<?php

use App\Http\Controllers\Admin\AchievementController;
use App\Http\Controllers\Admin\ActivityLogController;
use App\Http\Controllers\Admin\BannerController;
use App\Http\Controllers\Admin\CmsPageController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\DestinationController;
use App\Http\Controllers\Admin\HomeAboutController;
use App\Http\Controllers\Admin\MonthlyDestinationController;
use App\Http\Controllers\Admin\PackageController as AdminPackageController;
use App\Http\Controllers\Admin\SettingController;
use App\Http\Controllers\Admin\StatisticController;
use App\Http\Controllers\Admin\TestimonialController;
use App\Http\Controllers\Admin\TripTypeController;
use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\Admin\WhyChooseUsController;
use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\EnquiryController;
use App\Http\Controllers\Api\HomeController;
use App\Http\Controllers\Api\PackageController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Public Routes
|--------------------------------------------------------------------------
*/

Route::get('/test', function () {
    return response()->json([
        'message' => 'API Working',
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
    'index',
]);

Route::get('/trip-types/{id}', [
    TripTypeController::class,
    'show',
]);

Route::post('/enquiries', [EnquiryController::class, 'store']);

Route::get(
    '/home/monthly-destinations',
    [MonthlyDestinationController::class, 'groupedByMonth']
);
Route::get('/why-choose-us', [
    WhyChooseUsController::class,
    'index',
]);

Route::get('/achievements', [
    AchievementController::class,
    'index',
]);

Route::get('/home', [HomeController::class, 'index']);

Route::get('/statistics', [
    StatisticController::class,
    'index',
]);
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
            'getMetrics',
        ]);

        Route::get('/admin/packages', [
            AdminPackageController::class,
            'index',
        ]);

        Route::get('/admin/packages/{id}', [
            AdminPackageController::class,
            'show',
        ]);

        Route::post('/admin/packages', [
            AdminPackageController::class,
            'store',
        ]);

        Route::post('/admin/packages/{id}', [
            AdminPackageController::class,
            'update',
        ]);

        Route::get('/admin/enquiries', [
            AdminPackageController::class,
            'listEnquiries',
        ]);

        Route::patch('/admin/enquiries/{id}', [
            AdminPackageController::class,
            'updateEnquiryStatus',
        ]);

        Route::get('/admin/destinations', [DestinationController::class, 'index']);
        Route::get('/admin/destinations/{id}', [DestinationController::class, 'show']);
        Route::post('/admin/destinations', [DestinationController::class, 'store']);
        Route::post('/admin/destinations/{id}', [DestinationController::class, 'update']);

        Route::get('/admin/trip-types', [
            TripTypeController::class,
            'index',
        ]);

        Route::get('/admin/trip-types/{id}', [
            TripTypeController::class,
            'show',
        ]);

        Route::post('/admin/trip-types', [
            TripTypeController::class,
            'store',
        ]);

        Route::post('/admin/trip-types/{id}', [
            TripTypeController::class,
            'update',
        ]);

        Route::get('/admin/pages', [CmsPageController::class, 'index']);
        Route::post('/admin/pages', [CmsPageController::class, 'store']);
        Route::get('/admin/pages/{id}', [CmsPageController::class, 'show']);
        Route::put('/admin/pages/{id}', [CmsPageController::class, 'update']);
        Route::delete('/admin/pages/{id}', [CmsPageController::class, 'destroy']);

        Route::get('/admin/monthly-destinations', [
            MonthlyDestinationController::class,
            'index',
        ]);

        Route::get('/admin/monthly-destinations/{id}', [
            MonthlyDestinationController::class,
            'show',
        ]);

        Route::post('/admin/monthly-destinations', [
            MonthlyDestinationController::class,
            'store',
        ]);

        Route::post('/admin/monthly-destinations/{id}', [
            MonthlyDestinationController::class,
            'update',
        ]);

        Route::delete('/admin/monthly-destinations/{id}', [
            MonthlyDestinationController::class,
            'destroy',
        ]);

        Route::get('/admin/why-choose-us', [
            WhyChooseUsController::class,
            'index',
        ]);

        Route::get('/admin/why-choose-us/{id}', [
            WhyChooseUsController::class,
            'show',
        ]);

        Route::post('/admin/why-choose-us', [
            WhyChooseUsController::class,
            'store',
        ]);

        Route::post('/admin/why-choose-us/{id}', [
            WhyChooseUsController::class,
            'update',
        ]);

        Route::delete('/admin/why-choose-us/{id}', [
            WhyChooseUsController::class,
            'destroy',
        ]);

        Route::get('/admin/achievements', [
            AchievementController::class,
            'index',
        ]);

        Route::get('/admin/achievements/{id}', [
            AchievementController::class,
            'show',
        ]);

        Route::post('/admin/achievements', [
            AchievementController::class,
            'store',
        ]);

        Route::post('/admin/achievements/{id}', [
            AchievementController::class,
            'update',
        ]);

        Route::delete('/admin/achievements/{id}', [
            AchievementController::class,
            'destroy',
        ]);

        Route::get('/admin/home-about', [
            HomeAboutController::class,
            'show',
        ]);

        Route::post('/admin/home-about', [
            HomeAboutController::class,
            'update',
        ]);
        Route::get('/admin/statistics', [
            StatisticController::class,
            'index',
        ]);

        Route::get('/admin/statistics/{id}', [
            StatisticController::class,
            'show',
        ]);

        Route::post('/admin/statistics', [
            StatisticController::class,
            'store',
        ]);

        Route::post('/admin/statistics/{id}', [
            StatisticController::class,
            'update',
        ]);

        Route::delete('/admin/statistics/{id}', [
            StatisticController::class,
            'destroy',
        ]);

    });

    Route::middleware('role:staff')->group(function () {

        Route::get('/admin/dashboard/metrics', [
            DashboardController::class,
            'getMetrics',
        ]);

        Route::get('/admin/enquiries', [
            AdminPackageController::class,
            'listEnquiries',
        ]);

        Route::patch('/admin/enquiries/{id}', [
            AdminPackageController::class,
            'updateEnquiryStatus',
        ]);

        

    });

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
            'destroy',
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
