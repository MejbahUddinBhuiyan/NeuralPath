<?php

use App\Models\RoadmapBranch;
use App\Models\User;
use Database\Seeders\RoadmapBranchSeeder;
use Illuminate\Foundation\Testing\RefreshDatabase;

uses(RefreshDatabase::class);

beforeEach(function () {
    $this->seed(RoadmapBranchSeeder::class);
});

function createRoadmapLearner(): User
{
    return User::factory()->create([
        'role' => 'learner',
        'is_active' => true,
        'email_verified_at' => now(),
    ]);
}

test('guest cannot access learner roadmap', function () {
    $this->get(route('learner.roadmap.index'))
        ->assertRedirect(route('login'));
});


test('administrator can access learner roadmap', function () {
    $admin = User::factory()->create([
        'role' => 'admin',
        'is_active' => true,
        'email_verified_at' => now(),
    ]);

    $this->actingAs($admin)
        ->get(route('learner.roadmap.index'))
        ->assertOk()
        ->assertSee('Admin View');
});


test('draft branches are hidden from learners', function () {
    $learner = createRoadmapLearner();

    $this->actingAs($learner)
        ->get(route('learner.roadmap.index'))
        ->assertOk()
        ->assertSee('No published learning phases yet')
        ->assertDontSee('Software Engineering Foundations');
});

test('published branches appear in learner roadmap', function () {
    $learner = createRoadmapLearner();

    $branch = RoadmapBranch::where('phase_number', 0)
        ->firstOrFail();

    $branch->is_published = true;
    $branch->save();

    $this->actingAs($learner)
        ->get(route('learner.roadmap.index'))
        ->assertOk()
        ->assertSee('Software Engineering Foundations')
        ->assertDontSee('Multi-Agent Systems');
});

test('draft branches cannot be opened directly', function () {
    $learner = createRoadmapLearner();

    $branch = RoadmapBranch::where('phase_number', 0)
        ->firstOrFail();

    $this->actingAs($learner)
        ->get(route('learner.roadmap.show', $branch))
        ->assertNotFound();
});

test('published branch detail page is accessible', function () {
    $learner = createRoadmapLearner();

    $branch = RoadmapBranch::where('phase_number', 0)
        ->firstOrFail();

    $branch->is_published = true;
    $branch->save();

    $this->actingAs($learner)
        ->get(route('learner.roadmap.show', $branch))
        ->assertOk()
        ->assertSee('Software Engineering Foundations')
        ->assertSee('Learning Modules');
});

test('draft sections and topics are hidden', function () {
    $learner = createRoadmapLearner();

    $branch = RoadmapBranch::where('phase_number', 0)
        ->firstOrFail();

    $branch->is_published = true;
    $branch->save();

    $publishedSection = $branch->sections()->create([
        'title' => 'Public Python Module',
        'slug' => 'public-python-module',
        'is_published' => true,
    ]);

    $branch->sections()->create([
        'title' => 'Secret Draft Module',
        'slug' => 'secret-draft-module',
        'is_published' => false,
    ]);

    $publishedSection->topics()->create([
        'title' => 'Published Python Topic',
        'slug' => 'published-python-topic',
        'is_published' => true,
    ]);

    $publishedSection->topics()->create([
        'title' => 'Hidden Python Topic',
        'slug' => 'hidden-python-topic',
        'is_published' => false,
    ]);

    $this->actingAs($learner)
        ->get(route('learner.roadmap.show', $branch))
        ->assertOk()
        ->assertSee('Public Python Module')
        ->assertSee('Published Python Topic')
        ->assertDontSee('Secret Draft Module')
        ->assertDontSee('Hidden Python Topic');
});
