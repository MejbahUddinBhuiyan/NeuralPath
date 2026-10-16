
<?php

use App\Models\RoadmapBranch;
use App\Models\TopicProgress;
use App\Models\User;
use Database\Seeders\PhaseZeroSeeder;
use Database\Seeders\RoadmapBranchSeeder;
use Illuminate\Foundation\Testing\RefreshDatabase;

uses(RefreshDatabase::class);

beforeEach(function () {
    $this->seed(RoadmapBranchSeeder::class);
    $this->seed(PhaseZeroSeeder::class);

    $this->branch = RoadmapBranch::where('phase_number', 0)
        ->firstOrFail();

    $this->section = $this->branch->sections()
        ->where('slug', 'python-engineering')
        ->firstOrFail();

    $this->topic = $this->section->topics()
        ->where('slug', 'python-type-hints')
        ->firstOrFail();

    // Publish the complete parent chain.
    $this->branch->update([
        'is_published' => true,
    ]);

    $this->section->update([
        'is_published' => true,
    ]);

    $this->topic->update([
        'is_published' => true,
    ]);

    // Create an active, verified learner.
    $this->learner = User::factory()->create([
        'role' => 'learner',
        'is_active' => true,
        'email_verified_at' => now(),
    ]);
});

test('learner can mark a published topic complete', function () {
    $url = route('learner.topics.complete', $this->topic);

    $this->actingAs($this->learner)
        ->put($url)
        ->assertRedirect(
            route('learner.roadmap.show', $this->branch)
        );

    $this->assertDatabaseHas('topic_progress', [
        'user_id' => $this->learner->id,
        'roadmap_topic_id' => $this->topic->id,
    ]);

    expect(TopicProgress::firstOrFail()->completed_at)
        ->not->toBeNull();
});

test('learner can mark a completed topic incomplete', function () {
    $this->learner->topicProgress()->create([
        'roadmap_topic_id' => $this->topic->id,
        'completed_at' => now(),
    ]);

    $this->actingAs($this->learner)
        ->delete(
            route('learner.topics.incomplete', $this->topic)
        )
        ->assertRedirect(
            route('learner.roadmap.show', $this->branch)
        );

    $this->assertDatabaseCount('topic_progress', 0);
});

test('marking the same topic complete twice creates one record', function () {
    $url = route('learner.topics.complete', $this->topic);

    $this->actingAs($this->learner)
        ->put($url)
        ->assertRedirect();

    $this->put($url)
        ->assertRedirect();

    $this->assertDatabaseCount('topic_progress', 1);

    $this->assertDatabaseHas('topic_progress', [
        'user_id' => $this->learner->id,
        'roadmap_topic_id' => $this->topic->id,
    ]);
});

test('one learner cannot erase another learners progress', function () {
    $anotherLearner = User::factory()->create([
        'role' => 'learner',
        'is_active' => true,
        'email_verified_at' => now(),
    ]);

    $anotherLearner->topicProgress()->create([
        'roadmap_topic_id' => $this->topic->id,
        'completed_at' => now(),
    ]);

    $this->actingAs($this->learner)
        ->delete(
            route('learner.topics.incomplete', $this->topic)
        )
        ->assertRedirect();

    $this->assertDatabaseHas('topic_progress', [
        'user_id' => $anotherLearner->id,
        'roadmap_topic_id' => $this->topic->id,
    ]);

    $this->assertDatabaseCount('topic_progress', 1);
});

test('draft topic cannot be marked complete', function () {
    $this->topic->update([
        'is_published' => false,
    ]);

    $this->actingAs($this->learner)
        ->put(route('learner.topics.complete', $this->topic))
        ->assertNotFound();

    $this->assertDatabaseCount('topic_progress', 0);
});

test('topic in unpublished section cannot be completed', function () {
    $this->section->update([
        'is_published' => false,
    ]);

    $this->actingAs($this->learner)
        ->put(route('learner.topics.complete', $this->topic))
        ->assertNotFound();

    $this->assertDatabaseCount('topic_progress', 0);
});

test('topic in unpublished phase cannot be completed', function () {
    $this->branch->update([
        'is_published' => false,
    ]);

    $this->actingAs($this->learner)
        ->put(route('learner.topics.complete', $this->topic))
        ->assertNotFound();

    $this->assertDatabaseCount('topic_progress', 0);
});

test('administrator cannot change learner completion', function () {
    $admin = User::factory()->create([
        'role' => 'admin',
        'is_active' => true,
        'email_verified_at' => now(),
    ]);

    $this->actingAs($admin)
        ->put(route('learner.topics.complete', $this->topic))
        ->assertForbidden();

    $this->assertDatabaseCount('topic_progress', 0);
});

test('guest cannot change topic completion', function () {
    $this->put(route('learner.topics.complete', $this->topic))
        ->assertRedirect(route('login'));

    $this->assertDatabaseCount('topic_progress', 0);
});

test('inactive learner cannot change topic completion', function () {
    // is_active is protected from mass assignment.
    // forceFill is appropriate for trusted test setup.
    $this->learner->forceFill([
        'is_active' => false,
    ])->save();

    // Confirm that the account is actually inactive.
    expect($this->learner->fresh()->isActive())
        ->toBeFalse();

    // A suspended learner must be redirected to login.
    $this->actingAs($this->learner)
        ->put(route('learner.topics.complete', $this->topic))
        ->assertRedirect(route('login'));

    // No completion record should be created.
    $this->assertDatabaseCount('topic_progress', 0);
});

test('learner sees mark complete control for an unfinished topic', function () {
    $this->actingAs($this->learner)
        ->get(route('learner.roadmap.show', $this->branch))
        ->assertOk()
        ->assertSee('Python Type Hints')
        ->assertSee('Mark Python Type Hints as complete')
        ->assertDontSee('Mark Python Type Hints as incomplete');
});

test('learner sees completed state after marking a topic complete', function () {
    $this->actingAs($this->learner)
        ->put(route('learner.topics.complete', $this->topic))
        ->assertRedirect(
            route('learner.roadmap.show', $this->branch)
        );

    // A separate GET simulates refreshing the page.
    $this->get(route('learner.roadmap.show', $this->branch))
        ->assertOk()
        ->assertSee('Mark Python Type Hints as incomplete')
        ->assertSee('✓ Completed')
        ->assertDontSee('Mark Python Type Hints as complete');
});

test('learner sees unfinished state after undoing completion', function () {
    $this->learner->topicProgress()->create([
        'roadmap_topic_id' => $this->topic->id,
        'completed_at' => now(),
    ]);

    $this->actingAs($this->learner)
        ->delete(route('learner.topics.incomplete', $this->topic))
        ->assertRedirect(
            route('learner.roadmap.show', $this->branch)
        );

    $this->get(route('learner.roadmap.show', $this->branch))
        ->assertOk()
        ->assertSee('Mark Python Type Hints as complete')
        ->assertDontSee('Mark Python Type Hints as incomplete');
});

test('one learners completed state is not shown to another learner', function () {
    $this->learner->topicProgress()->create([
        'roadmap_topic_id' => $this->topic->id,
        'completed_at' => now(),
    ]);

    $anotherLearner = User::factory()->create([
        'role' => 'learner',
        'is_active' => true,
        'email_verified_at' => now(),
    ]);

    $this->actingAs($anotherLearner)
        ->get(route('learner.roadmap.show', $this->branch))
        ->assertOk()
        ->assertSee('Mark Python Type Hints as complete')
        ->assertDontSee('Mark Python Type Hints as incomplete');
});
