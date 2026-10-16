<?php

namespace App\Services;

use App\Models\RoadmapBranch;
use App\Models\User;
use Illuminate\Support\Collection;

class LearningProgressService
{
    /**
     * Load the published curriculum for all visible phases.
     */
    public function publishedBranches(): Collection
    {
        return RoadmapBranch::query()
            ->where('is_published', true)
            ->with([
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
            ])
            ->orderBy('phase_number')
            ->orderBy('id')
            ->get();
    }

    /**
     * Calculate a learner's progress across the supplied branches.
     *
     * The caller must supply branches whose sections and topics
     * have already been restricted to published content.
     */
    public function calculate(User $user, Collection $branches): array
    {
        $visibleTopicIds = $branches
            ->flatMap(fn ($branch) => $branch->sections)
            ->flatMap(fn ($section) => $section->topics)
            ->pluck('id')
            ->map(fn ($id) => (int) $id)
            ->unique()
            ->values()
            ->all();

        $completedTopicIds = $user->topicProgress()
            ->whereIn('roadmap_topic_id', $visibleTopicIds)
            ->pluck('roadmap_topic_id')
            ->map(fn ($id) => (int) $id)
            ->unique()
            ->values()
            ->all();

        $completedLookup = array_fill_keys(
            $completedTopicIds,
            true
        );

        $phaseProgress = [];
        $sectionProgress = [];

        $overallTotal = 0;
        $overallCompleted = 0;

        foreach ($branches as $branch) {
            $phaseTotal = 0;
            $phaseCompleted = 0;

            foreach ($branch->sections as $section) {
                $sectionTotal = $section->topics->count();

                $sectionCompleted = $section->topics
                    ->filter(
                        fn ($topic) => isset(
                            $completedLookup[(int) $topic->id]
                        )
                    )
                    ->count();

                $sectionProgress[$section->id] = $this->summary(
                    $sectionCompleted,
                    $sectionTotal
                );

                $phaseTotal += $sectionTotal;
                $phaseCompleted += $sectionCompleted;
            }

            $phaseProgress[$branch->id] = $this->summary(
                $phaseCompleted,
                $phaseTotal
            );

            $overallTotal += $phaseTotal;
            $overallCompleted += $phaseCompleted;
        }

        return [
            'completedTopicIds' => $completedTopicIds,
            'sectionProgress' => $sectionProgress,
            'phaseProgress' => $phaseProgress,
            'overallProgress' => $this->summary(
                $overallCompleted,
                $overallTotal
            ),
        ];
    }

    /**
     * Standard progress calculation.
     *
     * Empty content always shows 0%, never 100%.
     */
    private function summary(int $completed, int $total): array
    {
        return [
            'completed' => $completed,
            'total' => $total,
            'percentage' => $total > 0
                ? (int) round(($completed / $total) * 100)
                : 0,
        ];
    }
}
