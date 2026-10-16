
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

    $this->branch->update([
        'is_published' => true,
    ]);

    $this->section->update([
        'is_published' => true,
    ]);

    $this->topic->update([
        'is_published' => true,
    ]);

    $this->learner = User::factory()->create([
        'role' => 'learner',
        'is_active' => true,
        'email_verified_at' => now(),
    ]);
});

test('learner can open the dashboard', function () {
    $this->actingAs($this->learner)
        ->get(route('learner.dashboard'))
        ->assertOk()
        ->assertSee('My Learning Dashboard')
        ->assertSee('Overall Progress')
        ->assertSee('Continue Learning')
        ->assertSee('Learning Phases');
});

test('dashboard starts with zero percent progress', function () {
    $this->actingAs($this->learner)
        ->get(route('learner.dashboard'))
        ->assertOk()
        ->assertSee('data-testid="overall-percentage"', false)
        ->assertSee('aria-label="Overall completion"', false)
        ->assertSee('aria-valuenow="0"', false)
        ->assertSee('Python Type Hints');
});

test('dashboard displays completed topic progress', function () {
    $this->learner->topicProgress()->create([
        'roadmap_topic_id' => $this->topic->id,
        'completed_at' => now(),
    ]);

    $this->actingAs($this->learner)
        ->get(route('learner.dashboard'))
        ->assertOk()
        ->assertSee('100%')
        ->assertSee('✓ All Available Topics Completed')
        ->assertSee('✓ Completed');
});

test('dashboard calculates partial progress', function () {
    $this->secondTopic->update([
        'is_published' => true,
    ]);

    $this->learner->topicProgress()->create([
        'roadmap_topic_id' => $this->topic->id,
        'completed_at' => now(),
    ]);

    $this->actingAs($this->learner)
        ->get(route('learner.dashboard'))
        ->assertOk()
        ->assertSee('50%')
        ->assertDontSee('✓ All Available Topics Completed');
});

test('draft topics do not reduce dashboard progress', function () {
    $this->learner->topicProgress()->create([
        'roadmap_topic_id' => $this->topic->id,
        'completed_at' => now(),
    ]);

    // Other seeded topics remain unpublished.
    $this->actingAs($this->learner)
        ->get(route('learner.dashboard'))
        ->assertOk()
        ->assertSee('100%');
});

test('dashboard only shows the authenticated learners progress', function () {
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
        ->get(route('learner.dashboard'))
        ->assertOk()
        ->assertSee('aria-valuenow="0"', false)
        ->assertDontSee('✓ All Available Topics Completed');
});

test('dashboard hides unpublished phases', function () {
    $draftBranch = RoadmapBranch::query()
        ->where('phase_number', 1)
        ->firstOrFail();

    $this->actingAs($this->learner)
        ->get(route('learner.dashboard'))
        ->assertOk()
        ->assertSee($this->branch->title)
        ->assertDontSee($draftBranch->title);
});

test('continue learning links to the correct phase', function () {
    $this->actingAs($this->learner)
        ->get(route('learner.dashboard'))
        ->assertOk()
        ->assertSee(
            'href="'.route('learner.roadmap.show', $this->branch).'"',
            false
        )
        ->assertSee('Continue Learning');
});

test('dashboard handles no published phases', function () {
    $this->branch->update([
        'is_published' => false,
    ]);

    $this->actingAs($this->learner)
        ->get(route('learner.dashboard'))
        ->assertOk()
        ->assertSee('No learning phases have been published yet')
        ->assertSee('0%');
});

test('dashboard handles published phase without published topics', function () {
    $this->topic->update([
        'is_published' => false,
    ]);

    $this->actingAs($this->learner)
        ->get(route('learner.dashboard'))
        ->assertOk()
        ->assertSee('0%')
        ->assertSee('learning topics are still')
        ->assertDontSee('✓ All Available Topics Completed');
});

test('dashboard requires authentication', function () {
    $this->get(route('learner.dashboard'))
        ->assertRedirect(route('login'));
});

test('administrator cannot access learner dashboard', function () {
    $admin = User::factory()->create([
        'role' => 'admin',
        'is_active' => true,
        'email_verified_at' => now(),
    ]);

    $this->actingAs($admin)
        ->get(route('learner.dashboard'))
        ->assertForbidden();
});
