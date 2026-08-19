<?php

use App\Http\Controllers\Admin\MediaSettingController;
use App\Http\Controllers\Admin\Settings\AuthSecurityController;
use App\Http\Controllers\Admin\Settings\BackupsController;
use App\Http\Controllers\Admin\Settings\ManageNotificationController;
use App\Http\Controllers\Admin\Settings\SmtpController;
use Illuminate\Support\Facades\Route;

// system settings
Route::prefix('settings')->name('settings.')->group(function () {
  // auth and security 
  Route::controller(AuthSecurityController::class)->group(function () {
    Route::get('/auth-settings', 'auth_settings')->name('auth.index');
    Route::put('/auth-settings', 'update_auth_settings')->name('auth.update');
  });
  // media settings
  Route::prefix('media')->controller(MediaSettingController::class)->name('media.')->group(function () {
    Route::get('/', 'index')->name('index');
    Route::put('/update', 'mediaSettingUpdate')->name('update');
  });
  // backups 
  Route::controller(BackupsController::class)->group(function () {
    Route::get('db-backup', 'backup_view')->name('backup.view');
    Route::get('backup-download/{file}', 'backup_download')->name('backup.download');
    Route::delete('/backup-delete/{file}', 'backup_destroy')->name('backup.destroy');
  });
  // manage notifications
  Route::controller(ManageNotificationController::class)->group(function () {
    Route::get('/notification-controls', 'notification_view')->name('notification.view');
    Route::patch('/notification-controls', 'toggle_notification')->name('notification.toggle');
  });
  // smtp mail
  Route::controller(SmtpController::class)->group(function () {
    Route::get('/smtpmails', 'smtp')->name('smtp');
    Route::post('/smtpmails', 'smtp_config')->name('smtp.config');
    Route::post('/testmail', 'testmail')->name('smtp.test');
  });
});