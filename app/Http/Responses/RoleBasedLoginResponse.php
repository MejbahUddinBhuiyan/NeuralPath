<?php

namespace App\Http\Responses;

use Illuminate\Http\Request;
use Laravel\Fortify\Contracts\LoginResponse;
use Symfony\Component\HttpFoundation\Response;

class RoleBasedLoginResponse implements LoginResponse
{
    public function toResponse($request): Response
    {
        if ($request->wantsJson()) {
            return response()->json([
                'two_factor' => false,
            ]);
        }

        $user = $request->user();

        $destination = $user && $user->isAdmin()
            ? route('admin.dashboard')
            : route('learner.dashboard');

        // Redirect to the correct dashboard for the account role.
        return redirect()->to($destination);
    }
}
