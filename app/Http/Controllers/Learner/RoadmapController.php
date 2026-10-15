<?php

namespace App\Http\Controllers\Learner;

use App\Http\Controllers\Controller;
use App\Models\RoadmapBranch;
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

    public function show(RoadmapBranch $branch): View
    {
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


        return view('learner.roadmap.show', [
            'branch' => $branch,
        ]);
    }
}
