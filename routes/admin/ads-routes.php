<?php

use App\Http\Controllers\Admin\Ads\AdController;
use Illuminate\Support\Facades\Route;

// Ads management
Route::prefix('ads')->controller(AdController::class)->name('ads.')->group(function () {
  Route::get('/', 'index')->name('index');
  Route::post('/create', 'store')->name('store');
  Route::put('/{ad}/update', 'update')->name('update');
  Route::patch('/{ad}/status', 'toggleStatus')->name('toggle.status');
  Route::delete('/{ad}/delete', 'destroy')->name('destroy');
});