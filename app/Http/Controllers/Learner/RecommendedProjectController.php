<?php

namespace App\Http\Controllers\Learner;

use App\Http\Controllers\Controller;
use App\Models\RecommendedProject;
use App\Models\RoadmapBranch;
use Illuminate\View\View;

class RecommendedProjectController extends Controller
{
    public function index(RoadmapBranch $branch): View
    {
        abort_unless($branch->is_published, 404);

        $projects = $branch->recommendedProjects()
            ->where('is_published', true)
            ->get();

        return view('learner.projects.index', [
            'branch' => $branch,
            'projects' => $projects,
        ]);
    }

    public function show(
        RoadmapBranch $branch,
        RecommendedProject $project
    ): View {
        abort_unless(
            $branch->is_published
                && $project->roadmap_branch_id === $branch->id
                && $project->is_published,
            404
        );

        return view('learner.projects.show', [
            'branch' => $branch,
            'project' => $project,
        ]);
    }
}