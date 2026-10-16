
<?php

use App\Models\RecommendedProject;
use App\Models\RoadmapBranch;
use Database\Seeders\RecommendedProjectSeeder;
use Database\Seeders\RoadmapBranchSeeder;
use Illuminate\Foundation\Testing\RefreshDatabase;

uses(RefreshDatabase::class);

beforeEach(function () {
    $this->seed(RoadmapBranchSeeder::class);
    $this->seed(RecommendedProjectSeeder::class);
});

test('all nine phases receive five recommended projects', function () {
    expect(RecommendedProject::count())->toBe(45);

    foreach (RoadmapBranch::all() as $branch) {
        expect($branch->recommendedProjects()->count())->toBe(5);
    }
});

test('new project recommendations start as drafts', function () {
    expect(
        RecommendedProject::query()
            ->where('is_published', true)
            ->count()
    )->toBe(0);
});

test('repeating project seeder creates no duplicates', function () {
    $this->seed(RecommendedProjectSeeder::class);

    expect(RecommendedProject::count())->toBe(45);
});

test('reseeding preserves administrator changes', function () {
    $project = RecommendedProject::firstOrFail();

    $project->update([
        'title' => 'Administrator Custom Project',
        'description' => 'Customized learning project.',
        'is_published' => true,
    ]);

    $this->seed(RecommendedProjectSeeder::class);

    $project->refresh();

    expect($project->title)->toBe('Administrator Custom Project');
    expect($project->description)->toBe('Customized learning project.');
    expect($project->is_published)->toBeTrue();
});

test('every recommended project belongs to a valid phase', function () {
    $projects = RecommendedProject::with('branch')->get();

    foreach ($projects as $project) {
        expect($project->branch)->not->toBeNull();
        expect($project->description)->not->toBeEmpty();
        expect($project->slug)->not->toBeEmpty();
    }
});
