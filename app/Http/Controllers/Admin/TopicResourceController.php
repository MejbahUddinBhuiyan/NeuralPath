<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\RoadmapBranch;
use App\Models\RoadmapSection;
use App\Models\RoadmapTopic;
use App\Models\TopicResource;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Illuminate\View\View;

class TopicResourceController extends Controller
{
    private function checkParents(
        RoadmapBranch $branch,
        RoadmapSection $section,
        RoadmapTopic $topic
    ): void {
        abort_unless(
            $section->roadmap_branch_id === $branch->id,
            404
        );

        abort_unless(
            $topic->roadmap_section_id === $section->id,
            404
        );
    }

    private function rules(): array
    {
        return [
            'title' => ['required', 'string', 'max:180'],
            'url' => [
                'required',
                'string',
                'max:2048',
                'url:http,https',
            ],
            'type' => [
                'required',
                Rule::in([
                    'documentation',
                    'youtube',
                    'article',
                    'course',
                    'other',
                ]),
            ],
            'description' => [
                'nullable',
                'string',
                'max:3000',
            ],
            'sort_order' => [
                'required',
                'integer',
                'min:0',
                'max:100000',
            ],
        ];
    }

    public function index(
        RoadmapBranch $branch,
        RoadmapSection $section,
        RoadmapTopic $topic
    ): View {
        $this->checkParents($branch, $section, $topic);

        $topic->load('resources');

        return view('admin.roadmap.resources', compact(
            'branch',
            'section',
            'topic'
        ));
    }

    public function store(
        Request $request,
        RoadmapBranch $branch,
        RoadmapSection $section,
        RoadmapTopic $topic
    ): RedirectResponse {
        $this->checkParents($branch, $section, $topic);

        $data = $request->validate($this->rules());

        // Force new learning resources to start as drafts.
        $data['is_published'] = false;

        $topic->resources()->create($data);

        return redirect()
            ->route('admin.roadmap.resources.index', [
                $branch, $section, $topic,
            ])
            ->with('status', 'Resource added as a draft.');
    }

    public function update(
        Request $request,
        RoadmapBranch $branch,
        RoadmapSection $section,
        RoadmapTopic $topic,
        TopicResource $resource
    ): RedirectResponse {
        $this->checkParents($branch, $section, $topic);

        abort_unless(
            $resource->roadmap_topic_id === $topic->id,
            404
        );

        $resource->update(
            $request->validate($this->rules())
        );

        return redirect()
            ->route('admin.roadmap.resources.index', [
                $branch, $section, $topic,
            ])
            ->with('status', 'Resource updated successfully.');
    }

    public function togglePublication(
        RoadmapBranch $branch,
        RoadmapSection $section,
        RoadmapTopic $topic,
        TopicResource $resource
    ): RedirectResponse {
        $this->checkParents($branch, $section, $topic);

        abort_unless(
            $resource->roadmap_topic_id === $topic->id,
            404
        );

        $resource->is_published = ! $resource->is_published;
        $resource->save();

        return redirect()
            ->route('admin.roadmap.resources.index', [
                $branch, $section, $topic,
            ])
            ->with('status', 'Resource publication updated.');
    }
}
