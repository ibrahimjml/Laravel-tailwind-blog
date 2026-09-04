<?php


use App\Http\Controllers\Admin\ApiRateLimit\ApiRateLimitController;
use Illuminate\Support\Facades\Route;

// API rate limits
Route::prefix('api-limits')->controller(ApiRateLimitController::class)->name('api-limits.')->group(function () {

  Route::get('/', 'index')->name('index')->middleware('permission:limit.view');

  Route::post('/create', 'store')->name('store')->middleware('permission:limit.create');

  Route::group(['permission' => 'limit.update'], function (): void {
    Route::put('/{limit}/update', 'update')->name('update');
    Route::patch('/{limit}/status', 'toggleStatus')->name('toggle.status');
  });

  Route::delete('/{limit}/delete', 'destroy')->name('destroy')->middleware('permission:limit.delete');
});