<?php 

use App\Http\Controllers\Admin\CustomPageController;
use Illuminate\Support\Facades\Route;

  // custom pages
  Route::controller(CustomPageController::class)
        ->prefix('custom-pages')
        ->name('custom-pages.')
        ->group(function () {
  Route::get('/', 'index')->name('index');
  Route::get('/create', 'create')->name('create');
  Route::post('/create', 'store')->name('store');
  Route::get('/{page}/edit', 'edit')->name('edit');
  Route::put('/{page}/edit', 'update')->name('update');
  Route::delete('/{page}/delete', 'destroy')->name('delete');
  });