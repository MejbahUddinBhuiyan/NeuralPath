
<?php

use App\Models\User;
use Illuminate\Auth\Notifications\ResetPassword;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Notification;
use Illuminate\Support\Facades\Password;

uses(RefreshDatabase::class);

beforeEach(function () {
    $this->admin = User::factory()->create([
        'role' => 'admin',
        'is_active' => true,
        'email_verified_at' => now(),
        'password' => Hash::make('TestPassword123!'),
    ]);

    $this->learner = User::factory()->create([
        'role' => 'learner',
        'is_active' => true,
        'email_verified_at' => now(),
        'password' => Hash::make('TestPassword123!'),
    ]);
});

test('administrator logs in to admin dashboard', function () {
    $this->post(route('login.store'), [
        'email' => $this->admin->email,
        'password' => 'TestPassword123!',
    ])
        ->assertRedirect(route('admin.dashboard'));

    $this->assertAuthenticatedAs($this->admin);
});

test('learner logs in to learner dashboard', function () {
    $this->post(route('login.store'), [
        'email' => $this->learner->email,
        'password' => 'TestPassword123!',
    ])
        ->assertRedirect(route('learner.dashboard'));

    $this->assertAuthenticatedAs($this->learner);
});

test('inactive account cannot sign in', function () {
    $this->learner->forceFill([
        'is_active' => false,
    ])->save();

    $this->post(route('login.store'), [
        'email' => $this->learner->email,
        'password' => 'TestPassword123!',
    ])
        ->assertSessionHasErrors();

    $this->assertGuest();
});

test('unverified account cannot sign in', function () {
    $this->learner->forceFill([
        'email_verified_at' => null,
    ])->save();

    $this->post(route('login.store'), [
        'email' => $this->learner->email,
        'password' => 'TestPassword123!',
    ])
        ->assertSessionHasErrors();

    $this->assertGuest();
});

test('login page links to password recovery', function () {
    $this->get(route('login'))
        ->assertOk()
        ->assertSee('Forgot Password?')
        ->assertSee(
            route('password.request'),
            false
        );
});

test('forgot password page opens successfully', function () {
    $this->get(route('password.request'))
        ->assertOk()
        ->assertSee('Forgot your password?')
        ->assertSee('Email Password Reset Link');
});

test('forgot password request sends a reset notification', function () {
    Notification::fake();

    $this->post(route('password.email'), [
        'email' => $this->learner->email,
    ]);

    Notification::assertSentTo(
        $this->learner,
        ResetPassword::class
    );
});

test('reset password form opens using a valid token', function () {
    $token = Password::broker()->createToken($this->learner);

    $this->get(
        route('password.reset', [
            'token' => $token,
            'email' => $this->learner->email,
        ])
    )
        ->assertOk()
        ->assertSee('Create a new password')
        ->assertSee('Reset Password');
});

test('learner can reset password with a valid token', function () {
    $token = Password::broker()->createToken($this->learner);

    $this->post(route('password.update'), [
        'token' => $token,
        'email' => $this->learner->email,
        'password' => 'NewSecurePassword123!',
        'password_confirmation' => 'NewSecurePassword123!',
    ])
        ->assertSessionHas('status');

    expect(
        Hash::check(
            'NewSecurePassword123!',
            $this->learner->fresh()->password
        )
    )->toBeTrue();
});

test('invalid reset token cannot change password', function () {
    $originalHash = $this->learner->password;

    $this->post(route('password.update'), [
        'token' => 'invalid-reset-token',
        'email' => $this->learner->email,
        'password' => 'NewSecurePassword123!',
        'password_confirmation' => 'NewSecurePassword123!',
    ])
        ->assertSessionHasErrors();

    expect($this->learner->fresh()->password)
        ->toBe($originalHash);
});

test('password reset does not reactivate a suspended account', function () {
    $this->learner->forceFill([
        'is_active' => false,
    ])->save();

    $token = Password::broker()->createToken($this->learner);

    $this->post(route('password.update'), [
        'token' => $token,
        'email' => $this->learner->email,
        'password' => 'NewSecurePassword123!',
        'password_confirmation' => 'NewSecurePassword123!',
    ]);

    expect($this->learner->fresh()->isActive())
        ->toBeFalse();

    $this->post(route('login.store'), [
        'email' => $this->learner->email,
        'password' => 'NewSecurePassword123!',
    ])
        ->assertSessionHasErrors();

    $this->assertGuest();
});
