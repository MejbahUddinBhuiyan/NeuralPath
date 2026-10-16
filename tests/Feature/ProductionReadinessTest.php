
<?php

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Laravel\Fortify\Features;

uses(RefreshDatabase::class);

test('public registration is disabled', function () {
    expect(
        Features::enabled(Features::registration())
    )->toBeFalse();
});

test('password recovery is enabled', function () {
    expect(
        Features::enabled(Features::resetPasswords())
    )->toBeTrue();

    $this->get(route('password.request'))
        ->assertOk();
});

test('two factor authentication is disabled', function () {
    expect(
        Features::enabled(Features::twoFactorAuthentication())
    )->toBeFalse();
});

test('passkeys are disabled', function () {
    expect(
        Features::enabled(Features::passkeys())
    )->toBeFalse();
});

test('guests can visit the landing page', function () {
    $this->get('/')
        ->assertOk()
        ->assertSee('NeuralPath')
        ->assertSee('Request Access');
});

test('guests cannot access private dashboards', function () {
    $this->get(route('admin.dashboard'))
        ->assertRedirect(route('login'));

    $this->get(route('learner.dashboard'))
        ->assertRedirect(route('login'));
});

test('learner cannot access administration', function () {
    $learner = User::factory()->create([
        'role' => 'learner',
        'is_active' => true,
        'email_verified_at' => now(),
    ]);

    $this->actingAs($learner)
        ->get(route('admin.dashboard'))
        ->assertForbidden();

    $this->get(route('learner.dashboard'))
        ->assertOk();
});

test('admin retains access to both dashboards', function () {
    $admin = User::factory()->create([
        'role' => 'admin',
        'is_active' => true,
        'email_verified_at' => now(),
    ]);

    $this->actingAs($admin)
        ->get(route('admin.dashboard'))
        ->assertOk();

    $this->get(route('learner.dashboard'))
        ->assertOk();
});
