
<?php

use App\Models\RoadmapBranch;
use App\Models\RoadmapSection;
use App\Models\RoadmapTopic;
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

    $this->admin = User::factory()->create([
        'role' => 'admin',
        'is_active' => true,
        'email_verified_at' => now(),
    ]);
});

test('admin can open the curriculum creation forms', function () {
    $this->actingAs($this->admin)
        ->get(route('admin.roadmap.sections.create', $this->branch))
        ->assertOk()
        ->assertSee('Create Sub-branch');

    $this->get(route('admin.roadmap.topics.create', [
        $this->branch,
        $this->section,
    ]))
        ->assertOk()
        ->assertSee('Create Learning Topic');
});

test('admin can create a draft sub-branch', function () {
    $this->actingAs($this->admin)
        ->post(route('admin.roadmap.sections.store', $this->branch), [
            'title' => 'Advanced Python Tools',
            'description' => 'Additional Python tooling.',
            'sort_order' => 6,
        ])
        ->assertRedirect(route('admin.roadmap.sections', $this->branch));

    $section = RoadmapSection::where(
        'title',
        'Advanced Python Tools'
    )->firstOrFail();

    expect($section->roadmap_branch_id)->toBe($this->branch->id);
    expect($section->is_published)->toBeFalse();
});

test('admin can edit a section without changing its slug', function () {
    $originalSlug = $this->section->slug;

    $this->actingAs($this->admin)
        ->put(route('admin.roadmap.sections.update', [
            $this->branch,
            $this->section,
        ]), [
            'title' => 'Professional Python Engineering',
            'description' => 'Updated curriculum.',
            'sort_order' => 1,
        ])
        ->assertRedirect(route('admin.roadmap.sections', $this->branch));

    expect($this->section->fresh()->title)
        ->toBe('Professional Python Engineering');

    expect($this->section->fresh()->slug)
        ->toBe($originalSlug);
});

test('admin can create a draft learning topic', function () {
    $this->actingAs($this->admin)
        ->post(route('admin.roadmap.topics.store', [
            $this->branch,
            $this->section,
        ]), [
            'title' => 'Python Context Managers',
            'description' => 'Working with context managers.',
            'target_week' => 2,
            'estimated_minutes' => 90,
            'sort_order' => 5,
        ])
        ->assertRedirect(route('admin.roadmap.sections', $this->branch));

    $topic = RoadmapTopic::where(
        'title',
        'Python Context Managers'
    )->firstOrFail();

    expect($topic->roadmap_section_id)->toBe($this->section->id);
    expect($topic->is_published)->toBeFalse();
});

test('admin can edit a topic and retain its slug', function () {
    $slug = $this->topic->slug;

    $this->actingAs($this->admin)
        ->put(route('admin.roadmap.topics.update', [
            $this->branch,
            $this->section,
            $this->topic,
        ]), [
            'title' => 'Advanced Python Type Hints',
            'description' => 'Typed Python functions.',
            'target_week' => 2,
            'estimated_minutes' => 150,
            'sort_order' => 1,
        ])
        ->assertRedirect(route('admin.roadmap.sections', $this->branch));

    expect($this->topic->fresh()->title)
        ->toBe('Advanced Python Type Hints');

    expect($this->topic->fresh()->slug)->toBe($slug);
    expect($this->topic->fresh()->target_week)->toBe(2);
});

test('topic week must belong to its roadmap phase', function () {
    $this->actingAs($this->admin)
        ->post(route('admin.roadmap.topics.store', [
            $this->branch,
            $this->section,
        ]), [
            'title' => 'Invalid Week Topic',
            'target_week' => 40,
            'estimated_minutes' => 90,
            'sort_order' => 5,
        ])
        ->assertSessionHasErrors('target_week');

    $this->assertDatabaseMissing('roadmap_topics', [
        'title' => 'Invalid Week Topic',
    ]);
});

test('duplicate topic titles in one section are rejected', function () {
    $this->actingAs($this->admin)
        ->post(route('admin.roadmap.topics.store', [
            $this->branch,
            $this->section,
        ]), [
            'title' => 'Python Type Hints',
            'target_week' => 1,
            'sort_order' => 5,
        ])
        ->assertSessionHasErrors('title');
});

test('learners cannot create or edit roadmap content', function () {
    $learner = User::factory()->create([
        'role' => 'learner',
        'is_active' => true,
        'email_verified_at' => now(),
    ]);

    $this->actingAs($learner)
        ->post(route('admin.roadmap.sections.store', $this->branch), [
            'title' => 'Unauthorized Module',
            'sort_order' => 1,
        ])
        ->assertForbidden();

    $this->put(route('admin.roadmap.topics.update', [
        $this->branch,
        $this->section,
        $this->topic,
    ]), [
        'title' => 'Unauthorized Topic',
        'sort_order' => 1,
    ])
        ->assertForbidden();
});

test('topics cannot be edited through an unrelated section', function () {
    $otherSection = $this->branch->sections()
        ->where('slug', 'pydantic-and-fastapi')
        ->firstOrFail();

    $this->actingAs($this->admin)
        ->put(route('admin.roadmap.topics.update', [
            $this->branch,
            $otherSection,
            $this->topic,
        ]), [
            'title' => 'Invalid Update',
            'sort_order' => 1,
        ])
        ->assertNotFound();

    expect($this->topic->fresh()->title)->toBe('Python Type Hints');
});

test('reseeding does not overwrite administrator edits', function () {
    $this->section->title = 'Custom Python Curriculum';
    $this->section->save();

    $this->topic->estimated_minutes = 240;
    $this->topic->save();

    $this->seed(PhaseZeroSeeder::class);

    expect($this->section->fresh()->title)
        ->toBe('Custom Python Curriculum');

    expect($this->topic->fresh()->estimated_minutes)
        ->toBe(240);
});
