<?php

use App\Models\Invitation;
use App\Models\User;
use App\Services\InvitationService;
use Illuminate\Foundation\Testing\RefreshDatabase;

uses(RefreshDatabase::class);

test('verified admin can create an invitation', function () {
    $admin = User::factory()->create([
        'role' => 'admin',
        'is_active' => true,
        'email_verified_at' => now(),
    ]);

    $result = app(InvitationService::class)
        ->create('learner@example.com', $admin);

    expect($result['invitation'])->toBeInstanceOf(Invitation::class);

    expect($result['invitation']->email)
        ->toBe('learner@example.com');

    expect($result['invitation']->token_hash)
        ->not->toBe($result['token']);

    expect(
        app(InvitationService::class)->findValid($result['token'])
    )->not->toBeNull();
});

test('learners cannot generate invitations', function () {
    $learner = User::factory()->create([
        'role' => 'learner',
        'is_active' => true,
    ]);

    app(InvitationService::class)
        ->create('new@example.com', $learner);
})->throws(
    \Illuminate\Auth\Access\AuthorizationException::class
);

test('expired invitation tokens are rejected', function () {
    $admin = User::factory()->create([
        'role' => 'admin',
        'is_active' => true,
        'email_verified_at' => now(),
    ]);

    $result = app(InvitationService::class)
        ->create('learner@example.com', $admin);

    $result['invitation']->update([
        'expires_at' => now()->subMinute(),
    ]);

    expect(
        app(InvitationService::class)->findValid($result['token'])
    )->toBeNull();
});
