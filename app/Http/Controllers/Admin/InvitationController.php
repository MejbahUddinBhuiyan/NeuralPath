<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Invitation;
use App\Notifications\LearnerInvitation;
use App\Services\InvitationService;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Notification;
use Illuminate\View\View;

class InvitationController extends Controller
{
    public function index(): View
    {
        return view('admin.invitations.index', [
            'invitations' => Invitation::query()
                ->latest()
                ->paginate(10),
        ]);
    }

    public function store(
        Request $request,
        InvitationService $service
    ): RedirectResponse {
        $validated = $request->validate([
            'email' => [
                'required',
                'string',
                'email',
                'max:255',
            ],
        ]);

        $result = $service->create(
            $validated['email'],
            $request->user()
        );

        Notification::route(
            'mail',
            $result['invitation']->email
        )->notify(
            new LearnerInvitation($result['token'])
        );

        return back()->with(
            'success',
            'Invitation generated and sent through the configured mail driver.'
        );
    }
}
