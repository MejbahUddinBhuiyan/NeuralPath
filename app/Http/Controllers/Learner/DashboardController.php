<?php

namespace App\Http\Controllers\Learner;

use App\Http\Controllers\Controller;
use App\Services\LearningProgressService;
use Illuminate\Http\Request;
use Illuminate\View\View;

class DashboardController extends Controller
{
    public function index(
        Request $request,
        LearningProgressService $progressService
    ): View {
        $branches = $progressService->publishedBranches();

        $progress = $progressService->calculate(
            $request->user(),
            $branches
        );

        $phaseProgress = $progress['phaseProgress'];
        $completedLookup = array_fill_keys(
            $progress['completedTopicIds'],
            true
        );

        // Prefer the first published phase with unfinished topics.
        $currentBranch = $branches->first(function ($branch) use ($phaseProgress) {
            $phase = $phaseProgress[$branch->id];

            return $phase['total'] > 0
                && $phase['completed'] < $phase['total'];
        });

        // If every available topic is complete, show the first
        // published phase that contains learning content.
        if (!$currentBranch) {
            $currentBranch = $branches->first(
                fn ($branch) => $phaseProgress[$branch->id]['total'] > 0
            );
        }

        // A published roadmap may still have no published topics.
        $currentBranch ??= $branches->first();

        $nextTopic = null;

        if ($currentBranch) {
            foreach ($currentBranch->sections as $section) {
                foreach ($section->topics as $topic) {
                    if (!isset($completedLookup[(int) $topic->id])) {
                        $nextTopic = $topic;
                        break 2;
                    }
                }
            }
        }

        return view('learner.dashboard', [
            'branches' => $branches,
            'overallProgress' => $progress['overallProgress'],
            'phaseProgress' => $phaseProgress,
            'currentBranch' => $currentBranch,
            'nextTopic' => $nextTopic,
        ]);
    }
}
