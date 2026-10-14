<?php

use App\Models\User;
use App\Services\InvitationService;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Hash;

uses(RefreshDatabase::class);

function makeLearnerInvitation(): array
{
    $admin = User::factory()->create([
        'role' => 'admin',
        'is_active' => true,
        'email_verified_at' => now(),
    ]);

    return app(InvitationService::class)->create(
        'student@example.com',
        $admin
    );
}

test('valid invitation creates a learner account', function () {
    $result = makeLearnerInvitation();

    $response = $this->post(
        route('invitations.complete', [
            'token' => $result['token'],
        ]),
        [
            'name' => 'Test Learner',
            'password' => 'SecurePass123!',
            'password_confirmation' => 'SecurePass123!',
        ]
    );

    $response->assertRedirect(route('login'));

    $learner = User::where(
        'email',
        'student@example.com'
    )->firstOrFail();

    expect($learner->role)->toBe('learner');
    expect($learner->is_active)->toBeTrue();
    expect($learner->hasVerifiedEmail())->toBeTrue();

    expect(
        Hash::check('SecurePass123!', $learner->password)
    )->toBeTrue();

    expect(
        $result['invitation']->fresh()->accepted_at
    )->not->toBeNull();
});

test('an invitation cannot be used twice', function () {
    $result = makeLearnerInvitation();

    $data = [
        'name' => 'Test Learner',
        'password' => 'SecurePass123!',
        'password_confirmation' => 'SecurePass123!',
    ];

    $url = route('invitations.complete', [
        'token' => $result['token'],
    ]);

    $this->post($url, $data)
        ->assertRedirect(route('login'));

    $this->post($url, $data)
        ->assertSessionHasErrors('invitation');

    expect(
        User::where('email', 'student@example.com')->count()
    )->toBe(1);
});

test('expired invitation cannot create an account', function () {
    $result = makeLearnerInvitation();

    $result['invitation']->update([
        'expires_at' => now()->subMinute(),
    ]);

    $this->post(
        route('invitations.complete', [
            'token' => $result['token'],
        ]),
        [
            'name' => 'Test Learner',
            'password' => 'SecurePass123!',
            'password_confirmation' => 'SecurePass123!',
        ]
    )->assertSessionHasErrors('invitation');

    $this->assertDatabaseMissing('users', [
        'email' => 'student@example.com',
    ]);
});

test('invalid invitation cannot open registration', function () {
    $this->get(
        route('invitations.accept', [
            'token' => 'invalid-token',
        ])
    )->assertNotFound();
});

test('weak password cannot complete registration', function () {
    $result = makeLearnerInvitation();

    $this->post(
        route('invitations.complete', [
            'token' => $result['token'],
        ]),
        [
            'name' => 'Test Learner',
            'password' => '123456',
            'password_confirmation' => '123456',
        ]
    )->assertSessionHasErrors('password');

    $this->assertDatabaseMissing('users', [
        'email' => 'student@example.com',
    ]);
});
