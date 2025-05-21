<?php

namespace App\Http\Controllers;

use App\Events\NewRegistered;
use App\Helpers\MetaHelpers;
use App\Models\User;
use App\Rules\Recaptcha;
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
    $meta = MetaHelpers::generateDefault('Register-Page | Blog-Post', 'Register an account to create posts with ur friends ');
    return view('auth.register', $meta);
    
  }

  public function register(Request $request)
  {

    $fields = $request->validate([
      "email" => ["required", "email", "min:5", "max:50", Rule::unique("users", "email")],
      "name" => ["required", "min:5", "max:50", "alpha"],
      "username" => ["required", "min:5", "max:15", "alpha_num",Rule::unique('users','username')],
      "phone" => ['required', 'regex:/^\+\d{8,15}$/', Rule::unique("users", "phone")],
      "password" => ["required", "alpha_num", "min:8", "max:32", "confirmed"],
      "age" => ["required", "integer", "between:18,64"]
    ],[
      'phone.regex'=>'The phone number must include a valid country code.'
    ]);

    $fields['password'] = bcrypt($fields['password']);
    $fields['email'] = htmlspecialchars(strip_tags($fields['email']));
    $fields['name'] = htmlspecialchars(strip_tags($fields['name']));
    $fields['username'] = htmlspecialchars(strip_tags($fields['username']));

    $user = User::create($fields);
    event(new Registered($user));
    // notify admin with new user
    event(new NewRegistered($user));
    auth()->login($user);
    toastr()->success('Account created successfully',['timeOut'=>1000]);
    return redirect('/');
  }

  public function loginpage()
  {
    $meta = MetaHelpers::generateDefault('Login-Page | Blog-Post', 'Welcome to login page ');
    return view('auth.login',$meta);
  }


  public function login(Request $request)
  {
    $fields = $request->validate([
      "email" => 'required|email',
      "password" => 'required',
      "g-recaptcha-response" => [new Recaptcha]
    ]);  

    if (auth()->attempt(["email" => $fields['email'], "password" => $fields['password']])) {
      if(auth()->user()->is_blocked){
        return back();
      }
    toastr()->success('logged in successfuly',['timeOut'=>1000]);

    if(auth()->user()->is_admin){
        return redirect('/admin/panel');;
      }
      return redirect('/');
    } else {
      toastr()->error('wrong credentials',['timeOut'=>1000]);
      return redirect('/login');
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
      
      toastr()->success('please check your email',['timeOut'=>2000]);
      return back();
    } else {

      toastr()->error('sorry,email not found ',['timeOut'=>1000]);
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
          "password" => ["required","min:8", "max:32", "confirmed"],
        ]);

        $user->password = bcrypt($fields['password']);

        $user->save();
        DB::table('password_reset_tokens')->where('token', $token)->delete();
        toastr()->success('password reset success',['timeOut'=>1000]);
        return redirect()->route('login');
      }
    } else {

      abort(404);
    }
  }

  public function logout()
  {
    auth()->logout();
    toastr()->success('Logged out ',['timeOut'=>1000]);
    return redirect('/');
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
