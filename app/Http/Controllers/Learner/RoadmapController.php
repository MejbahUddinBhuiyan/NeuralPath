<?php

namespace App\Http\Controllers\Learner;

use App\Http\Controllers\Controller;
use App\Models\RoadmapBranch;
use Illuminate\Http\Request;
use Illuminate\View\View;

class RoadmapController extends Controller
{
    public function index(): View
    {
        $branches = RoadmapBranch::query()
            ->where('is_published', true)
            ->withCount([
                'sections as published_sections_count' => function ($query) {
                    $query->where('is_published', true);
                },
            ])
            ->orderBy('phase_number')
            ->get();

        return view('learner.roadmap.index', [
            'branches' => $branches,
        ]);
    }

    public function show(
        Request $request,
        RoadmapBranch $branch
    ): View {
        abort_unless($branch->is_published, 404);

        $branch->load([
            'sections' => function ($query) {
                $query->where('is_published', true)
                    ->orderBy('sort_order')
                    ->orderBy('id');
            },

            'sections.topics' => function ($query) {
                $query->where('is_published', true)
                    ->orderBy('sort_order')
                    ->orderBy('id');
            },

            'sections.topics.resources' => function ($query) {
                $query->where('is_published', true)
                    ->orderBy('sort_order')
                    ->orderBy('id');
            },
        ]);

        // Only published topics visible on this page.
        $visibleTopicIds = $branch->sections
            ->flatMap(function ($section) {
                return $section->topics->pluck('id');
            })
            ->values()
            ->all();

        // Read progress for the authenticated learner only.
        $completedTopicIds = $request->user()
            ->topicProgress()
            ->whereIn('roadmap_topic_id', $visibleTopicIds)
            ->pluck('roadmap_topic_id')
            ->map(function ($id) {
                return (int) $id;
            })
            ->all();

        return view('learner.roadmap.show', [
            'branch' => $branch,
            'completedTopicIds' => $completedTopicIds,
        ]);
    }
}
