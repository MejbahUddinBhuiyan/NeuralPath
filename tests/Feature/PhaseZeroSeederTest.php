
<?php

use App\Models\RoadmapBranch;
use App\Models\RoadmapSection;
use App\Models\RoadmapTopic;
use Database\Seeders\PhaseZeroSeeder;
use Database\Seeders\RoadmapBranchSeeder;
use Illuminate\Foundation\Testing\RefreshDatabase;

uses(RefreshDatabase::class);

beforeEach(function () {
    $this->seed(RoadmapBranchSeeder::class);
});

test('phase zero seeder creates five sections and nineteen topics', function () {
    $this->seed(PhaseZeroSeeder::class);

    $branch = RoadmapBranch::where('phase_number', 0)
        ->firstOrFail();

    expect($branch->sections()->count())->toBe(5);

    expect(
        RoadmapTopic::whereIn(
            'roadmap_section_id',
            $branch->sections()->pluck('id')
        )->count()
    )->toBe(19);
});

test('phase zero sections follow the correct learning order', function () {
    $this->seed(PhaseZeroSeeder::class);

    $branch = RoadmapBranch::where('phase_number', 0)
        ->firstOrFail();

    $titles = $branch->sections()
        ->pluck('title')
        ->all();

    expect($titles)->toBe([
        'Python Engineering',
        'Pydantic and FastAPI',
        'Databases and Caching',
        'Containers and Testing',
        'Git and CI/CD',
    ]);
});

test('reseed does not create duplicate topics', function () {
    $this->seed(PhaseZeroSeeder::class);
    $this->seed(PhaseZeroSeeder::class);

    expect(RoadmapSection::count())->toBe(5);
    expect(RoadmapTopic::count())->toBe(19);
});

test('reseed preserves publication settings', function () {
    $this->seed(PhaseZeroSeeder::class);

    $section = RoadmapSection::where(
        'slug',
        'python-engineering'
    )->firstOrFail();

    $topic = $section->topics()
        ->where('slug', 'python-type-hints')
        ->firstOrFail();

    $section->is_published = true;
    $section->save();

    $topic->is_published = true;
    $topic->save();

    $this->seed(PhaseZeroSeeder::class);

    expect($section->fresh()->is_published)->toBeTrue();
    expect($topic->fresh()->is_published)->toBeTrue();
});

test('all phase zero topics have week targets within phase zero', function () {
    $this->seed(PhaseZeroSeeder::class);

    $branch = RoadmapBranch::where('phase_number', 0)
        ->firstOrFail();

    $topics = RoadmapTopic::whereIn(
        'roadmap_section_id',
        $branch->sections()->pluck('id')
    )->get();

    foreach ($topics as $topic) {
        expect($topic->target_week)
            ->toBeGreaterThanOrEqual(1)
            ->toBeLessThanOrEqual(4);
    }

    expect($topics)->toHaveCount(19);
});
