<?php

namespace App\Http\Controllers\Auth;

use App\Exceptions\Auth\RegisterException;
use App\Http\Controllers\Controller;
use App\Http\Requests\App\Auth\RegisterRequest;
use App\Models\CustomPage;
use App\Services\Auth\RegisterUserService;

class RegisterController extends Controller
{
  public function registerpage()
  {
    abort_unless_require_registration();
    $terms = CustomPage::firstWhere('slug', 'terms-of-service');
    $privacy = CustomPage::firstWhere('slug', 'privacy-policy');
    return view('auth.register', ['terms' => $terms, 'privacy' => $privacy]);

  }

  public function register(RegisterRequest $request, RegisterUserService $service)
  {
    abort_unless_require_registration();
    try {
      $result = $service->register($request->toDTO());

      return response()->json([
        'success' => true,
        'message' => $result['message'],
        'redirect' => route('login'),
      ]);
    } catch (RegisterException $e) {
      return response()->json([
        'success' => false,
        'message' => $e->getMessage(),
      ], 422);
    }
  }
}
