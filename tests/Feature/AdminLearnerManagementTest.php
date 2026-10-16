<?php

use App\Models\RoadmapBranch;
use App\Models\User;
use Database\Seeders\PhaseZeroSeeder;
use Database\Seeders\RoadmapBranchSeeder;
use Illuminate\Foundation\Testing\RefreshDatabase;

uses(RefreshDatabase::class);

beforeEach(function () {
    $this->seed(RoadmapBranchSeeder::class);
    $this->seed(PhaseZeroSeeder::class);

    $this->admin = User::factory()->create([
        'role' => 'admin',
        'is_active' => true,
        'email_verified_at' => now(),
    ]);

    $this->learner = User::factory()->create([
        'role' => 'learner',
        'is_active' => true,
        'email_verified_at' => now(),
    ]);

    $this->branch = RoadmapBranch::query()
        ->where('phase_number', 0)
        ->firstOrFail();

    $this->section = $this->branch->sections()
        ->where('slug', 'python-engineering')
        ->firstOrFail();

    $this->topic = $this->section->topics()
        ->where('slug', 'python-type-hints')
        ->firstOrFail();

    $this->branch->update(['is_published' => true]);
    $this->section->update(['is_published' => true]);
    $this->topic->update(['is_published' => true]);
});

test('admin can view management dashboard statistics', function () {
    $this->actingAs($this->admin)
        ->get(route('admin.dashboard'))
        ->assertOk()
        ->assertSee('Total Learners')
        ->assertSee('Active Learners')
        ->assertSee('Published Topics')
        ->assertSee('Recorded Topic Completions');
});

test('admin can view learner list', function () {
    $this->actingAs($this->admin)
        ->get(route('admin.learners.index'))
        ->assertOk()
        ->assertSee($this->learner->email)
        ->assertDontSee($this->admin->email);
});

test('admin can search learners by email', function () {
    $other = User::factory()->create([
        'name' => 'Unrelated Learner',
        'email' => 'different@example.com',
        'role' => 'learner',
        'is_active' => true,
        'email_verified_at' => now(),
    ]);

    $this->actingAs($this->admin)
        ->get(route('admin.learners.index', [
            'search' => $this->learner->email,
        ]))
        ->assertOk()
        ->assertSee($this->learner->email)
        ->assertDontSee($other->email);
});

test('admin can filter suspended learners', function () {
    $suspended = User::factory()->create([
        'name' => 'Suspended Example',
        'role' => 'learner',
        'is_active' => false,
        'email_verified_at' => now(),
    ]);

    $this->actingAs($this->admin)
        ->get(route('admin.learners.index', [
            'status' => 'suspended',
        ]))
        ->assertOk()
        ->assertSee('Suspended Example')
        ->assertDontSee($this->learner->email);
});

test('admin can view individual learner progress', function () {
    $this->learner->topicProgress()->create([
        'roadmap_topic_id' => $this->topic->id,
        'completed_at' => now(),
    ]);

    $this->actingAs($this->admin)
        ->get(route('admin.learners.show', $this->learner))
        ->assertOk()
        ->assertSee($this->learner->email)
        ->assertSee('100%')
        ->assertSee('Learning Phase Progress');
});

test('admin can suspend a learner', function () {
    $this->actingAs($this->admin)
        ->patch(route('admin.learners.status', $this->learner), [
            'is_active' => 0,
        ])
        ->assertRedirect(
            route('admin.learners.show', $this->learner)
        );

    expect($this->learner->fresh()->isActive())->toBeFalse();
});

test('admin can reactivate a suspended learner', function () {
    $this->learner->forceFill([
        'is_active' => false,
    ])->save();

    $this->actingAs($this->admin)
        ->patch(route('admin.learners.status', $this->learner), [
            'is_active' => 1,
        ])
        ->assertRedirect(
            route('admin.learners.show', $this->learner)
        );

    expect($this->learner->fresh()->isActive())->toBeTrue();
});

test('admin cannot change another administrators status', function () {
    $anotherAdmin = User::factory()->create([
        'role' => 'admin',
        'is_active' => true,
        'email_verified_at' => now(),
    ]);

    $this->actingAs($this->admin)
        ->patch(route('admin.learners.status', $anotherAdmin), [
            'is_active' => 0,
        ])
        ->assertNotFound();

    expect($anotherAdmin->fresh()->isActive())->toBeTrue();
});

test('admin cannot view another administrator as a learner', function () {
    $this->actingAs($this->admin)
        ->get(route('admin.learners.show', $this->admin))
        ->assertNotFound();
});

test('learner cannot access admin learner management', function () {
    $this->actingAs($this->learner)
        ->get(route('admin.learners.index'))
        ->assertForbidden();

    $this->get(route('admin.learners.show', $this->learner))
        ->assertForbidden();

    $this->patch(route('admin.learners.status', $this->learner), [
        'is_active' => 0,
    ])->assertForbidden();

    expect($this->learner->fresh()->isActive())->toBeTrue();
});

test('guests cannot access learner management', function () {
    $this->get(route('admin.learners.index'))
        ->assertRedirect(route('login'));

    $this->get(route('admin.learners.show', $this->learner))
        ->assertRedirect(route('login'));
});

test('invalid account status is rejected', function () {
    $this->actingAs($this->admin)
        ->patch(route('admin.learners.status', $this->learner), [
            'is_active' => 'invalid',
        ])
        ->assertSessionHasErrors('is_active');

    expect($this->learner->fresh()->isActive())->toBeTrue();
});

test('learner progress counts exclude unpublished topics', function () {
    $this->learner->topicProgress()->create([
        'roadmap_topic_id' => $this->topic->id,
        'completed_at' => now(),
    ]);

    $this->actingAs($this->admin)
        ->get(route('admin.learners.show', $this->learner))
        ->assertOk()
        ->assertSee('100%');

    $this->topic->update(['is_published' => false]);

    $this->get(route('admin.learners.show', $this->learner))
        ->assertOk()
        ->assertSee('aria-valuenow="0"', false);
});


test('suspended learner is logged out on the next request', function () {
    // Admin suspends the learner.
    $this->actingAs($this->admin)
        ->patch(route('admin.learners.status', $this->learner), [
            'is_active' => 0,
        ])
        ->assertRedirect(
            route('admin.learners.show', $this->learner)
        );

    // Verify that the new status is saved in the database.
    expect($this->learner->fresh()->isActive())
        ->toBeFalse();

    // Reload the learner to avoid using stale model attributes.
    $suspendedLearner = $this->learner->fresh();

    // The suspended account must not access learner routes.
    $this->actingAs($suspendedLearner)
        ->get(route('learner.dashboard'))
        ->assertRedirect(route('login'));
});
