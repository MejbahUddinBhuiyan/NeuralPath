<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\RoadmapBranch;
use App\Models\RoadmapSection;
use App\Models\RoadmapTopic;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;

class RoadmapSectionController extends Controller
{
    public function index(RoadmapBranch $branch): View
    {
        $branch->load([
            'sections' => fn ($query) => $query
                ->with('topics')
                ->orderBy('sort_order')
                ->orderBy('id'),
        ]);

        return view('admin.roadmap.sections', [
            'branch' => $branch,
        ]);
    }

    public function toggleSection(
        RoadmapBranch $branch,
        RoadmapSection $section
    ): RedirectResponse {
        abort_unless(
            $section->roadmap_branch_id === $branch->id,
            404
        );

        $section->is_published = ! $section->is_published;
        $section->save();

        return redirect()
            ->route('admin.roadmap.sections', $branch)
            ->with('status', 'Sub-branch publication updated.');
    }

    public function toggleTopic(
        RoadmapBranch $branch,
        RoadmapSection $section,
        RoadmapTopic $topic
    ): RedirectResponse {
        abort_unless(
            $section->roadmap_branch_id === $branch->id,
            404
        );

        abort_unless(
            $topic->roadmap_section_id === $section->id,
            404
        );

        $topic->is_published = ! $topic->is_published;
        $topic->save();

        return redirect()
            ->route('admin.roadmap.sections', $branch)
            ->with('status', 'Topic publication updated.');
    }
}
