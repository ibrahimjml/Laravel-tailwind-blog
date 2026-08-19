<?php 

use App\Http\Controllers\Admin\Settings\ApiRateLimitController;
use Illuminate\Support\Facades\Route;

  // API rate limits
  Route::prefix('api-limits')->controller(ApiRateLimitController::class)->name('api-limits.')->group(function(){
    Route::get('/', 'index')->name('index');
    Route::post('/create', 'store')->name('store');
    Route::put('/{limit}/update', 'update')->name('update');
    Route::patch('/{limit}/status', 'toggleStatus')->name('toggle.status');
    Route::delete('/{limit}/delete', 'destroy')->name('destroy');
  });