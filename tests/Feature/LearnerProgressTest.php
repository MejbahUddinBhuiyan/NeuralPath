
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

    $this->branch = RoadmapBranch::query()
        ->where('phase_number', 0)
        ->firstOrFail();

    $this->section = $this->branch->sections()
        ->where('slug', 'python-engineering')
        ->firstOrFail();

    $this->topic = $this->section->topics()
        ->where('slug', 'python-type-hints')
        ->firstOrFail();

    $this->secondTopic = $this->section->topics()
        ->where('id', '!=', $this->topic->id)
        ->firstOrFail();

    $this->branch->update(['is_published' => true]);
    $this->section->update(['is_published' => true]);
    $this->topic->update(['is_published' => true]);

    $this->learner = User::factory()->create([
        'role' => 'learner',
        'is_active' => true,
        'email_verified_at' => now(),
    ]);
});



test('phase progress starts at zero', function () {
    $this->actingAs($this->learner)
        ->get(route('learner.roadmap.show', $this->branch))
        ->assertOk()
        ->assertSee('data-testid="phase-percentage"', false)
        ->assertSee('aria-label="Phase completion"', false)
        ->assertSee('aria-valuenow="0"', false)
        ->assertSee('style="width: 0%"', false)
        ->assertDontSee('✓ Phase Completed');
});



test('completed published topic produces one hundred percent progress', function () {
    $this->learner->topicProgress()->create([
        'roadmap_topic_id' => $this->topic->id,
        'completed_at' => now(),
    ]);

    $this->actingAs($this->learner)
        ->get(route('learner.roadmap.show', $this->branch))
        ->assertOk()
        ->assertSee('100%')
        ->assertSee('✓ Phase Completed')
        ->assertSee('✓ Module Completed');
});

test('two published topics with one complete produce fifty percent', function () {
    $this->secondTopic->update([
        'is_published' => true,
    ]);

    $this->learner->topicProgress()->create([
        'roadmap_topic_id' => $this->topic->id,
        'completed_at' => now(),
    ]);

    $this->actingAs($this->learner)
        ->get(route('learner.roadmap.show', $this->branch))
        ->assertOk()
        ->assertSee('50%')
        ->assertDontSee('✓ Phase Completed')
        ->assertDontSee('✓ Module Completed');
});

test('unpublished topics are excluded from progress', function () {
    $this->learner->topicProgress()->create([
        'roadmap_topic_id' => $this->topic->id,
        'completed_at' => now(),
    ]);

    // The second topic remains unpublished.
    $this->actingAs($this->learner)
        ->get(route('learner.roadmap.show', $this->branch))
        ->assertOk()
        ->assertSee('100%')
        ->assertSee('✓ Phase Completed');
});

test('learners have independent progress percentages', function () {
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
        ->assertSee('0%')
        ->assertDontSee('✓ Phase Completed');
});

test('phase with no published topics is not marked completed', function () {
    $this->topic->update([
        'is_published' => false,
    ]);

    $this->actingAs($this->learner)
        ->get(route('learner.roadmap.show', $this->branch))
        ->assertOk()
        ->assertSee('0%')
        ->assertDontSee('✓ Phase Completed');
});
