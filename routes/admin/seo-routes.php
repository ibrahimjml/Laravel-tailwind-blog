<?php

use App\Http\Controllers\Admin\Optimization\SeoController;
use Illuminate\Support\Facades\Route;

Route::prefix('seo')->controller(SeoController::class)->name('seo.')->group(function () {
  Route::get('/', 'index')->name('index')->middleware('permission:seo.view');
  Route::put('/update', 'update')->name('update')->middleware('permission:seo.update');
});