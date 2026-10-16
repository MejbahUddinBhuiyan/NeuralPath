<?php

namespace App\Http\Controllers\Learner;

use App\Http\Controllers\Controller;
use App\Models\RoadmapTopic;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class TopicCompletionController extends Controller
{
    private function ensureEligibleUser(
        Request $request
    ): ?RedirectResponse {
        $user = $request->user()?->fresh();

        if (
            ! $user ||
            ! $user->canUseLearnerFeatures()
        ) {
            Auth::guard('web')->logout();

            $request->session()->invalidate();
            $request->session()->regenerateToken();

            return redirect()
                ->route('login')
                ->withErrors([
                    'email' => 'Your account is inactive or not verified. Please contact the administrator.',
                ]);
        }

        return null;
    }

    private function findPublishedTopic(int $topicId): RoadmapTopic
    {
        return RoadmapTopic::query()
            ->whereKey($topicId)
            ->where('is_published', true)
            ->whereHas('section', function ($query) {
                $query->where('is_published', true)
                    ->whereHas('branch', function ($branchQuery) {
                        $branchQuery->where('is_published', true);
                    });
            })
            ->firstOrFail();
    }

    public function complete(
        Request $request,
        RoadmapTopic $topic
    ): RedirectResponse {
        if ($redirect = $this->ensureEligibleUser($request)) {
            return $redirect;
        }

        $topic = $this->findPublishedTopic($topic->id);

        // Always save to the signed-in user's own progress.
        $request->user()
            ->topicProgress()
            ->firstOrCreate(
                [
                    'roadmap_topic_id' => $topic->id,
                ],
                [
                    'completed_at' => now(),
                ]
            );

        return redirect()
            ->route(
                'learner.roadmap.show',
                $topic->section->roadmap_branch_id
            )
            ->with('status', 'Topic marked as complete.');
    }

    public function incomplete(
        Request $request,
        RoadmapTopic $topic
    ): RedirectResponse {
        if ($redirect = $this->ensureEligibleUser($request)) {
            return $redirect;
        }

        $topic = $this->findPublishedTopic($topic->id);

        // Never delete completion records belonging to another user.
        $request->user()
            ->topicProgress()
            ->where('roadmap_topic_id', $topic->id)
            ->delete();

        return redirect()
            ->route(
                'learner.roadmap.show',
                $topic->section->roadmap_branch_id
            )
            ->with('status', 'Topic marked as incomplete.');
    }
}
