<?php

use App\Http\Controllers\Admin\Analytics\AnalyticsController;
use Illuminate\Support\Facades\Route;

// Analytics
Route::controller(AnalyticsController::class)->prefix('analytics')->name('analytics.')->group(function () {
  Route::get('/', 'index')->name('index');
  Route::put('/update', 'updateAnalytics')->name('update');
  Route::post('/json', 'jsonUploadFile')->name('json');
});