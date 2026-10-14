<?php

namespace App\Services;

use App\Models\Invitation;
use App\Models\User;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Illuminate\Validation\ValidationException;

class InvitationService
{
    /**
     * Create an invitation for an approved email.
     *
     * Returns the invitation and the temporary raw token.
     * Never store the raw token in the database.
     */
    public function create(
        string $email,
        User $admin
    ): array {
        if (! $admin->isAdmin() ||
            ! $admin->isActive() ||
            ! $admin->hasVerifiedEmail()) {
            throw new \Illuminate\Auth\Access\AuthorizationException(
                'Only active, verified admins can invite users.'
            );
        }

        $email = Str::lower(trim($email));

        if (! filter_var($email, FILTER_VALIDATE_EMAIL)) {
            throw ValidationException::withMessages([
                'email' => 'Enter a valid email address.',
            ]);
        }

        return DB::transaction(function () use ($email, $admin) {

            if (User::where('email', $email)->exists()) {
                throw ValidationException::withMessages([
                    'email' => 'An account already exists for this email.',
                ]);
            }

            $token = Str::random(64);

            $invitation = Invitation::updateOrCreate(
                ['email' => $email],
                [
                    'token_hash' => hash('sha256', $token),
                    'invited_by' => $admin->id,
                    'expires_at' => now()->addHours(24),
                    'accepted_at' => null,
                ]
            );

            return [
                'invitation' => $invitation,
                'token' => $token,
            ];
        });
    }

    /**
     * Find a valid invitation using its raw token.
     */
    public function findValid(string $token): ?Invitation
    {
        return Invitation::query()
            ->where('token_hash', hash('sha256', $token))
            ->whereNull('accepted_at')
            ->where('expires_at', '>', now())
            ->first();
    }
}
