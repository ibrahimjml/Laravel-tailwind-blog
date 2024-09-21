<?php

namespace App\Http\Controllers;

use App\Mail\ForgotPassword;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;
use Illuminate\Validation\Rule;
use Illuminate\Support\Str;

class AuthController extends Controller
{
  public function registerpage()
  {
    return view('auth.register');
  }

  public function register(Request $request)
  {

    $fields = $request->validate([
      "email" => ["required", "email", "min:5", "max:50", Rule::unique("users", "email")],
      "name" => ["required", "min:5", "max:50", "alpha"],
      "phone" => ["min:8", Rule::unique("users", "phone")],
      "password" => ["required", "alpha_num", "min:8", "max:32", "confirmed"],
      "age" => ["required", "integer", "between:18,64"]
    ]);

    $fields['password'] = bcrypt($fields['password']);
    $fields['email'] = htmlspecialchars(strip_tags($fields['email']));
    $fields['name'] = htmlspecialchars(strip_tags($fields['name']));

    $user = User::create($fields);
    auth()->login($user);
    return redirect('/')->with('success', 'Account created successfully');
  }

  public function loginpage()
  {
    return view('auth.login');
  }


  public function login(Request $request)
  {
    $fields = $request->validate([
      "email" => 'required|email',
      "password" => 'required'
    ]);

    if (auth()->attempt(["email" => $fields['email'], "password" => $fields['password']])) {
      return redirect('/')->with('success', 'logged in successfuly');
    } else {
      return redirect('/login')->with('error', 'wrong credentials');
    }
  }

  public function forgot()
  {
    return view('auth.forgot');
  }

  public function reset($token)
  {

    $resetToken = DB::table('password_reset_tokens')->where('token', $token)->first();
    if ($resetToken) {
      $user = User::where('email', $resetToken->email)->first();
      if (!empty($user)) {
        $data['user'] = $user;
        return view('auth.reset', $data, ['token' => $token]);
      }
    } else {
      abort(404);
    }
  }


  public function forgotpass(Request $request)
  {

    $fields = $request->validate([
      "email" => ["required", "email", "min:5", "max:50"],
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
      Mail::to($user->email)->send(new ForgotPassword($user, $token));
      return back()->with('success', 'please check your email');
    } else {
      return back()->with('error', 'sorry,email not found ');
    }
  }

  public function reset_pass($token, Request $request)
  {

    $resetToken = DB::table('password_reset_tokens')->where('token', $token)->first();

    if ($resetToken) {
      $user = User::where('email', $resetToken->email)->first();
      if (!empty($user)) {
        $fields = $request->validate([
          "password" => ["required", "alpha_num", "min:8", "max:32", "confirmed"],
        ]);

        $user->password = bcrypt($fields['password']);

        $user->save();
        DB::table('password_reset_tokens')->where('token', $token)->delete();
        return redirect()->route('login')->with('success', 'password reset success');
      }
    } else {

      abort(404);
    }
  }

  public function logout()
  {
    auth()->logout();
    return redirect('/')->with('success', 'Logged out ');
  }
}
