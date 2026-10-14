<?php

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;

uses(RefreshDatabase::class);

test('active learner can continue using dashboard', function () {
    $learner = User::factory()->create([
        'role' => 'learner',
        'is_active' => true,
        'email_verified_at' => now(),
    ]);

    $this->actingAs($learner)
        ->get('/dashboard')
        ->assertOk();

    $this->assertAuthenticatedAs($learner);
});

test('suspended learner is logged out on next request', function () {
    $learner = User::factory()->create([
        'role' => 'learner',
        'is_active' => true,
        'email_verified_at' => now(),
    ]);

    $this->actingAs($learner);

    $learner->forceFill([
        'is_active' => false,
    ])->save();

    $this->get('/dashboard')
        ->assertRedirect(route('login'));

    $this->assertGuest();
});

test('suspended admin is logged out on next request', function () {
    $admin = User::factory()->create([
        'role' => 'admin',
        'is_active' => true,
        'email_verified_at' => now(),
    ]);

    $this->actingAs($admin);

    $admin->forceFill([
        'is_active' => false,
    ])->save();

    $this->get('/admin/dashboard')
        ->assertRedirect(route('login'));

    $this->assertGuest();
});

test('unverified user is logged out on next request', function () {
    $learner = User::factory()->create([
        'role' => 'learner',
        'is_active' => true,
        'email_verified_at' => now(),
    ]);

    $this->actingAs($learner);

    $learner->forceFill([
        'email_verified_at' => null,
    ])->save();

    $this->get('/dashboard')
        ->assertRedirect(route('login'));

    $this->assertGuest();
});

test('guest can still open login page', function () {
    $this->get('/login')
        ->assertOk();
});
