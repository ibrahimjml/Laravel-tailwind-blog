<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
  public function login(Request $request)
  {

      $request->validate([
          'email' => 'required|email',
          'password' => 'required',
      ]);

    
      if (!Auth::attempt($request->only('email', 'password'))) {
          return response()->json(['message' => 'Invalid credentials'], 401);
      }

    
      $user = $request->user();
    

      $token = $user->createToken('API Token')->plainTextToken;


      return response()->json([
          'access_token' => $token,
          'token_type' => 'Bearer',
      ], 200);
  }

  public function logout(Request $request)
  {

      $request->user()->tokens()->delete();

      return response()->json(['message' => 'Logged out successfully'], 200);
  }
}
