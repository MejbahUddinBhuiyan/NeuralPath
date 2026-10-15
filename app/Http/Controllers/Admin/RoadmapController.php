<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\RoadmapBranch;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class RoadmapController extends Controller
{
    public function index(): View
    {
        $branches = RoadmapBranch::query()
            ->withCount('sections')
            ->orderBy('phase_number')
            ->get();

        return view('admin.roadmap.index', compact('branches'));
    }

    public function togglePublication(
        Request $request,
        RoadmapBranch $branch
    ): RedirectResponse {
        $branch->is_published = ! $branch->is_published;
        $branch->save();

        return redirect()
            ->route('admin.roadmap.index')
            ->with('status', 'Roadmap publication status updated.');
    }
}
