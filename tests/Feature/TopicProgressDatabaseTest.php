
<?php

use App\Models\RoadmapBranch;
use App\Models\TopicProgress;
use App\Models\User;
use Database\Seeders\PhaseZeroSeeder;
use Database\Seeders\RoadmapBranchSeeder;
use Illuminate\Database\QueryException;
use Illuminate\Foundation\Testing\RefreshDatabase;

uses(RefreshDatabase::class);

beforeEach(function () {
    $this->seed(RoadmapBranchSeeder::class);
    $this->seed(PhaseZeroSeeder::class);

    $branch = RoadmapBranch::where('phase_number', 0)
        ->firstOrFail();

    $section = $branch->sections()
        ->where('slug', 'python-engineering')
        ->firstOrFail();

    $this->topic = $section->topics()
        ->where('slug', 'python-type-hints')
        ->firstOrFail();

    $this->learner = User::factory()->create([
        'role' => 'learner',
        'is_active' => true,
        'email_verified_at' => now(),
    ]);
});

test('learner completion can be stored', function () {
    $progress = $this->learner->topicProgress()->create([
        'roadmap_topic_id' => $this->topic->id,
        'completed_at' => now(),
    ]);

    expect($progress->exists)->toBeTrue();
    expect($progress->completed_at)->not->toBeNull();
    expect($progress->user->id)->toBe($this->learner->id);
    expect($progress->topic->id)->toBe($this->topic->id);
});

test('different learners have independent progress', function () {
    $anotherLearner = User::factory()->create([
        'role' => 'learner',
        'is_active' => true,
        'email_verified_at' => now(),
    ]);

    $this->learner->topicProgress()->create([
        'roadmap_topic_id' => $this->topic->id,
        'completed_at' => now(),
    ]);

    expect($this->learner->topicProgress()->count())->toBe(1);
    expect($anotherLearner->topicProgress()->count())->toBe(0);
});

test('a learner cannot have duplicate completion records', function () {
    $this->learner->topicProgress()->create([
        'roadmap_topic_id' => $this->topic->id,
        'completed_at' => now(),
    ]);

    $duplicateWasRejected = false;

    try {
        $this->learner->topicProgress()->create([
            'roadmap_topic_id' => $this->topic->id,
            'completed_at' => now(),
        ]);
    } catch (QueryException $exception) {
        $duplicateWasRejected = true;
    }

    expect($duplicateWasRejected)->toBeTrue();
    expect(TopicProgress::count())->toBe(1);
});

test('deleting a completion record removes that progress', function () {
    $progress = $this->learner->topicProgress()->create([
        'roadmap_topic_id' => $this->topic->id,
        'completed_at' => now(),
    ]);

    $progress->delete();

    expect($this->learner->topicProgress()->count())->toBe(0);
});

test('deleting a topic removes its completion records', function () {
    $this->learner->topicProgress()->create([
        'roadmap_topic_id' => $this->topic->id,
        'completed_at' => now(),
    ]);

    $this->topic->delete();

    expect(TopicProgress::count())->toBe(0);
});
