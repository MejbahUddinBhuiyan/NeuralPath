
<?php

use App\Models\RoadmapBranch;
use App\Models\RoadmapSection;
use App\Models\RoadmapTopic;
use App\Models\TopicResource;
use App\Models\User;
use Database\Seeders\RoadmapBranchSeeder;
use Database\Seeders\PhaseZeroSeeder;
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

    $this->learner = User::factory()->create([
        'role' => 'learner',
        'is_active' => true,
        'email_verified_at' => now(),
    ]);
});

function resourceUrl($test, $resource = null): string
{
    $params = [
        $test->branch,
        $test->section,
        $test->topic,
    ];

    if ($resource) {
        $params[] = $resource;
    }

    return route(
        'admin.roadmap.resources.'.
            ($resource ? 'publication' : 'store'),
        $params
    );
}

test('administrator can add a draft resource', function () {
    $this->actingAs($this->admin)
        ->post(resourceUrl($this), [
            'title' => 'Python Typing Reference',
            'url' => 'https://docs.python.org/3/library/typing.html',
            'type' => 'documentation',
            'sort_order' => 1,
        ])
        ->assertRedirect();

    $resource = TopicResource::firstOrFail();

    expect($resource->is_published)->toBeFalse();
    expect($resource->roadmap_topic_id)->toBe($this->topic->id);
});

test('administrator can view and publish resources', function () {
    $resource = $this->topic->resources()->create([
        'title' => 'Python Docs',
        'url' => 'https://docs.python.org/',
        'type' => 'documentation',
    ]);

    $this->actingAs($this->admin)
        ->get(route('admin.roadmap.resources.index', [
            $this->branch, $this->section, $this->topic,
        ]))
        ->assertOk()
        ->assertSee('Python Docs');

    $this->patch(resourceUrl($this, $resource))
        ->assertRedirect();

    expect($resource->fresh()->is_published)->toBeTrue();
});

test('administrator can update an existing resource', function () {
    $resource = $this->topic->resources()->create([
        'title' => 'Old Resource',
        'url' => 'https://example.com/old',
        'type' => 'article',
    ]);

    $this->actingAs($this->admin)
        ->put(route('admin.roadmap.resources.update', [
            $this->branch, $this->section,
            $this->topic, $resource,
        ]), [
            'title' => 'Updated Resource',
            'url' => 'https://example.com/new',
            'type' => 'documentation',
            'sort_order' => 2,
        ])
        ->assertRedirect();

    expect($resource->fresh()->title)->toBe('Updated Resource');
});

test('invalid resource URLs are rejected', function () {
    $this->actingAs($this->admin)
        ->post(resourceUrl($this), [
            'title' => 'Unsafe Resource',
            'url' => 'javascript:alert(1)',
            'type' => 'documentation',
            'sort_order' => 0,
        ])
        ->assertSessionHasErrors('url');

    $this->assertDatabaseCount('topic_resources', 0);
});

test('learner cannot create a resource', function () {
    $this->actingAs($this->learner)
        ->post(resourceUrl($this), [
            'title' => 'Unauthorized',
            'url' => 'https://example.com',
            'type' => 'article',
            'sort_order' => 0,
        ])
        ->assertForbidden();

    $this->assertDatabaseCount('topic_resources', 0);
});

test('resource cannot be managed through a different topic', function () {
    $resource = $this->topic->resources()->create([
        'title' => 'Python Docs',
        'url' => 'https://docs.python.org/',
        'type' => 'documentation',
    ]);

    $otherTopic = $this->section->topics()
        ->where('slug', 'exception-handling')
        ->firstOrFail();

    $this->actingAs($this->admin)
        ->patch(route('admin.roadmap.resources.publication', [
            $this->branch, $this->section,
            $otherTopic, $resource,
        ]))->assertNotFound();

    expect($resource->fresh()->is_published)->toBeFalse();
});

test('learners see published resources but not drafts', function () {
    $this->branch->is_published = true;
    $this->branch->save();

    $this->section->is_published = true;
    $this->section->save();

    $this->topic->is_published = true;
    $this->topic->save();

    $this->topic->resources()->create([
        'title' => 'Visible Python Reference',
        'url' => 'https://docs.python.org/',
        'type' => 'documentation',
        'is_published' => true,
    ]);

    $this->topic->resources()->create([
        'title' => 'Hidden Python Reference',
        'url' => 'https://example.com/private',
        'type' => 'article',
        'is_published' => false,
    ]);

    $this->actingAs($this->learner)
        ->get(route('learner.roadmap.show', $this->branch))
        ->assertOk()
        ->assertSee('Visible Python Reference')
        ->assertDontSee('Hidden Python Reference');
});
