<?php

use App\Http\Controllers\Admin\CustomPageController;
use Illuminate\Support\Facades\Route;

// custom pages

Route::prefix('custom-pages')->controller(CustomPageController::class)->name('custom-pages.')->group(function () {

  Route::get('/', 'index')->name('index')->middleware('permission:custompage.view');

  Route::group(['permission' => 'custompage.create'], function (): void {
    Route::get('/create', 'create')->name('create');
    Route::post('/create', 'store')->name('store');
  });

  Route::group(['permission' => 'custompage.update'], function (): void {
    Route::get('/{page}/edit', 'edit')->name('edit');
    Route::put('/{page}/edit', 'update')->name('update');
  });

  Route::delete('/{page}/delete', 'destroy')->name('delete')->middleware('permission:custompage.delete');
});