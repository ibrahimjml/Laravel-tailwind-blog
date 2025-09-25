<?php

use App\Http\Controllers\Auth\IdentityVerificationController;
use App\Http\Controllers\AuthController;
use Illuminate\Support\Facades\Route;

Route::middleware('guest')->controller(AuthController::class)->group(function(){
  Route::get('/register','registerpage')->name('register');
  Route::post('/register','register')->name('register.post');
  
  Route::get('/login','loginpage')->name('login');
  Route::post('/login','login')->name('login.post');
  //Forget password
  Route::get('/forgotpassword','forgot')->name('forgot.password');
  Route::post('/forgotpassword','forgotpass')->name('forgot.password.post');
  //Reset password
  Route::get('/reset/{token}','reset')->name('reset.password');
  Route::post('/reset/{token}','reset_pass')->name('reset.password.post');
});

Route::middleware('auth')
->controller(AuthController::class)
->group(function(){
  Route::get('/logout','logout')->name('logout');

  // confirmation password
  Route::get('/confirm-password','index')->name('password.confirm');
  Route::post('/confirm-password', 'confirm')
  ->middleware('throttle:6,1')
  ->name('confirm.password');
  // identity verification
  Route::get('/verify-password-code', [IdentityVerificationController::class, 'showVerification'])->name('verify.code.show');
  Route::post('/verify-password-code', [IdentityVerificationController::class, 'verifyCode'])->name('verify.code');
  // email verification
  Route::get('/email/verify', 'verify_notice')
  ->name('verification.notice');
  
  Route::get('/email/verify/{id}/{hash}', 'verify_email')
  ->middleware('signed')
  ->name('verification.verify');
  
  Route::post('/email/verification-notification', 'verify_notification')
  ->middleware('throttle:6,1')
  ->name('verification.send');
});
