<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\RecommendedProject;
use App\Models\RoadmapBranch;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Validation\Rule;
use Illuminate\View\View;

class RecommendedProjectController extends Controller
{
    public function index(RoadmapBranch $branch): View
    {
        return view('admin.projects.index', [
            'branch' => $branch,
            'projects' => $branch->recommendedProjects()->get(),
        ]);
    }

    public function store(
        Request $request,
        RoadmapBranch $branch
    ): RedirectResponse {
        if ($branch->recommendedProjects()->count() >= 5) {
    return back()->withErrors([
        'title' => 'This phase already has five recommended projects. Edit or replace an existing project.',
    ]);
}
        $data = $this->validatedData($request, $branch);

        $data['slug'] = Str::slug($data['title']);
        $data['is_published'] = false;

        $branch->recommendedProjects()->create($data);

        return back()->with('status', 'Project created as a draft.');
    }

    public function update(
        Request $request,
        RoadmapBranch $branch,
        RecommendedProject $project
    ): RedirectResponse {
        $this->ensureBelongsToBranch($branch, $project);

        $data = $this->validatedData($request, $branch, $project);

        // Slug is stable so existing URLs remain valid.
        unset($data['slug']);

        $project->update($data);

        return back()->with('status', 'Project updated successfully.');
    }

    public function togglePublication(
        RoadmapBranch $branch,
        RecommendedProject $project
    ): RedirectResponse {
        $this->ensureBelongsToBranch($branch, $project);

        $project->is_published = ! $project->is_published;
        $project->save();

        return back()->with(
            'status',
            $project->is_published
                ? 'Project published.'
                : 'Project returned to draft.'
        );
    }

    public function destroy(
        RoadmapBranch $branch,
        RecommendedProject $project
    ): RedirectResponse {
        $this->ensureBelongsToBranch($branch, $project);

        $project->delete();

        return back()->with('status', 'Project deleted.');
    }

    private function ensureBelongsToBranch(
        RoadmapBranch $branch,
        RecommendedProject $project
    ): void {
        abort_unless(
            $project->roadmap_branch_id === $branch->id,
            404
        );
    }

    private function validatedData(
        Request $request,
        RoadmapBranch $branch,
        ?RecommendedProject $project = null
    ): array {
        $rules = [
            'title' => [
                'required',
                'string',
                'max:255',
            ],
            'description' => ['required', 'string', 'max:5000'],
            'difficulty' => [
                'required',
                Rule::in(['beginner', 'intermediate', 'advanced']),
            ],
            'estimated_weeks' => ['nullable', 'string', 'max:50'],
            'tech_stack' => ['nullable', 'string', 'max:2000'],
            'requirements' => ['nullable', 'string', 'max:10000'],
            'deliverables' => ['nullable', 'string', 'max:10000'],
            'resource_url' => [
                'nullable',
                'url',
                'starts_with:https://,http://',
                'max:2048',
            ],
            'sort_order' => ['required', 'integer', 'min:0', 'max:10000'],
        ];

        $data = $request->validate($rules);

        $slug = $project?->slug ?? Str::slug($data['title']);

        if ($project === null) {
            $request->validate([
                'title' => [
                    function ($attribute, $value, $fail) use ($branch, $slug) {
                        if (
                            $branch->recommendedProjects()
                                ->where('slug', $slug)
                                ->exists()
                        ) {
                            $fail('A project with this title already exists in this phase.');
                        }
                    },
                ],
            ]);
        }

        return $data;
    }
}
