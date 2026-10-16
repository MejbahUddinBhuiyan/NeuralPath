
<?php

use App\Models\RecommendedProject;
use App\Models\RoadmapBranch;
use App\Models\User;
use Database\Seeders\RoadmapBranchSeeder;
use Illuminate\Foundation\Testing\RefreshDatabase;

uses(RefreshDatabase::class);

beforeEach(function () {
    $this->seed(RoadmapBranchSeeder::class);

    $this->branch = RoadmapBranch::query()
        ->where('phase_number', 0)
        ->firstOrFail();

    $this->branch->update(['is_published' => true]);

    $this->admin = User::factory()->create([
        'role' => 'admin',
        'is_active' => true,
        'email_verified_at' => now(),
    ]);

    $this->learner = User::factory()->create([
        'role' => 'learner',
        'is_active' => true,
        'email_verified_at' => now(),
    ]);

    $this->project = $this->branch->recommendedProjects()->create([
        'title' => 'Test AI API Gateway',
        'slug' => 'test-ai-api-gateway',
        'description' => 'Create an AI API gateway.',
        'difficulty' => 'intermediate',
        'estimated_weeks' => '2 weeks',
        'tech_stack' => 'Python, FastAPI',
        'requirements' => 'Implement authentication and tests.',
        'deliverables' => 'GitHub repository and demo.',
        'sort_order' => 1,
        'is_published' => false,
    ]);
});

test('admin can view projects for a phase', function () {
    $this->actingAs($this->admin)
        ->get(route('admin.projects.index', $this->branch))
        ->assertOk()
        ->assertSee($this->project->title);
});

test('admin can create a draft project', function () {
    $this->actingAs($this->admin)
        ->post(route('admin.projects.store', $this->branch), [
            'title' => 'New Agent Project',
            'description' => 'A test project.',
            'difficulty' => 'beginner',
            'estimated_weeks' => '1 week',
            'tech_stack' => 'Python',
            'requirements' => 'Working implementation.',
            'deliverables' => 'Source code and README.',
            'resource_url' => 'https://docs.python.org/',
            'sort_order' => 2,
        ])
        ->assertRedirect();

    $this->assertDatabaseHas('recommended_projects', [
        'roadmap_branch_id' => $this->branch->id,
        'slug' => 'new-agent-project',
        'is_published' => false,
    ]);
});

test('admin can edit project without changing slug', function () {
    $this->actingAs($this->admin)
        ->put(route('admin.projects.update', [
            $this->branch,
            $this->project,
        ]), [
            'title' => 'Updated Project Name',
            'description' => 'Updated description.',
            'difficulty' => 'advanced',
            'estimated_weeks' => '3 weeks',
            'tech_stack' => 'Python, Docker',
            'requirements' => 'Create and test.',
            'deliverables' => 'Application and tests.',
            'resource_url' => '',
            'sort_order' => 1,
        ])
        ->assertRedirect();

    expect($this->project->fresh()->title)
        ->toBe('Updated Project Name');

    expect($this->project->fresh()->slug)
        ->toBe('test-ai-api-gateway');
});

test('admin can publish and unpublish project', function () {
    $this->actingAs($this->admin)
        ->patch(route('admin.projects.publication', [
            $this->branch,
            $this->project,
        ]))
        ->assertRedirect();

    expect($this->project->fresh()->is_published)->toBeTrue();

    $this->patch(route('admin.projects.publication', [
        $this->branch,
        $this->project,
    ]))->assertRedirect();

    expect($this->project->fresh()->is_published)->toBeFalse();
});

test('admin can delete a recommendation', function () {
    $this->actingAs($this->admin)
        ->delete(route('admin.projects.destroy', [
            $this->branch,
            $this->project,
        ]))
        ->assertRedirect();

    $this->assertDatabaseMissing('recommended_projects', [
        'id' => $this->project->id,
    ]);
});

test('learners cannot manage project recommendations', function () {
    $this->actingAs($this->learner)
        ->get(route('admin.projects.index', $this->branch))
        ->assertForbidden();

    $this->patch(route('admin.projects.publication', [
        $this->branch,
        $this->project,
    ]))->assertForbidden();
});

test('unpublished projects are hidden from learners', function () {
    $this->actingAs($this->learner)
        ->get(route('learner.projects.index', $this->branch))
        ->assertOk()
        ->assertDontSee($this->project->title);

    $this->get(route('learner.projects.show', [
        $this->branch,
        $this->project,
    ]))->assertNotFound();
});

test('published projects appear for learners', function () {
    $this->project->update(['is_published' => true]);

    $this->actingAs($this->learner)
        ->get(route('learner.projects.index', $this->branch))
        ->assertOk()
        ->assertSee($this->project->title);

    $this->get(route('learner.projects.show', [
        $this->branch,
        $this->project,
    ]))
        ->assertOk()
        ->assertSee('Expected Deliverables');
});

test('unpublished phases hide their projects', function () {
    $this->project->update(['is_published' => true]);
    $this->branch->update(['is_published' => false]);

    $this->actingAs($this->learner)
        ->get(route('learner.projects.index', $this->branch))
        ->assertNotFound();
});

test('projects cannot be managed through another phase', function () {
    $differentBranch = RoadmapBranch::query()
        ->where('phase_number', 1)
        ->firstOrFail();

    $this->actingAs($this->admin)
        ->patch(route('admin.projects.publication', [
            $differentBranch,
            $this->project,
        ]))
        ->assertNotFound();
});

test('recommended projects do not modify topic completion', function () {
    $this->project->update(['is_published' => true]);

    $this->actingAs($this->learner)
        ->get(route('learner.projects.show', [
            $this->branch,
            $this->project,
        ]))
        ->assertOk();

    $this->assertDatabaseCount('topic_progress', 0);
});
