<?php

use App\Http\Controllers\Admin\Analytics\AnalyticsController;
use Illuminate\Support\Facades\Route;

// Analytics
Route::prefix('analytics')->controller(AnalyticsController::class)->name('analytics.')->group(function () {

  Route::get('/', 'index')->name('index')->middleware('permission:analytics.view');

  Route::group(['permission' => 'analytics.update'], function (): void {
    Route::put('/update', 'updateAnalytics')->name('update');
    Route::post('/json', 'jsonUploadFile')->name('json');
  });
});