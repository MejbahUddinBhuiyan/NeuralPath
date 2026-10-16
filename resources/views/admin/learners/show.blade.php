
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="color-scheme" content="dark">

    <title>{{ $learner->name }} | NeuralPath Admin</title>

    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <style>
        * { box-sizing: border-box; }

        body {
            margin: 0;
            background: #080e1e;
            color: #ffffff;
            font-family: Inter, ui-sans-serif, system-ui, sans-serif;
            line-height: 1.6;
        }

        .shell {
            max-width: 1050px;
            margin: auto;
            padding: 35px 20px 70px;
        }

        .header {
            display: flex;
            align-items: center;
            justify-content: space-between;
            gap: 15px;
            flex-wrap: wrap;
            margin-bottom: 35px;
        }

        .brand {
            color: #67e8f9;
            font-weight: 850;
            text-decoration: none;
        }

        .back {
            color: #ffffff;
            padding: 10px 15px;
            background: #172239;
            border: 1px solid #475569;
            border-radius: 9px;
            font-size: 13px;
            text-decoration: none;
        }

        h1 {
            margin: 6px 0;
            font-size: clamp(26px, 4vw, 34px);
        }

        h2 {
            margin-top: 0;
            font-size: 19px;
        }

        .eyebrow {
            color: #67e8f9;
            font-size: 12px;
            font-weight: 800;
            letter-spacing: 1px;
            text-transform: uppercase;
        }

        .subtitle {
            margin: 0 0 30px;
            color: #cbd5e1;
            font-size: 13px;
            overflow-wrap: anywhere;
        }

        .panel {
            padding: 23px;
            margin-bottom: 20px;
            background: #131e33;
            border: 1px solid #30415b;
            border-radius: 14px;
        }

        .notice {
            padding: 15px;
            margin-bottom: 20px;
            background: #103a32;
            border: 1px solid #059669;
            border-radius: 9px;
            color: #a7f3d0;
            font-size: 13px;
        }

        .stats {
            display: grid;
            grid-template-columns: repeat(3, minmax(0, 1fr));
            gap: 15px;
            margin-bottom: 22px;
        }

        .stat {
            padding: 20px;
            background: #131e33;
            border: 1px solid #30415b;
            border-radius: 12px;
        }

        .stat-label {
            font-size: 12px;
            color: #cbd5e1;
        }

        .stat-value {
            margin-top: 8px;
            color: #67e8f9;
            font-size: 28px;
            font-weight: 850;
        }

        .account-row {
            display: flex;
            align-items: center;
            justify-content: space-between;
            flex-wrap: wrap;
            gap: 16px;
        }

        .account-info {
            color: #cbd5e1;
            font-size: 13px;
        }

        .account-status {
            color: #ffffff;
            font-weight: 800;
        }

        .action-button {
            padding: 11px 17px;
            border-radius: 9px;
            border: 1px solid;
            font-family: inherit;
            font-size: 13px;
            font-weight: 800;
            cursor: pointer;
        }

        .activate {
            background: #065f46;
            border-color: #10b981;
            color: #ffffff;
        }

        .suspend {
            background: #4c1d2b;
            border-color: #fb7185;
            color: #ffffff;
        }

        .progress-heading {
            display: flex;
            justify-content: space-between;
            gap: 15px;
            margin-bottom: 12px;
        }

        .percent {
            color: #67e8f9;
            font-size: 20px;
            font-weight: 850;
        }

        .track {
            height: 9px;
            background: #30415b;
            border-radius: 999px;
            overflow: hidden;
        }

        .fill {
            height: 100%;
            background: linear-gradient(90deg, #0891b2, #22d3ee);
            border-radius: 999px;
        }

        .detail {
            margin-top: 10px;
            font-size: 12px;
            color: #cbd5e1;
        }

        .phase-list {
            display: grid;
            gap: 13px;
        }

        .phase {
            padding: 18px;
            background: #1d2a40;
            border: 1px solid #334763;
            border-radius: 11px;
        }

        .phase-title {
            font-size: 15px;
            font-weight: 800;
        }

        .phase-week {
            color: #cbd5e1;
            font-size: 12px;
            margin-bottom: 12px;
        }

        .empty {
            color: #cbd5e1;
            font-size: 13px;
        }

        a:focus-visible,
        button:focus-visible {
            outline: 3px solid #67e8f9;
            outline-offset: 3px;
        }

        @media (max-width: 650px) {
            .stats { grid-template-columns: 1fr; }
        }
    </style>
</head>

<body>
<main class="shell">

    <header class="header">
        <a href="{{ route('admin.dashboard') }}" class="brand">
            ◈ NeuralPath Admin
        </a>

        <a href="{{ route('admin.learners.index') }}" class="back">
            ← All Learners
        </a>
    </header>

    @if(session('status'))
        <div class="notice" role="status">
            {{ session('status') }}
        </div>
    @endif

    <div class="eyebrow">Learner Profile</div>

    <h1>{{ $learner->name }}</h1>
    <p class="subtitle">{{ $learner->email }}</p>

    <!-- Account management -->
    <section class="panel" aria-label="Account management">
        <h2>Account Management</h2>

        <div class="account-row">
            <div class="account-info">
                Status:
                <span class="account-status">
                    {{ $learner->isActive() ? 'Active' : 'Suspended' }}
                </span>

                <div>
                    Email:
                    {{ $learner->hasVerifiedEmail() ? 'Verified' : 'Not Verified' }}
                </div>
            </div>

            <form
                method="POST"
                action="{{ route('admin.learners.status', $learner) }}"
            >
                @csrf
                @method('PATCH')

                <input
                    type="hidden"
                    name="is_active"
                    value="{{ $learner->isActive() ? '0' : '1' }}"
                >

                <button
                    type="submit"
                    class="action-button {{ $learner->isActive() ? 'suspend' : 'activate' }}"
                    @if($learner->isActive())
                        onclick="return confirm('Suspend this learner account?')"
                    @endif
                >
                    {{ $learner->isActive() ? 'Suspend Learner' : 'Activate Learner' }}
                </button>
            </form>
        </div>
    </section>

    <!-- Overall progress -->
    <section class="stats" aria-label="Learner statistics">
        <div class="stat">
            <div class="stat-label">Overall Progress</div>
            <div class="stat-value" data-testid="learner-overall-progress">
                {{ $overallProgress['percentage'] }}%
            </div>
        </div>

        <div class="stat">
            <div class="stat-label">Completed Topics</div>
            <div class="stat-value">
                {{ $overallProgress['completed'] }}
            </div>
        </div>

        <div class="stat">
            <div class="stat-label">Published Topics</div>
            <div class="stat-value">
                {{ $overallProgress['total'] }}
            </div>
        </div>
    </section>

    <section class="panel" aria-label="Overall learner progress">
        <div class="progress-heading">
            <h2>Overall Learning Progress</h2>

            <span class="percent">
                {{ $overallProgress['percentage'] }}%
            </span>
        </div>

        <div
            class="track"
            role="progressbar"
            aria-label="Overall learner completion"
            aria-valuemin="0"
            aria-valuemax="100"
            aria-valuenow="{{ $overallProgress['percentage'] }}"
        >
            <div
                class="fill"
                style="width: {{ $overallProgress['percentage'] }}%"
            ></div>
        </div>

        <div class="detail">
            {{ $overallProgress['completed'] }}
            of
            {{ $overallProgress['total'] }}
            currently published topics completed
        </div>
    </section>

    <!-- Phase-by-phase progress -->
    <section class="panel" aria-label="Phase progress report">
        <h2>Learning Phase Progress</h2>

        <div class="phase-list">
            @forelse($branches as $branch)
                @php
                    $phase = $phaseProgress[$branch->id];
                @endphp

                <article class="phase">
                    <div class="progress-heading">
                        <div>
                            <div class="eyebrow">
                                Phase {{ $branch->phase_number }}
                            </div>

                            <div class="phase-title">
                                {{ $branch->title }}
                            </div>

                            <div class="phase-week">
                                Weeks
                                {{ $branch->start_week }}–{{ $branch->end_week }}
                            </div>
                        </div>

                        <span class="percent">
                            {{ $phase['percentage'] }}%
                        </span>
                    </div>

                    <div
                        class="track"
                        role="progressbar"
                        aria-label="Phase {{ $branch->phase_number }} completion"
                        aria-valuemin="0"
                        aria-valuemax="100"
                        aria-valuenow="{{ $phase['percentage'] }}"
                    >
                        <div
                            class="fill"
                            style="width: {{ $phase['percentage'] }}%"
                        ></div>
                    </div>

                    <div class="detail">
                        {{ $phase['completed'] }}
                        of
                        {{ $phase['total'] }}
                        topics completed
                    </div>
                </article>
            @empty
                <p class="empty">
                    No learning phases are published yet.
                </p>
            @endforelse
        </div>
    </section>

</main>
</body>
</html>
