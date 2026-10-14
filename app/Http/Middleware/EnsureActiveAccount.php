<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class EnsureActiveAccount
{
    public function handle(
        Request $request,
        Closure $next
    ): Response {
        $user = $request->user();

        if (! $user) {
            return $next($request);
        }

        // Retrieve the latest account status from the database.
        $freshUser = $user->fresh();

        if (
            ! $freshUser ||
            ! $freshUser->isActive() ||
            ! $freshUser->hasVerifiedEmail()
        ) {
            Auth::guard('web')->logout();

            $request->session()->invalidate();
            $request->session()->regenerateToken();

            return redirect()
                ->route('login')
                ->withErrors([
                    'email' => 'Your account is inactive or not verified. Please contact the administrator.',
                ]);
        }

        return $next($request);
    }
}
