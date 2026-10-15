<?php

use App\Models\RoadmapBranch;
use Database\Seeders\RoadmapBranchSeeder;
use Illuminate\Foundation\Testing\RefreshDatabase;

uses(RefreshDatabase::class);

test('the seeder creates all nine roadmap phases', function () {
    $this->seed(RoadmapBranchSeeder::class);

    expect(RoadmapBranch::count())->toBe(9);

    $phases = RoadmapBranch::orderBy('phase_number')
        ->pluck('phase_number')
        ->all();

    expect($phases)->toBe(range(0, 8));
});

test('the roadmap covers the complete 60-week plan', function () {
    $this->seed(RoadmapBranchSeeder::class);

    $branches = RoadmapBranch::orderBy('phase_number')->get();

    expect($branches->first()->start_week)->toBe(1);
    expect($branches->last()->end_week)->toBe(60);

    $expectedStart = 1;

    foreach ($branches as $branch) {
        expect($branch->start_week)->toBe($expectedStart);
        expect($branch->end_week)
            ->toBeGreaterThanOrEqual($branch->start_week);

        $expectedStart = $branch->end_week + 1;
    }

    expect($expectedStart)->toBe(61);
});

test('running the seeder twice does not duplicate branches', function () {
    $this->seed(RoadmapBranchSeeder::class);
    $this->seed(RoadmapBranchSeeder::class);

    expect(RoadmapBranch::count())->toBe(9);
});

test('reseeding preserves publication settings', function () {
    $this->seed(RoadmapBranchSeeder::class);

    $branch = RoadmapBranch::where('phase_number', 0)
        ->firstOrFail();

    $branch->is_published = true;
    $branch->save();

    $this->seed(RoadmapBranchSeeder::class);

    expect($branch->fresh()->is_published)->toBeTrue();
    expect(RoadmapBranch::count())->toBe(9);
});
