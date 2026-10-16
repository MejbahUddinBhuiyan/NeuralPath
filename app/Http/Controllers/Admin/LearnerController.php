<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Services\LearningProgressService;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class LearnerController extends Controller
{
    public function index(Request $request): View
    {
        $validated = $request->validate([
            'search' => ['nullable', 'string', 'max:100'],
            'status' => ['nullable', 'in:all,active,suspended'],
        ]);

        $search = trim($validated['search'] ?? '');
        $status = $validated['status'] ?? 'all';

        $learners = User::query()
            ->where('role', 'learner')
            ->when($search !== '', function ($query) use ($search) {
                $query->where(function ($subQuery) use ($search) {
                    $subQuery
                        ->where('name', 'like', '%' . $search . '%')
                        ->orWhere('email', 'like', '%' . $search . '%');
                });
            })
            ->when($status === 'active', function ($query) {
                $query->where('is_active', true);
            })
            ->when($status === 'suspended', function ($query) {
                $query->where('is_active', false);
            })
            ->orderBy('name')
            ->orderBy('id')
            ->paginate(15)
            ->withQueryString();

        return view('admin.learners.index', [
            'learners' => $learners,
            'search' => $search,
            'status' => $status,
        ]);
    }

    public function show(
        User $learner,
        LearningProgressService $progressService
    ): View {
        abort_unless($learner->isLearner(), 404);

        $branches = $progressService->publishedBranches();

        $progress = $progressService->calculate(
            $learner,
            $branches
        );

        return view('admin.learners.show', [
            'learner' => $learner,
            'branches' => $branches,
            'overallProgress' => $progress['overallProgress'],
            'phaseProgress' => $progress['phaseProgress'],
        ]);
    }

    public function updateStatus(
        Request $request,
        User $learner
    ): RedirectResponse {
        abort_unless($learner->isLearner(), 404);

        $validated = $request->validate([
            'is_active' => ['required', 'boolean'],
        ]);

        $newStatus = (bool) $validated['is_active'];

        /*
         * Account status is deliberately not fillable in User.php.
         * This trusted admin-only operation assigns it explicitly.
         */
        $learner->is_active = $newStatus;
        $learner->save();

        return redirect()
            ->route('admin.learners.show', $learner)
            ->with(
                'status',
                $newStatus
                    ? 'Learner account activated successfully.'
                    : 'Learner account suspended successfully.'
            );
    }
}
