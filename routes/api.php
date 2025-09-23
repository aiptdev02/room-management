<?php

use App\Http\Controllers\Admin\AdminController;
use App\Http\Controllers\AssignLabourSardarController;
use App\Http\Controllers\AttendanceController;
use App\Http\Controllers\BoqController;
use App\Http\Controllers\DailyProgressController;
use App\Http\Controllers\Front\FrontController;
use App\Http\Controllers\HeadofAcController;
use App\Http\Controllers\MaterialManagementController;
use App\Http\Controllers\MaterialReceiptController;
use App\Http\Controllers\MaterialRequestPoController;
use App\Http\Controllers\MaterialsAtSiteController;
use App\Http\Controllers\MatPoOrderController;
use App\Http\Controllers\MoneyIndentController;
use App\Http\Controllers\SiteExpenseController;
use App\Http\Controllers\SiteManagementController;
use App\Http\Controllers\SiteOrderController;
use App\Http\Controllers\SubAreaController;
use App\Http\Controllers\UtilizationController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');
Route::controller(FrontController::class)->group(function () {
    Route::post('login-user', 'loginApi');
    Route::post('logout', 'logout');
});

Route::middleware('auth:sanctum')->group(function () {
    Route::controller(FrontController::class)->group(function () {
        Route::post('logout', 'logout');
    });
});

Route::group(['middleware' => ['auth:sanctum']], function () {
});
