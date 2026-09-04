<?php

use App\Http\Controllers\Admin\Ads\AdController;
use Illuminate\Support\Facades\Route;

// Ads management
Route::prefix('ads')->controller(AdController::class)->name('ads.')->group(function () {

  Route::get('/', 'index')->name('index')->middleware('permission:ad.view');

  Route::post('/create', 'store')->name('store')->middleware('permission:ad.create');

  Route::group(['permission' => 'ad.update'], function (): void {
    Route::put('/{ad}/update', 'update')->name('update');
    Route::patch('/{ad}/status', 'toggleStatus')->name('toggle.status');
  });

  Route::delete('/{ad}/delete', 'destroy')->name('destroy')->middleware('permission:ad.delete');
});