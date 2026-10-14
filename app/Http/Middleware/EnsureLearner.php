<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class EnsureLearner
{
    public function handle(
        Request $request,
        Closure $next
    ): Response {
        $user = $request->user();

        if (
            ! $user ||
            ! $user->isLearner() ||
            ! $user->isActive() ||
            ! $user->hasVerifiedEmail()
        ) {
            abort(403, 'Unauthorized learner access.');
        }

        return $next($request);
    }
}
