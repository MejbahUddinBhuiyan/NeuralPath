<?php

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;

uses(RefreshDatabase::class);

test('guests cannot access learner dashboard', function () {
    $this->get('/dashboard')
        ->assertRedirect('/login');
});

test('active verified learners can access dashboard', function () {
    $learner = User::factory()->create([
        'role' => 'learner',
        'is_active' => true,
        'email_verified_at' => now(),
    ]);

    $this->actingAs($learner)
        ->get('/dashboard')
        ->assertOk();
});


test('active verified administrators can access learner dashboard', function () {
    $admin = User::factory()->create([
        'role' => 'admin',
        'is_active' => true,
        'email_verified_at' => now(),
    ]);

    $this->actingAs($admin)
        ->get(route('learner.dashboard'))
        ->assertOk()
        ->assertSee('Switch to Admin View');
});
test('inactive learners cannot access dashboard', function () {
    $learner = User::factory()->create([
        'role' => 'learner',
        'is_active' => false,
        'email_verified_at' => now(),
    ]);

$this->actingAs($learner)
    ->get('/dashboard')
    ->assertRedirect(route('login'));

$this->assertGuest();
});

test('unverified learners cannot access dashboard', function () {
    $learner = User::factory()->create([
        'role' => 'learner',
        'is_active' => true,
        'email_verified_at' => null,
    ]);

$this->actingAs($learner)
    ->get('/dashboard')
    ->assertRedirect(route('login'));

$this->assertGuest();
});
