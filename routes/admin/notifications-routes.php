<?php

use App\Http\Controllers\Admin\NotificationsController;
use Illuminate\Support\Facades\Route;

// notifications
Route::controller(NotificationsController::class)
      ->prefix('notifications')
      ->name('notifications.')
      ->group(function () {
  Route::get('/', 'notifications')->name('index');
  Route::get('/notifications/{id}/read', 'markasread')->name('read');
  });