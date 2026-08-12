<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class ConfirmPassController extends Controller
{
  /**
   * Handle the incoming request.
   */
  public function __invoke(Request $request)
  {
    if (!Hash::check($request->password, $request->user()->password)) {
      return back()->withErrors([
        'password' => ['The provided password does not match our records.']
      ]);
    }

    $request->session()->passwordConfirmed();

    return redirect()->intended();
  }
}
