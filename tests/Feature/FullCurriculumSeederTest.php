
<?php

use App\Models\RoadmapBranch;
use App\Models\RoadmapSection;
use App\Models\RoadmapTopic;
use App\Models\TopicResource;
use Database\Seeders\FullCurriculumSeeder;
use Database\Seeders\PhaseZeroSeeder;
use Database\Seeders\RoadmapBranchSeeder;
use Illuminate\Foundation\Testing\RefreshDatabase;

uses(RefreshDatabase::class);

beforeEach(function () {
    $this->seed(RoadmapBranchSeeder::class);
    $this->seed(PhaseZeroSeeder::class);
    $this->seed(FullCurriculumSeeder::class);
});

test('all nine roadmap phases contain seeded learning content', function () {
    expect(RoadmapBranch::count())->toBe(9);
    expect(RoadmapSection::count())->toBe(29);
    expect(RoadmapTopic::count())->toBe(131);
    expect(TopicResource::count())->toBe(112);
});

test('full curriculum covers all sixty learning weeks', function () {
    $weeks = RoadmapTopic::query()
        ->whereNotNull('target_week')
        ->distinct()
        ->orderBy('target_week')
        ->pluck('target_week')
        ->map(fn ($week) => (int) $week)
        ->all();

    expect($weeks)->toBe(range(1, 60));
});

test('running curriculum seeder twice does not duplicate content', function () {
    $before = [
        RoadmapSection::count(),
        RoadmapTopic::count(),
        TopicResource::count(),
    ];

    $this->seed(FullCurriculumSeeder::class);

    expect([
        RoadmapSection::count(),
        RoadmapTopic::count(),
        TopicResource::count(),
    ])->toBe($before);
});

test('curriculum reseeding preserves administrator changes', function () {
    $section = RoadmapBranch::query()
        ->where('phase_number', 1)
        ->firstOrFail()
        ->sections()
        ->firstOrFail();

    $topic = $section->topics()->firstOrFail();

    $section->update([
        'title' => 'Custom Admin Module Title',
        'is_published' => true,
    ]);

    $topic->update([
        'title' => 'Custom Admin Topic Title',
        'is_published' => true,
    ]);

    $this->seed(FullCurriculumSeeder::class);

    expect($section->fresh()->title)
        ->toBe('Custom Admin Module Title');

    expect($section->fresh()->is_published)
        ->toBeTrue();

    expect($topic->fresh()->title)
        ->toBe('Custom Admin Topic Title');

    expect($topic->fresh()->is_published)
        ->toBeTrue();
});

test('new curriculum content remains unpublished', function () {
    $newSections = RoadmapSection::query()
        ->whereHas('branch', fn ($query) =>
            $query->where('phase_number', '>=', 1)
        );

    $newTopics = RoadmapTopic::query()
        ->whereHas('section.branch', fn ($query) =>
            $query->where('phase_number', '>=', 1)
        );

    expect((clone $newSections)->where('is_published', true)->count())
        ->toBe(0);

    expect((clone $newTopics)->where('is_published', true)->count())
        ->toBe(0);

    expect(TopicResource::query()->where('is_published', true)->count())
        ->toBe(0);
});
