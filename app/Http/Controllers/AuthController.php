<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Support\Str;
use App\Mail\ForgotPassword;
use Illuminate\Auth\Events\Registered;
use Illuminate\Foundation\Auth\EmailVerificationRequest;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;

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
      "username" => ["required", "min:5", "max:15", "alpha_num",Rule::unique('users','username')],
      "phone" => ["min:8", Rule::unique("users", "phone")],
      "password" => ["required", "alpha_num", "min:8", "max:32", "confirmed"],
      "age" => ["required", "integer", "between:18,64"]
    ]);

    $fields['password'] = bcrypt($fields['password']);
    $fields['email'] = htmlspecialchars(strip_tags($fields['email']));
    $fields['name'] = htmlspecialchars(strip_tags($fields['name']));
    $fields['username'] = htmlspecialchars(strip_tags($fields['username']));

    $user = User::create($fields);
    event(new Registered($user));
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
      
        return view('auth.reset',['token' => $token]);
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
          "password" => ["required","min:8", "max:32", "confirmed"],
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

  public function index()
    {
      return view('auth.confirmpassword');
    }

    public function confirm(Request $request)
    {
      
        if (! Hash::check($request->password, $request->user()->password)) {
            return back()->withErrors([
                'password' => ['The provided password does not match our records.']
            ]);
        }
     
        $request->session()->passwordConfirmed();
     
        return redirect()->intended();
      }

      public function verify_notice()
      {
        return view('auth.verifyemail',['message'=>session('message')]);
      }
  
      public function verify_email(EmailVerificationRequest $request)
      {
        $request->fulfill();
        return redirect('/');
      }
      public function verify_notification(Request $request) 
      {
        $request->user()->sendEmailVerificationNotification();
      
        return back()->with('message', 'Verification link sent!');
      }
}
