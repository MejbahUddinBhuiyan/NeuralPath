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
            ! $user->canUseLearnerFeatures()
        ) {
            abort(403, 'Unauthorized learning access.');
        }

        return $next($request);
    }
}
