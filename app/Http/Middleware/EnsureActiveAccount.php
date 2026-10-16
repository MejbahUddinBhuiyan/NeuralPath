<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class EnsureActiveAccount
{
public function handle(
    \Illuminate\Http\Request $request,
    \Closure $next
): \Symfony\Component\HttpFoundation\Response {
    $user = $request->user();

    if (
        $user &&
        (
            ! $user->isActive() ||
            ! $user->hasVerifiedEmail()
        )
    ) {
        \Illuminate\Support\Facades\Auth::guard('web')->logout();

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
