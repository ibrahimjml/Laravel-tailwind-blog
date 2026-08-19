<?php

namespace App\Services\User;

use App\Models\ActiveSession;
use App\Models\RevokedBrowserSession;
use App\Models\User;
use App\Support\UserAgentSupport;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;

class ActiveSessionService
{
    public function record(User $user, Request $request, string $browserToken): void
    {
        $sessionId = $request->session()->getId();

        if (! $sessionId) {
            return;
        }

        [$browser, $platform] = UserAgentSupport::parse($request->userAgent());

        $attributes = [
            'user_id' => $user->id,
            'session_id' => $sessionId,
            'browser_token' => hash('sha256', $browserToken),
            'ip_address' => $request->ip(),
            'user_agent' => $request->userAgent(),
            'browser' => $browser,
            'platform' => $platform,
            'last_active_at' => now(),
            'logged_out_at' => null,
        ];

        $activeSession = ActiveSession::query()
            ->where('user_id', $user->id)
            ->where('browser_token', $attributes['browser_token'])
            ->first();

        if ($activeSession) {
            $activeSession->update($attributes);

            return;
        }

        ActiveSession::updateOrCreate([ 'session_id' => $sessionId ], $attributes);
    }

    public function isBrowserRevoked(string $browserToken): bool
    {
        return RevokedBrowserSession::query()
            ->where('browser_token', hash('sha256', $browserToken))
            ->exists();
    }

    public function isRevoked(User $user, string $sessionId): bool
    {
        return ActiveSession::query()
            ->where('user_id', $user->id)
            ->where('session_id', $sessionId)
            ->whereNotNull('logged_out_at')
            ->exists();
    }

    public function logout(ActiveSession $session, Request $request): void
    {
        $request->session()->getHandler()->destroy($session->session_id);

        if ($session->browser_token) {
            RevokedBrowserSession::updateOrCreate(
                ['browser_token' => $session->browser_token],
                ['user_id' => $session->user_id, 'revoked_at' => Carbon::now()],
            );
        }

        $session->delete();
    }

}
