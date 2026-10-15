<?php

use App\Models\RoadmapBranch;
use App\Models\User;
use Database\Seeders\RoadmapBranchSeeder;
use Illuminate\Foundation\Testing\RefreshDatabase;

uses(RefreshDatabase::class);

beforeEach(function () {
    $this->seed(RoadmapBranchSeeder::class);
});

function makeRoadmapUser(string $role): User
{
    return User::factory()->create([
        'role' => $role,
        'is_active' => true,
        'email_verified_at' => now(),
    ]);
}

test('admin can view the roadmap management page', function () {
    $admin = makeRoadmapUser('admin');

    $this->actingAs($admin)
        ->get(route('admin.roadmap.index'))
        ->assertOk()
        ->assertSee('Software Engineering Foundations')
        ->assertSee('Specialization and Flagship Project');
});

test('learner cannot view roadmap management', function () {
    $learner = makeRoadmapUser('learner');

    $this->actingAs($learner)
        ->get(route('admin.roadmap.index'))
        ->assertForbidden();
});

test('admin can publish and unpublish a roadmap branch', function () {
    $admin = makeRoadmapUser('admin');

    $branch = RoadmapBranch::where('phase_number', 0)
        ->firstOrFail();

    $this->actingAs($admin)
        ->patch(route('admin.roadmap.publication', $branch))
        ->assertRedirect(route('admin.roadmap.index'));

    expect($branch->fresh()->is_published)->toBeTrue();

    $this->patch(route('admin.roadmap.publication', $branch))
        ->assertRedirect(route('admin.roadmap.index'));

    expect($branch->fresh()->is_published)->toBeFalse();
});

test('learner cannot publish roadmap branches', function () {
    $learner = makeRoadmapUser('learner');

    $branch = RoadmapBranch::where('phase_number', 0)
        ->firstOrFail();

    $this->actingAs($learner)
        ->patch(route('admin.roadmap.publication', $branch))
        ->assertForbidden();

    expect($branch->fresh()->is_published)->toBeFalse();
});

test('guests cannot manage the roadmap', function () {
    $branch = RoadmapBranch::where('phase_number', 0)
        ->firstOrFail();

    $this->get(route('admin.roadmap.index'))
        ->assertRedirect(route('login'));

    $this->patch(route('admin.roadmap.publication', $branch))
        ->assertRedirect(route('login'));

    expect($branch->fresh()->is_published)->toBeFalse();
});
