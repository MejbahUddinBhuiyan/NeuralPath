<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\RoadmapBranch;
use App\Models\RoadmapSection;
use App\Models\RoadmapTopic;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Validation\Rule;
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

    private function checkSection(
        RoadmapBranch $branch,
        RoadmapSection $section
    ): void {
        abort_unless(
            $section->roadmap_branch_id === $branch->id,
            404
        );
    }

    private function checkTopic(
        RoadmapSection $section,
        RoadmapTopic $topic
    ): void {
        abort_unless(
            $topic->roadmap_section_id === $section->id,
            404
        );
    }

    private function sectionRules(
        int $branchId,
        ?RoadmapSection $section = null
    ): array {
        return [
            'title' => [
                'required',
                'string',
                'max:150',
                Rule::unique('roadmap_sections', 'title')
                    ->where('roadmap_branch_id', $branchId)
                    ->ignore($section?->id),
            ],
            'description' => [
                'nullable',
                'string',
                'max:3000',
            ],
            'sort_order' => [
                'required',
                'integer',
                'min:0',
                'max:100000',
            ],
        ];
    }

    private function topicRules(
        int $sectionId,
        RoadmapBranch $branch,
        ?RoadmapTopic $topic = null
    ): array {
        return [
            'title' => [
                'required',
                'string',
                'max:150',
                Rule::unique('roadmap_topics', 'title')
                    ->where('roadmap_section_id', $sectionId)
                    ->ignore($topic?->id),
            ],
            'description' => [
                'nullable',
                'string',
                'max:5000',
            ],
            'target_week' => [
                'nullable',
                'integer',
                'between:'.$branch->start_week.','.$branch->end_week,
            ],
            'estimated_minutes' => [
                'nullable',
                'integer',
                'min:1',
                'max:65535',
            ],
            'sort_order' => [
                'required',
                'integer',
                'min:0',
                'max:100000',
            ],
        ];
    }

    private function uniqueSlug(
        string $title,
        string $table,
        string $parentColumn,
        int $parentId
    ): string {
        $base = Str::slug($title) ?: 'untitled';
        $slug = $base;
        $number = 2;

        while (
            \Illuminate\Support\Facades\DB::table($table)
                ->where($parentColumn, $parentId)
                ->where('slug', $slug)
                ->exists()
        ) {
            $slug = $base.'-'.$number;
            $number++;
        }

        return $slug;
    }

    // ------------------------------
    // Sub-branch creation and editing
    // ------------------------------

    public function createSection(
        RoadmapBranch $branch
    ): View {
        return view('admin.roadmap.editor', [
            'branch' => $branch,
            'section' => null,
            'topic' => null,
            'editorType' => 'section',
            'isEditing' => false,
        ]);
    }

    public function storeSection(
        Request $request,
        RoadmapBranch $branch
    ): RedirectResponse {
        $data = $request->validate(
            $this->sectionRules($branch->id)
        );

        $data['slug'] = $this->uniqueSlug(
            $data['title'],
            'roadmap_sections',
            'roadmap_branch_id',
            $branch->id
        );

        $branch->sections()->create($data);

        return redirect()
            ->route('admin.roadmap.sections', $branch)
            ->with('status', 'Sub-branch created successfully.');
    }

    public function editSection(
        RoadmapBranch $branch,
        RoadmapSection $section
    ): View {
        $this->checkSection($branch, $section);

        return view('admin.roadmap.editor', [
            'branch' => $branch,
            'section' => $section,
            'topic' => null,
            'editorType' => 'section',
            'isEditing' => true,
        ]);
    }

    public function updateSection(
        Request $request,
        RoadmapBranch $branch,
        RoadmapSection $section
    ): RedirectResponse {
        $this->checkSection($branch, $section);

        $data = $request->validate(
            $this->sectionRules($branch->id, $section)
        );

        // Keep the existing slug as a stable identifier.
        $section->update($data);

        return redirect()
            ->route('admin.roadmap.sections', $branch)
            ->with('status', 'Sub-branch updated successfully.');
    }

    // ------------------------------
    // Topic creation and editing
    // ------------------------------

    public function createTopic(
        RoadmapBranch $branch,
        RoadmapSection $section
    ): View {
        $this->checkSection($branch, $section);

        return view('admin.roadmap.editor', [
            'branch' => $branch,
            'section' => $section,
            'topic' => null,
            'editorType' => 'topic',
            'isEditing' => false,
        ]);
    }

    public function storeTopic(
        Request $request,
        RoadmapBranch $branch,
        RoadmapSection $section
    ): RedirectResponse {
        $this->checkSection($branch, $section);

        $data = $request->validate(
            $this->topicRules($section->id, $branch)
        );

        $data['slug'] = $this->uniqueSlug(
            $data['title'],
            'roadmap_topics',
            'roadmap_section_id',
            $section->id
        );

        $section->topics()->create($data);

        return redirect()
            ->route('admin.roadmap.sections', $branch)
            ->with('status', 'Learning topic created successfully.');
    }

    public function editTopic(
        RoadmapBranch $branch,
        RoadmapSection $section,
        RoadmapTopic $topic
    ): View {
        $this->checkSection($branch, $section);
        $this->checkTopic($section, $topic);

        return view('admin.roadmap.editor', [
            'branch' => $branch,
            'section' => $section,
            'topic' => $topic,
            'editorType' => 'topic',
            'isEditing' => true,
        ]);
    }

    public function updateTopic(
        Request $request,
        RoadmapBranch $branch,
        RoadmapSection $section,
        RoadmapTopic $topic
    ): RedirectResponse {
        $this->checkSection($branch, $section);
        $this->checkTopic($section, $topic);

        $data = $request->validate(
            $this->topicRules($section->id, $branch, $topic)
        );

        // Preserve the original slug.
        $topic->update($data);

        return redirect()
            ->route('admin.roadmap.sections', $branch)
            ->with('status', 'Learning topic updated successfully.');
    }

    // ------------------------------
    // Existing publication controls
    // ------------------------------

    public function toggleSection(
        RoadmapBranch $branch,
        RoadmapSection $section
    ): RedirectResponse {
        $this->checkSection($branch, $section);

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
        $this->checkSection($branch, $section);
        $this->checkTopic($section, $topic);

        $topic->is_published = ! $topic->is_published;
        $topic->save();

        return redirect()
            ->route('admin.roadmap.sections', $branch)
            ->with('status', 'Topic publication updated.');
    }
}
