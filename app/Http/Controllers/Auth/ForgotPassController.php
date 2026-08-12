<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Mail\ForgotPassword;
use App\Models\User;
use App\Rules\Recaptcha;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Str;

class ForgotPassController extends Controller
{
  public function reset($token)
  {

    $resetToken = DB::table('password_reset_tokens')->where('token', $token)->first();
    if ($resetToken) {
      $user = User::where('email', $resetToken->email)->first();
      if (!empty($user)) {

        return view('auth.reset', ['token' => $token]);
      }
    } else {
      abort(404);
    }
  }


  public function forgotpass(Request $request)
  {

    $fields = $request->validate([
      "email" => ["required", "email", "min:5", "max:50"],
      "g-recaptcha-response" => [new Recaptcha()]
    ]);
    $fields['email'] = htmlspecialchars(strip_tags($fields['email']));

    $user = User::where('email', '=', $fields['email'])->first();
    if (!empty($user)) {

      $token = Str::random(40);
      DB::table('password_reset_tokens')->updateOrInsert(
        ['email' => $user->email],
        ['token' => $token, 'created_at' => now()]
      );
      $user->save();

      Mail::to($user->email)->queue(new ForgotPassword($user, $token));

      toastr()->success('please check your email', ['timeOut' => 2000]);
      return back();
    } else {

      toastr()->error('sorry,email not found ', ['timeOut' => 1000]);
      return back();
    }
  }

  public function reset_pass($token, Request $request)
  {

    $resetToken = DB::table('password_reset_tokens')->where('token', $token)->first();

    if ($resetToken) {
      $user = User::where('email', $resetToken->email)->first();
      if (!empty($user)) {
        $fields = $request->validate([
          "password" => ["required", "min:8", "max:32", "confirmed"],
        ]);

        $user->password = bcrypt($fields['password']);

        $user->save();
        DB::table('password_reset_tokens')->where('token', $token)->delete();
        toastr()->success('password reset success', ['timeOut' => 1000]);
        return redirect()->route('login');
      }
    } else {

      abort(404);
    }
  }
}
