
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

test('admin can access both dashboards', function () {
    $this->actingAs($this->admin)
        ->get(route('admin.dashboard'))
        ->assertOk()
        ->assertSee('Switch to Learner View');

    $this->get(route('learner.dashboard'))
        ->assertOk()
        ->assertSee('Switch to Admin View');
});

test('switching views does not change admin role', function () {
    $this->actingAs($this->admin)
        ->get(route('learner.dashboard'))
        ->assertOk();

    $this->get(route('admin.dashboard'))
        ->assertOk();

    expect($this->admin->fresh()->role)
        ->toBe('admin');

    expect(auth()->id())
        ->toBe($this->admin->id);
});

test('admin can open published roadmap and see completion controls', function () {
    $this->actingAs($this->admin)
        ->get(route('learner.roadmap.show', $this->branch))
        ->assertOk()
        ->assertSee('Python Type Hints')
        ->assertSee('Mark Python Type Hints as complete');
});

test('admin completion does not affect another learners progress', function () {
    $this->actingAs($this->admin)
        ->put(route('learner.topics.complete', $this->topic))
        ->assertRedirect(
            route('learner.roadmap.show', $this->branch)
        );

    $this->assertDatabaseHas('topic_progress', [
        'user_id' => $this->admin->id,
        'roadmap_topic_id' => $this->topic->id,
    ]);

    $this->assertDatabaseMissing('topic_progress', [
        'user_id' => $this->learner->id,
        'roadmap_topic_id' => $this->topic->id,
    ]);

    $this->actingAs($this->learner)
        ->get(route('learner.dashboard'))
        ->assertOk()
        ->assertSee('aria-valuenow="0"', false);
});

test('admin can undo only their own completion', function () {
    $this->admin->topicProgress()->create([
        'roadmap_topic_id' => $this->topic->id,
        'completed_at' => now(),
    ]);

    $this->learner->topicProgress()->create([
        'roadmap_topic_id' => $this->topic->id,
        'completed_at' => now(),
    ]);

    $this->actingAs($this->admin)
        ->delete(route('learner.topics.incomplete', $this->topic))
        ->assertRedirect();

    $this->assertDatabaseMissing('topic_progress', [
        'user_id' => $this->admin->id,
        'roadmap_topic_id' => $this->topic->id,
    ]);

    $this->assertDatabaseHas('topic_progress', [
        'user_id' => $this->learner->id,
        'roadmap_topic_id' => $this->topic->id,
    ]);
});

test('learner cannot access admin dashboard or switch link', function () {
    $this->actingAs($this->learner)
        ->get(route('learner.dashboard'))
        ->assertOk()
        ->assertDontSee('Switch to Admin View');

    $this->get(route('admin.dashboard'))
        ->assertForbidden();
});

test('inactive admin cannot access learner dashboard', function () {
    $this->admin->forceFill([
        'is_active' => false,
    ])->save();

    $this->actingAs($this->admin->fresh())
        ->get(route('learner.dashboard'))
        ->assertRedirect(route('login'));
});

test('unverified admin cannot access learner dashboard', function () {
    $this->admin->forceFill([
        'email_verified_at' => null,
    ])->save();

    $this->actingAs($this->admin->fresh())
        ->get(route('learner.dashboard'))
        ->assertRedirect(route('login'));
});

test('admin cannot complete unpublished topics', function () {
    $this->topic->update([
        'is_published' => false,
    ]);

    $this->actingAs($this->admin)
        ->put(route('learner.topics.complete', $this->topic))
        ->assertNotFound();

    $this->assertDatabaseCount('topic_progress', 0);
});
