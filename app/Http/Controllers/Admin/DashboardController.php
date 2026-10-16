<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\RoadmapBranch;
use App\Models\RoadmapTopic;
use App\Models\TopicProgress;
use App\Models\User;
use Illuminate\View\View;

class DashboardController extends Controller
{
    public function index(): View
    {
        $learnerQuery = User::query()
            ->where('role', 'learner');

        $stats = [
            'total_learners' => (clone $learnerQuery)->count(),

            'active_learners' => (clone $learnerQuery)
                ->where('is_active', true)
                ->count(),

            'suspended_learners' => (clone $learnerQuery)
                ->where('is_active', false)
                ->count(),

            'published_phases' => RoadmapBranch::query()
                ->where('is_published', true)
                ->count(),

            'published_topics' => RoadmapTopic::query()
                ->where('is_published', true)
                ->whereHas('section', function ($query) {
                    $query->where('is_published', true)
                        ->whereHas('branch', function ($branchQuery) {
                            $branchQuery->where('is_published', true);
                        });
                })
                ->count(),

            'total_completions' => TopicProgress::query()
                ->whereHas('user', function ($query) {
                    $query->where('role', 'learner');
                })
                ->whereHas('topic', function ($query) {
                    $query->where('is_published', true)
                        ->whereHas('section', function ($sectionQuery) {
                            $sectionQuery->where('is_published', true)
                                ->whereHas('branch', function ($branchQuery) {
                                    $branchQuery->where('is_published', true);
                                });
                        });
                })
                ->count(),
        ];

        return view('admin.dashboard', [
            'stats' => $stats,
        ]);
    }
}
