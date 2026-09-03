<?php

use App\Http\Controllers\Admin\NotificationsController;
use Illuminate\Support\Facades\Route;

// notifications
Route::prefix('notifications')->controller(NotificationsController::class)->name('notifications.')->group(function () {

  Route::get('/', 'notifications')->name('index')->middleware('permission:notifications.view');

  Route::get('/notifications/{id}/read', 'markasread')->name('read');
});