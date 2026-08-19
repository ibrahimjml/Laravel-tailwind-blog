<?php

use App\Http\Controllers\Admin\PermissionsController;
use App\Http\Controllers\Admin\RolesController;
use Illuminate\Support\Facades\Route;

// roles and permissions
Route::resource('roles', RolesController::class);
Route::resource('permissions', PermissionsController::class);