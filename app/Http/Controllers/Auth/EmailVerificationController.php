<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\EmailVerificationRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class EmailVerificationController extends Controller
{
  public function verify_notice()
  {
    $user = auth()->user();
    if ($user->hasVerifiedEmail()) {
      return redirect()->route('blog');
    }
    return view('auth.verifyemail', ['message' => session('message')]);
  }

  public function verify_email(EmailVerificationRequest $request)
  {
    $request->fulfill();
    return redirect('/');
  }
  public function verify_notification(Request $request)
  {
    $user = $request->user();

    if (!$user) {
      return redirect()->route('login');
    }

    if ($user->hasVerifiedEmail()) {
      return redirect('/')->with('message', 'Your email is already verified.');
    }

    try {
      $user->sendEmailVerificationNotification();
    } catch (\Throwable $exception) {
      Log::error('Unable to send verification email.', [
        'user_id' => $user->id,
        'message' => $exception->getMessage(),
      ]);

      return back()->with('message', 'Unable to send verification email. Please check your mail settings.');
    }

    return back()->with('message', 'Verification link sent!');
  }
}
