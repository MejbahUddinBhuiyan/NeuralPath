<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\Invitation;
use App\Models\User;
use App\Services\InvitationService;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\Rules\Password;
use Illuminate\Validation\ValidationException;
use Illuminate\View\View;

class AcceptInvitationController extends Controller
{
    public function show(
        string $token,
        InvitationService $service
    ): View {
        $invitation = $service->findValid($token);

        abort_unless(
            $invitation,
            404,
            'This invitation is invalid or expired.'
        );

        return view('auth.accept-invitation', [
            'invitation' => $invitation,
            'token' => $token,
        ]);
    }

    public function store(
        Request $request,
        string $token
    ): RedirectResponse {
        $validated = $request->validate([
            'name' => [
                'required',
                'string',
                'max:255',
            ],
            'password' => [
                'required',
                'confirmed',
                Password::min(12)
                    ->mixedCase()
                    ->numbers()
                    ->symbols(),
            ],
        ]);

        DB::transaction(function () use ($token, $validated) {
            $invitation = Invitation::query()
                ->where('token_hash', hash('sha256', $token))
                ->lockForUpdate()
                ->first();

            if (
                ! $invitation ||
                ! $invitation->isValid()
            ) {
                throw ValidationException::withMessages([
                    'invitation' => 'This invitation is invalid or expired.',
                ]);
            }

            if (User::where(
                'email',
                $invitation->email
            )->exists()) {
                throw ValidationException::withMessages([
                    'invitation' => 'An account already exists for this email.',
                ]);
            }

            $user = new User();

            $user->name = $validated['name'];
            $user->email = $invitation->email;
            $user->password = $validated['password'];
            $user->role = 'learner';
            $user->is_active = true;
            $user->email_verified_at = now();

            $user->save();

            $invitation->accepted_at = now();
            $invitation->save();
        });

        return redirect()
            ->route('login')
            ->with(
                'status',
                'Your NeuralPath account is ready. Please sign in.'
            );
    }
}
