<?php

use App\Http\Controllers\Admin\PropertyController;
use App\Http\Controllers\RentCollectionController;
use App\Http\Controllers\RoomAssignmentController;
use App\Http\Controllers\RoomController;
use App\Http\Controllers\MasterController;
use App\Http\Controllers\PayingGuestController;
use App\Http\Controllers\WhatsAppController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/


Route::controller(MasterController::class)->group(function () {
    Route::get('/', 'index');
    Route::get('/login', 'index');
    Route::post('master-login', 'master_login');
});

Route::middleware('masteraccess')->group(function () {
    Route::controller(MasterController::class)->prefix('master')->group(function () {
        Route::get('dashboard', 'dashboard');
        Route::resource('paying-guests', PayingGuestController::class);
        Route::resource('properties', PropertyController::class);
        Route::resource('tenents', RoomController::class)->name('rooms', 'tenents');
        Route::get('/rooms/by-property/{property}', [RoomController::class, 'getRoomsByProperty'])->name('rooms.byProperty');
        Route::get('/rooms/unassigned-rooms/{property}', [RoomController::class, 'getUnassignedRooms'])->name('rooms.unassignedRooms');

        Route::get('assignments/create', [RoomAssignmentController::class, 'create'])->name('assignments.create');
        Route::post('assignments/store', [RoomAssignmentController::class, 'store'])->name('assignments.store');
        Route::post('assignments/auto-assign', [RoomAssignmentController::class, 'autoAssign'])->name('assignments.auto');
        Route::post('assignments/{assignment}/unassign', [RoomAssignmentController::class, 'unassign'])->name('assignments.unassign');
        Route::resource('rent_collections', RentCollectionController::class);
        Route::get('/send-reminder/{guest}', [WhatsAppController::class, 'sendRentReminder'])->name('send.reminder');

        Route::resource('masters', MasterController::class)->except(['show']);
        Route::post('masters/{id}/restore', [MasterController::class, 'restore'])->name('masters.restore');
        Route::get('sub-admins', [MasterController::class, 'indexList'])->name('masters.indexList');
        Route::get('change-password', [MasterController::class, 'showChangePasswordForm'])->name('change-password.form');
        Route::put('change-password', [MasterController::class, 'updatePassword'])->name('change-password.update');

    });
});
