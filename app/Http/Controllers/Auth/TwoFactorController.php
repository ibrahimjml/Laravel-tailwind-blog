<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use SimpleSoftwareIO\QrCode\Generator;
use Illuminate\Http\Request;
use PragmaRX\Google2FA\Google2FA;
use Illuminate\Support\Facades\Crypt;

class TwoFactorController extends Controller
{
   public function __construct()
  {
    $this->middleware(['auth', 'verified'])->except(['show', 'verify','verifyRecovery','showRecovery']);
  }
  public function show()
  {
    if ($redirect = ensure_pending_two_factor_challenge()) {
        return $redirect;
    }

    return view('auth.two-factor-challenge');
  }
  public function showRecovery()
  {
    if ($redirect = ensure_pending_two_factor_challenge()) {
        return $redirect;
    }
    return view('auth.recovery-two-factor');
  }
  public function verifyRecovery(Request $request)
  {
    if ($redirect = ensure_pending_two_factor_challenge()) {
        return $redirect;
    }
    $request->validate([
      'recovery_code' => 'required|string',
    ]);
    $user = $request->user();
    $codes = json_decode(decrypt($user->two_factor_recovery_codes), true);
    $inputHash = hash('sha256', strtoupper($request->recovery_code));

    if (! in_array($inputHash, $codes)) {
      return back()->withErrors(['recovery_code' => 'Invalid recovery code']);
    }

    $codes = array_diff($codes, [$inputHash]);
    $user->two_factor_recovery_codes = encrypt(json_encode(array_values($codes)));
    $user->save();
    return $this->hasPassedChallenge($user, $request);
  }
  public function verify(Request $request, Google2FA $google2fa)
  {
    if ($redirect = ensure_pending_two_factor_challenge()) {
        return $redirect;
    }

    $request->validate([
      'code' => 'required|digits:6',
    ]);

    $user = User::findOrFail(session('2fa:user:id'));

    try {
      $secret = Crypt::decryptString($user->two_factor_secret);
    } catch (\Exception $e) {
      return back()->withErrors([
        'code' => 'Invalid secret payload',
      ]);
    }

    if ($google2fa->verifyKey($secret, $request->code)) {
      return $this->hasPassedChallenge($user, $request);
    }

    return back()->withErrors([
      'code' => 'Invalid authentication or recovery code.',
    ]);
  }
  public function enable2fa(Google2FA $google2fa, Request $request)
  {
    $secret = $google2fa->generateSecretKey();

    $request->user()->update([
      'two_factor_secret' => Crypt::encryptString($secret),
    ]);

    $issuer = config('app.name');
    $email  = $request->user()->email;

    $otpauth = $google2fa->getQRCodeUrl(
      $issuer,
      $email,
      $secret
    );
    $qrCodeGenerator = app(Generator::class);

    $qr = $qrCodeGenerator->format('png')
      ->size(220)
      ->merge(public_path('img/icon.png'), 0.25, true)
      ->backgroundColor(250, 128, 114)
      ->color(0, 0, 0)
      ->generate($otpauth);

    return view('profile-settings.partials.enable-two-factor', ['qr' => $qr, 'secret' => $secret]);
  }
  public function confirmTwofactor(Request $request, Google2FA $google2fa)
  {
    $request->validate([
      'code' => 'required|digits:6',
    ]);

    $user = $request->user();

    if (!$user->two_factor_secret) {
      return response()->json([
        'errors' => ['code' => 'Two factor secret not found']
      ], 422);
    }

    try {
      $secret = Crypt::decryptString($user->two_factor_secret);
    } catch (\Exception $e) {
      return response()->json([
        'errors' => ['code' => 'Invalid secret payload']
      ], 422);
    }

    if (!$google2fa->verifyKey($secret, $request->code)) {
      return response()->json([
        'errors' => ['code' => 'Invalid authentication code']
      ], 422);
    }

    $recoveryCodes = collect(range(1, 8))->map(fn() => [
      'code' => bcrypt(strtoupper(str()->random(10))),
      'plain' => strtoupper(str()->random(10)),
    ]);

    $user->update([
      'has_two_factor_enabled' => true,
      'two_factor_recovery_codes' => encrypt(
        $recoveryCodes->pluck('code')->toJson()
      ),
    ]);

    $request->session()->put(['2fa:passed' => true]);

    return response()->json(['success' => true]);
  }
  public function downloadRecoveryCodes()
  {
    $user = auth()->user();

    abort_unless($user->has_two_factor_enabled, 403);

    $codes = collect(range(1, 8))->map(fn() => strtoupper(str()->random(10)));

    $user->update([
      'two_factor_recovery_codes' => encrypt(
        $codes->map(fn($c) => hash('sha256', $c))->toJson()
      ),
      'recovery_codes_downloaded' => true,
    ]);

    $content = $codes->implode(PHP_EOL);

    return response()->streamDownload(
      function () use ($content) {
        echo $content;
      },
      'recovery-codes.txt'
    );
  }
  public function regenerate(Request $request)
  {
    $user = $request->user();

    abort_unless($user->has_two_factor_enabled, 403);

    $codes = collect(range(1, 8))->map(fn() =>  hash('sha256', strtoupper(str()->random(10))),);

    $user->update([
      'two_factor_recovery_codes' => encrypt($codes->toJson()),
      'recovery_codes_downloaded' => false,
    ]);

    return response()->json([
      'success' => true,
      'message' => 'Recovery codes regenerated',
    ]);
  }
  public function disable2fa(Request $request)
  {
    $user = $request->user();

    abort_unless($user->has_two_factor_enabled, 403);

    $user->update([
      'has_two_factor_enabled' => false,
      'two_factor_secret' => null,
      'two_factor_recovery_codes' => null,
      'recovery_codes_downloaded' => false,
    ]);
    
     $request->session()->forget([
        '2fa:passed',
        '2fa:user:id',
        '2fa:remember',
    ]);

    return response()->json([
      'success' => true,
      'message' => 'Two factor authentication disabled',
    ]);
  }
  protected function hasPassedChallenge(User $user, Request $request)
  {
    $remember = $request->session()->pull('2fa:remember', false);
    $request->session()->regenerate();

    $request->session()->put(['2fa:passed' => true]);

    $request->session()->forget(['2fa:user:id']);

    auth()->login($user, $remember);

    toastr()->success('Logged in successfully', ['timeOut' => 1000]);

    return redirect()->intended(
      $user->is_admin
        ? route('admin.panel')
        : route('home')
    );
  }
}
