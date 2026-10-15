<?php

use App\Models\RoadmapBranch;
use App\Models\RoadmapSection;
use App\Models\RoadmapTopic;
use Illuminate\Foundation\Testing\RefreshDatabase;

uses(RefreshDatabase::class);

test('a branch can contain multiple sections', function () {
    $branch = RoadmapBranch::create([
        'title' => 'Software Engineering Foundations',
        'slug' => 'software-engineering-foundations',
        'phase_number' => 0,
        'start_week' => 1,
        'end_week' => 4,
        'sort_order' => 0,
        'is_published' => true,
    ]);

    $branch->sections()->create([
        'title' => 'Python Engineering',
        'slug' => 'python-engineering',
        'sort_order' => 1,
    ]);

    $branch->sections()->create([
        'title' => 'FastAPI and APIs',
        'slug' => 'fastapi-and-apis',
        'sort_order' => 2,
    ]);

    expect($branch->sections()->count())->toBe(2);
    expect($branch->sections->first()->title)
        ->toBe('Python Engineering');
});

test('a section can contain learning topics', function () {
    $branch = RoadmapBranch::create([
        'title' => 'Software Engineering Foundations',
        'slug' => 'software-engineering-foundations',
        'phase_number' => 0,
        'start_week' => 1,
        'end_week' => 4,
    ]);

    $section = $branch->sections()->create([
        'title' => 'Python Engineering',
        'slug' => 'python-engineering',
    ]);

    $section->topics()->create([
        'title' => 'Python Async and Await',
        'slug' => 'python-async-await',
        'target_week' => 1,
        'estimated_minutes' => 120,
    ]);

    $topic = RoadmapTopic::firstOrFail();

    expect($topic->section->id)->toBe($section->id);
    expect($section->branch->id)->toBe($branch->id);
    expect($section->topics()->count())->toBe(1);
});

test('new roadmap content is unpublished by default', function () {
    $branch = RoadmapBranch::create([
        'title' => 'Software Engineering Foundations',
        'slug' => 'software-engineering-foundations',
        'phase_number' => 0,
        'start_week' => 1,
        'end_week' => 4,
    ]);

    $section = $branch->sections()->create([
        'title' => 'Python Engineering',
        'slug' => 'python-engineering',
    ]);

    $topic = $section->topics()->create([
        'title' => 'Type Hints',
        'slug' => 'type-hints',
    ]);

    expect($branch->fresh()->is_published)->toBeFalse();
    expect($section->fresh()->is_published)->toBeFalse();
    expect($topic->fresh()->is_published)->toBeFalse();
});

test('deleting a branch removes its child sections and topics', function () {
    $branch = RoadmapBranch::create([
        'title' => 'Software Engineering Foundations',
        'slug' => 'software-engineering-foundations',
        'phase_number' => 0,
        'start_week' => 1,
        'end_week' => 4,
    ]);

    $section = $branch->sections()->create([
        'title' => 'Python Engineering',
        'slug' => 'python-engineering',
    ]);

    $section->topics()->create([
        'title' => 'Type Hints',
        'slug' => 'type-hints',
    ]);

    $branch->delete();

    $this->assertDatabaseCount('roadmap_branches', 0);
    $this->assertDatabaseCount('roadmap_sections', 0);
    $this->assertDatabaseCount('roadmap_topics', 0);
});
