<?php

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;

uses(RefreshDatabase::class);

test('public landing page is accessible to guests', function () {
    $this->get('/')
        ->assertOk()
        ->assertSee('NeuralPath')
        ->assertSee('Agentic AI Engineering')
        ->assertSee('60')
        ->assertSee('Learning Weeks')
        ->assertSee('Learning Phases')
        ->assertSee('Planned Topics');
});

test('landing page displays all nine roadmap phases', function () {
    $response = $this->get('/');

    $response->assertOk();

    foreach (range(0, 8) as $phase) {
        $response->assertSee("Phase {$phase}");
    }
});

test('landing page includes access request email', function () {
    $this->get('/')
        ->assertOk()
        ->assertSee('mejbahu475@gmail.com')
        ->assertSee(
            'mailto:mejbahu475@gmail.com?subject=NeuralPath%20Access%20Request',
            false
        )
        ->assertSee('Request Access');
});

test('guests see a sign in link', function () {
    $this->get('/')
        ->assertOk()
        ->assertSee(
            'href="'.route('login').'"',
            false
        )
        ->assertSee('Sign In')
        ->assertDontSee('My Dashboard');
});

test('learner sees their dashboard link', function () {
    $learner = User::factory()->create([
        'role' => 'learner',
        'is_active' => true,
        'email_verified_at' => now(),
    ]);

    $this->actingAs($learner)
        ->get('/')
        ->assertOk()
        ->assertSee(
            'href="'.route('learner.dashboard').'"',
            false
        )
        ->assertSee('My Dashboard');
});

test('administrator sees admin dashboard link', function () {
    $admin = User::factory()->create([
        'role' => 'admin',
        'is_active' => true,
        'email_verified_at' => now(),
    ]);

    $this->actingAs($admin)
        ->get('/')
        ->assertOk()
        ->assertSee(
            'href="'.route('admin.dashboard').'"',
            false
        )
        ->assertSee('My Dashboard');
});

test('public landing page does not expose learner account data', function () {
    User::factory()->create([
        'name' => 'Private Learner Example',
        'email' => 'private-learner@example.com',
        'role' => 'learner',
    ]);

    $this->get('/')
        ->assertOk()
        ->assertDontSee('Private Learner Example')
        ->assertDontSee('private-learner@example.com');
});
