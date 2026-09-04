<?php

use App\Http\Controllers\Admin\UsersController;
use Illuminate\Support\Facades\Route;

// users
Route::controller(UsersController::class)->prefix('users')->name('users.')->group(function () {
  
  Route::get('/', 'users')->name('page')->middleware('permission:user.view');
  Route::post('/create', 'createUser')->name('create')->middleware('permission:user.create');
  Route::put('/{user}/edit', 'updateUser')->name('update');
  Route::put('/{user}/role', 'role')->name('role');
  Route::patch('/{user}/activate', 'activateUser')->name('activate');
  Route::put('/{user}/toggle', 'toggle')->name('block');
  Route::delete('/{user}/delete', 'destroy')->name('delete');
});