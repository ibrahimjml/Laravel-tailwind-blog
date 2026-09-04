<?php

use App\Http\Controllers\Admin\Optimization\ImageOptimizationController;
use App\Http\Controllers\Admin\Optimization\MaintenanceController;
use Illuminate\Support\Facades\Route;


Route::prefix('optimize')->name('optimize.')->group(function () {
  // maintenance settings
  Route::controller(MaintenanceController::class)->group(function () {
    Route::get('/maintenance', 'maintenance_page')->name('maintenance')->middleware('permission:maintenance.view');
    Route::post('/run', 'run_artisans')->name('run')->middleware('permission:maintenance.update');
  });
  // image optimization
  Route::controller(ImageOptimizationController::class)->group(function () {
    Route::get('/image-optimization', 'index')
      ->name('image.optimization')
      ->middleware('permission:imageoptimization.view');
    Route::put('/image-optimization', 'imageOptimizationUpdate')
      ->name('image.optimization.update')
      ->middleware('permission:imageoptimization.update');
  });
});