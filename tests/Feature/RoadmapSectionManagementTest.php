
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
});

function roadmapManagementUser(string $role): User
{
    return User::factory()->create([
        'role' => $role,
        'is_active' => true,
        'email_verified_at' => now(),
    ]);
}

test('admin can view sections and topics', function () {
    $admin = roadmapManagementUser('admin');

    $this->actingAs($admin)
        ->get(route('admin.roadmap.sections', $this->branch))
        ->assertOk()
        ->assertSee('Python Engineering')
        ->assertSee('Python Type Hints');
});

test('learner cannot open section management', function () {
    $learner = roadmapManagementUser('learner');

    $this->actingAs($learner)
        ->get(route('admin.roadmap.sections', $this->branch))
        ->assertForbidden();
});

test('admin can publish and unpublish a section', function () {
    $admin = roadmapManagementUser('admin');

    $url = route('admin.roadmap.sections.publication', [
        $this->branch,
        $this->section,
    ]);

    $this->actingAs($admin)
        ->patch($url)
        ->assertRedirect();

    expect($this->section->fresh()->is_published)->toBeTrue();

    $this->patch($url)->assertRedirect();

    expect($this->section->fresh()->is_published)->toBeFalse();
});

test('admin can publish and unpublish a topic', function () {
    $admin = roadmapManagementUser('admin');

    $url = route('admin.roadmap.topics.publication', [
        $this->branch,
        $this->section,
        $this->topic,
    ]);

    $this->actingAs($admin)
        ->patch($url)
        ->assertRedirect();

    expect($this->topic->fresh()->is_published)->toBeTrue();

    $this->patch($url)->assertRedirect();

    expect($this->topic->fresh()->is_published)->toBeFalse();
});

test('learner cannot publish sections or topics', function () {
    $learner = roadmapManagementUser('learner');

    $this->actingAs($learner)
        ->patch(route('admin.roadmap.sections.publication', [
            $this->branch,
            $this->section,
        ]))
        ->assertForbidden();

    $this->patch(route('admin.roadmap.topics.publication', [
        $this->branch,
        $this->section,
        $this->topic,
    ]))
        ->assertForbidden();

    expect($this->section->fresh()->is_published)->toBeFalse();
    expect($this->topic->fresh()->is_published)->toBeFalse();
});

test('guest cannot publish sections or topics', function () {
    $this->patch(route('admin.roadmap.sections.publication', [
        $this->branch,
        $this->section,
    ]))->assertRedirect(route('login'));

    $this->patch(route('admin.roadmap.topics.publication', [
        $this->branch,
        $this->section,
        $this->topic,
    ]))->assertRedirect(route('login'));
});

test('a section cannot be modified through another branch', function () {
    $admin = roadmapManagementUser('admin');

    $otherBranch = RoadmapBranch::where('phase_number', 1)
        ->firstOrFail();

    $this->actingAs($admin)
        ->patch(route('admin.roadmap.sections.publication', [
            $otherBranch,
            $this->section,
        ]))->assertNotFound();

    expect($this->section->fresh()->is_published)->toBeFalse();
});

test('a topic cannot be modified through another section', function () {
    $admin = roadmapManagementUser('admin');

    $otherSection = $this->branch->sections()
        ->where('slug', 'pydantic-and-fastapi')
        ->firstOrFail();

    $this->actingAs($admin)
        ->patch(route('admin.roadmap.topics.publication', [
            $this->branch,
            $otherSection,
            $this->topic,
        ]))->assertNotFound();

    expect($this->topic->fresh()->is_published)->toBeFalse();
});

test('publishing a topic does not automatically publish its section', function () {
    $admin = roadmapManagementUser('admin');

    $this->actingAs($admin)
        ->patch(route('admin.roadmap.topics.publication', [
            $this->branch,
            $this->section,
            $this->topic,
        ]))
        ->assertRedirect();

    expect($this->topic->fresh()->is_published)->toBeTrue();
    expect($this->section->fresh()->is_published)->toBeFalse();
});
