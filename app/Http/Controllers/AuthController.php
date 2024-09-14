<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class AuthController extends Controller
{
    public function registerpage(){
      return view('register');
    }

    public function register(Request $request){
          
      $fields = $request->validate([
      "email" => ["required", "email", "min:5", "max:50", Rule::unique("users", "email")],
      "name" => ["required", "min:5", "max:50", "alpha"],
      "phone" => ["min:8", Rule::unique("users", "phone")],
      "password" => ["required", "alpha_num", "min:8", "max:32", "confirmed"],
      "age" => ["required", "integer", "between:18,64"]
      ]);

      $fields['password']=bcrypt($fields['password']);
      $fields['email']=strip_tags($fields['email']);
      $fields['name']=strip_tags($fields['name']);
      $user =User::create($fields);
      auth()->login($user);
      return redirect('/')->with('success','Account created successfully');
    }
    
    public function loginpage(){
      return view('login');
    }


    public function login(Request $request){
      $fields = $request->validate([
         "email" => 'required|email',
         "password" => 'required'
      ]);

      if(auth()->attempt(["email"=>$fields['email'],"password"=>$fields['password']])){
        return redirect('/')->with('success','logged in successfuly');
      }else{
        return redirect('/login')->with('error','wrong credentials');
      }
    }

    public function logout(){
      auth()->logout();
      return redirect('/')->with('success','Logged out ');
    }
}
