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

        // Only visible, published topics count toward progress.
        $visibleTopicIds = $branch->sections
            ->flatMap(fn ($section) => $section->topics->pluck('id'))
            ->map(fn ($id) => (int) $id)
            ->values()
            ->all();

        // Load this learner's saved progress only.
        $completedTopicIds = $request->user()
            ->topicProgress()
            ->whereIn('roadmap_topic_id', $visibleTopicIds)
            ->pluck('roadmap_topic_id')
            ->map(fn ($id) => (int) $id)
            ->all();

        // Efficient membership lookup for progress calculations.
        $completedLookup = array_fill_keys(
            $completedTopicIds,
            true
        );

        $sectionProgress = [];
        $totalTopics = 0;
        $totalCompleted = 0;

        foreach ($branch->sections as $section) {
            $topicCount = $section->topics->count();

            $completedCount = $section->topics
                ->filter(
                    fn ($topic) => isset(
                        $completedLookup[(int) $topic->id]
                    )
                )
                ->count();

            $percentage = $topicCount > 0
                ? (int) round(($completedCount / $topicCount) * 100)
                : 0;

            $sectionProgress[$section->id] = [
                'total' => $topicCount,
                'completed' => $completedCount,
                'percentage' => $percentage,
            ];

            $totalTopics += $topicCount;
            $totalCompleted += $completedCount;
        }

        $phaseProgress = [
            'total' => $totalTopics,
            'completed' => $totalCompleted,
            'percentage' => $totalTopics > 0
                ? (int) round(($totalCompleted / $totalTopics) * 100)
                : 0,
        ];

        return view('learner.roadmap.show', [
            'branch' => $branch,
            'completedTopicIds' => $completedTopicIds,
            'sectionProgress' => $sectionProgress,
            'phaseProgress' => $phaseProgress,
        ]);
    }
}
