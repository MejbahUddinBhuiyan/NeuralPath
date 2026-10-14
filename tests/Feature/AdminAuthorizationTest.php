
<?php

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;

uses(RefreshDatabase::class);

test('guests cannot access admin routes', function () {
    $this->get('/admin-check')
        ->assertRedirect('/login');
});

test('active verified admins can access admin routes', function () {
    $admin = User::factory()->create([
        'role' => 'admin',
        'is_active' => true,
        'email_verified_at' => now(),
    ]);

    $this->actingAs($admin)
        ->get('/admin-check')
        ->assertOk()
        ->assertSee('NeuralPath Admin Access Granted');
});

test('learners cannot access admin routes', function () {
    $learner = User::factory()->create([
        'role' => 'learner',
        'is_active' => true,
        'email_verified_at' => now(),
    ]);

    $this->actingAs($learner)
        ->get('/admin-check')
        ->assertForbidden();
});

test('inactive admins cannot access admin routes', function () {
    $admin = User::factory()->create([
        'role' => 'admin',
        'is_active' => false,
        'email_verified_at' => now(),
    ]);

    $this->actingAs($admin)
        ->get('/admin-check')
        ->assertForbidden();
});

test('unverified admins cannot access admin routes', function () {
    $admin = User::factory()->create([
        'role' => 'admin',
        'is_active' => true,
        'email_verified_at' => null,
    ]);

    $this->actingAs($admin)
        ->get('/admin-check')
        ->assertForbidden();
});
