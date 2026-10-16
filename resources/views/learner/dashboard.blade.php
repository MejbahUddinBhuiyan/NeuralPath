
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="color-scheme" content="dark">

    <title>My Dashboard | NeuralPath</title>

    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <style>
        * {
            box-sizing: border-box;
        }

        body.np {
            margin: 0;
            min-height: 100vh;
            background: #080e1e !important;
            color: #ffffff !important;
            font-family: Inter, ui-sans-serif, system-ui, sans-serif;
            line-height: 1.6;
        }

        .np h1,
        .np h2,
        .np h3 {
            color: #ffffff !important;
        }

        .np a {
            text-decoration: none;
        }

        .shell {
            width: min(1120px, calc(100% - 32px));
            margin: auto;
            padding: 35px 0 70px;
        }

        .header {
            display: flex;
            align-items: center;
            justify-content: space-between;
            flex-wrap: wrap;
            gap: 20px;
            margin-bottom: 48px;
        }

        .brand {
            color: #67e8f9 !important;
            font-size: 19px;
            font-weight: 850;
        }

        .header-actions {
            display: flex;
            align-items: center;
            flex-wrap: wrap;
            gap: 12px;
        }

        .nav-link,
        .logout-button {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            min-height: 43px;
            padding: 10px 16px;
            background: #172239;
            border: 1px solid #475569;
            border-radius: 10px;
            color: #ffffff !important;
            font-family: inherit;
            font-size: 13px;
            font-weight: 700;
            cursor: pointer;
            transition: background .2s, border-color .2s;
        }

        .nav-link:hover,
        .logout-button:hover {
            background: #25344e;
            border-color: #22d3ee;
        }

        .eyebrow {
            color: #67e8f9 !important;
            font-size: 12px;
            font-weight: 800;
            letter-spacing: 1px;
            text-transform: uppercase;
        }

        .page-title {
            margin: 12px 0;
            font-size: clamp(27px, 4vw, 38px);
            line-height: 1.25;
        }

        .intro {
            max-width: 720px;
            color: #cbd5e1 !important;
            font-size: 14px;
            line-height: 1.8;
        }

        .stats {
            display: grid;
            grid-template-columns: repeat(3, minmax(0, 1fr));
            gap: 17px;
            margin: 32px 0;
        }

        .stat-card {
            min-width: 0;
            padding: 24px;
            background: #131e33;
            border: 1px solid #30415b;
            border-radius: 15px;
        }

        .stat-label {
            margin: 0;
            color: #cbd5e1 !important;
            font-size: 13px;
            font-weight: 700;
        }

        .stat-value {
            margin: 12px 0 4px;
            color: #ffffff !important;
            font-size: clamp(25px, 3vw, 35px);
            font-weight: 850;
            line-height: 1.2;
        }

        .stat-value.accent {
            color: #67e8f9 !important;
        }

        .stat-caption {
            color: #94a3b8 !important;
            font-size: 12px;
        }

        .panel {
            padding: 25px;
            margin-bottom: 22px;
            background: #131e33;
            border: 1px solid #30415b;
            border-radius: 16px;
        }

        .panel-header {
            display: flex;
            align-items: center;
            justify-content: space-between;
            flex-wrap: wrap;
            gap: 12px;
            margin-bottom: 16px;
        }

        .panel-title {
            margin: 0;
            font-size: 19px;
            font-weight: 800;
        }

        .panel-subtitle {
            margin: 0 0 20px;
            color: #cbd5e1 !important;
            font-size: 13px;
            line-height: 1.7;
        }

        .percentage {
            color: #67e8f9 !important;
            font-size: 21px;
            font-weight: 800;
        }

        .progress-track {
            width: 100%;
            height: 10px;
            overflow: hidden;
            background: #30415b;
            border-radius: 999px;
        }

        .progress-fill {
            height: 100%;
            background: linear-gradient(90deg, #0891b2, #22d3ee);
            border-radius: 999px;
            transition: width .2s ease;
        }

        .progress-details {
            display: flex;
            align-items: center;
            justify-content: space-between;
            flex-wrap: wrap;
            gap: 10px;
            margin-top: 11px;
            color: #cbd5e1 !important;
            font-size: 12px;
        }

        .current-phase {
            display: inline-flex;
            align-items: center;
            padding: 5px 10px;
            background: #103548;
            border: 1px solid #155e75;
            border-radius: 7px;
            color: #a5f3fc !important;
            font-size: 11px;
            font-weight: 800;
        }

        .current-title {
            margin: 13px 0 8px;
            font-size: 19px;
            font-weight: 800;
        }

        .current-description {
            color: #cbd5e1 !important;
            font-size: 13px;
            line-height: 1.8;
        }

        .next-topic {
            margin: 18px 0;
            padding: 16px;
            background: #1d2a40;
            border: 1px solid #334763;
            border-radius: 11px;
        }

        .next-label {
            color: #67e8f9 !important;
            font-size: 11px;
            font-weight: 800;
            letter-spacing: .6px;
            text-transform: uppercase;
        }

        .next-name {
            margin: 7px 0 4px;
            color: #ffffff !important;
            font-size: 15px;
            font-weight: 800;
        }

        .next-meta {
            color: #cbd5e1 !important;
            font-size: 12px;
        }

        .primary-button {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            gap: 9px;
            margin-top: 20px;
            padding: 12px 19px;
            background: #0891b2;
            border: 1px solid #22d3ee;
            border-radius: 10px;
            color: #ffffff !important;
            font-size: 13px;
            font-weight: 800;
            transition: background .2s, transform .2s;
        }

        .primary-button:hover {
            background: #0e7490;
            transform: translateY(-2px);
        }

        .phase-list {
            display: grid;
            gap: 13px;
        }

        .phase-card {
            padding: 19px;
            background: #1d2a40;
            border: 1px solid #334763;
            border-radius: 12px;
            transition: border-color .2s, transform .2s;
        }

        .phase-card:hover {
            border-color: #22d3ee;
            transform: translateY(-2px);
        }

        .phase-top {
            display: flex;
            align-items: flex-start;
            justify-content: space-between;
            gap: 16px;
            margin-bottom: 14px;
        }

        .phase-name {
            margin: 4px 0;
            color: #ffffff !important;
            font-size: 15px;
            font-weight: 800;
        }

        .phase-weeks {
            color: #cbd5e1 !important;
            font-size: 12px;
        }

        .phase-percent {
            color: #67e8f9 !important;
            font-size: 17px;
            font-weight: 800;
            white-space: nowrap;
        }

        .phase-card .progress-track {
            height: 7px;
        }

        .phase-link {
            display: inline-flex;
            margin-top: 13px;
            color: #67e8f9 !important;
            font-size: 12px;
            font-weight: 750;
        }

        .complete-label {
            color: #6ee7b7 !important;
            font-size: 12px;
            font-weight: 750;
        }

        .empty {
            padding: 24px;
            background: #1d2a40;
            border: 1px dashed #475569;
            border-radius: 11px;
            color: #cbd5e1 !important;
            font-size: 13px;
            line-height: 1.8;
        }

        .footer {
            padding-top: 25px;
            margin-top: 46px;
            border-top: 1px solid #263349;
            color: #94a3b8 !important;
            text-align: center;
            font-size: 12px;
        }

        .nav-link:focus-visible,
        .logout-button:focus-visible,
        .primary-button:focus-visible,
        .phase-link:focus-visible {
            outline: 3px solid #67e8f9;
            outline-offset: 3px;
        }

        @media (max-width: 750px) {
            .stats {
                grid-template-columns: 1fr;
            }

            .panel {
                padding: 19px;
            }

            .stat-card {
                padding: 19px;
            }
        }

        @media (prefers-reduced-motion: reduce) {
            .np * {
                transition: none !important;
            }
        }
    </style>
</head>

<body class="np">

<main class="shell">

    <header class="header">

        <a
            href="{{ route('learner.dashboard') }}"
            class="brand"
        >
            ◈ NeuralPath
        </a>

        <div class="header-actions">

            <a
                href="{{ route('learner.roadmap.index') }}"
                class="nav-link"
            >
                Learning Roadmap
            </a>

            <form
                method="POST"
                action="{{ route('logout') }}"
            >
                @csrf

                <button
                    type="submit"
                    class="logout-button"
                >
                    Logout
                </button>
            </form>

        </div>

    </header>

    <!-- Introduction -->

    <section aria-label="Learner overview">

        <div class="eyebrow">
            My Learning Dashboard
        </div>

        <h1 class="page-title">
            Welcome back, {{ auth()->user()->name }}!
        </h1>

        <p class="intro">
            Follow your Agentic AI Engineering roadmap,
            complete learning topics, and track your
            progress toward your goals.
        </p>

    </section>

    <!-- Real progress statistics -->

    <section class="stats" aria-label="Learning statistics">

        <article class="stat-card">
            <p class="stat-label">Overall Progress</p>

            <p
                class="stat-value accent"
                data-testid="overall-percentage"
            >{{ $overallProgress['percentage'] }}%</p>

            <p class="stat-caption">
                Across all published learning topics
            </p>
        </article>

        <article class="stat-card">
            <p class="stat-label">Topics Completed</p>

            <p
                class="stat-value"
                data-testid="completed-topics"
            >{{ $overallProgress['completed'] }}</p>

            <p class="stat-caption">
                Out of {{ $overallProgress['total'] }}
                published topics
            </p>
        </article>

        <article class="stat-card">
            <p class="stat-label">Available Phases</p>

            <p class="stat-value">
                {{ $branches->count() }}
            </p>

            <p class="stat-caption">
                Published roadmap phases
            </p>
        </article>

    </section>

    <!-- Overall progress bar -->

    <section
        class="panel"
        aria-label="Overall learning progress"
    >
        <div class="panel-header">
            <h2 class="panel-title">
                Your Overall Progress
            </h2>

            <span class="percentage">
                {{ $overallProgress['percentage'] }}%
            </span>
        </div>

        <div
            class="progress-track"
            role="progressbar"
            aria-label="Overall completion"
            aria-valuemin="0"
            aria-valuemax="100"
            aria-valuenow="{{ $overallProgress['percentage'] }}"
        >
            <div
                class="progress-fill"
                style="width: {{ $overallProgress['percentage'] }}%"
            ></div>
        </div>

        <div class="progress-details">
            <span>
                {{ $overallProgress['completed'] }}
                of
                {{ $overallProgress['total'] }}
                published topics completed
            </span>

            @if(
                $overallProgress['total'] > 0 &&
                $overallProgress['completed'] === $overallProgress['total']
            )
                <span class="complete-label">
                    ✓ All Available Topics Completed
                </span>
            @endif
        </div>
    </section>

    <!-- Continue learning -->

    <section
        class="panel"
        aria-label="Continue learning"
    >

        <div class="panel-header">
            <h2 class="panel-title">
                Continue Learning
            </h2>
        </div>

        @if($currentBranch)

            @php
                $currentProgress = $phaseProgress[$currentBranch->id];
            @endphp

            <span class="current-phase">
                PHASE {{ $currentBranch->phase_number }}
                · WEEKS
                {{ $currentBranch->start_week }}–{{ $currentBranch->end_week }}
            </span>

            <h3 class="current-title">
                {{ $currentBranch->title }}
            </h3>

            @if($currentBranch->description)
                <p class="current-description">
                    {{ $currentBranch->description }}
                </p>
            @endif

            @if($nextTopic)

                <div class="next-topic">
                    <div class="next-label">
                        Next Learning Topic
                    </div>

                    <div class="next-name">
                        {{ $nextTopic->title }}
                    </div>

                    <div class="next-meta">
                        @if($nextTopic->target_week)
                            Week {{ $nextTopic->target_week }}
                        @endif

                        @if($nextTopic->estimated_minutes)
                            @if($nextTopic->target_week)
                                ·
                            @endif

                            {{ $nextTopic->estimated_minutes }} min
                        @endif
                    </div>
                </div>

            @elseif($overallProgress['total'] > 0 &&
                    $overallProgress['completed'] === $overallProgress['total'])

                <p class="current-description">
                    You've completed every topic currently
                    published in the learning roadmap.
                    New lessons will appear when more
                    topics are published.
                </p>

            @else

                <p class="current-description">
                    This learning phase is published,
                    but its learning topics are still
                    being prepared.
                </p>

            @endif

            <div class="panel-header">
                <span class="stat-label">
                    Current Phase Progress
                </span>

                <span class="percentage">
                    {{ $currentProgress['percentage'] }}%
                </span>
            </div>

            <div
                class="progress-track"
                role="progressbar"
                aria-label="Current phase completion"
                aria-valuemin="0"
                aria-valuemax="100"
                aria-valuenow="{{ $currentProgress['percentage'] }}"
            >
                <div
                    class="progress-fill"
                    style="width: {{ $currentProgress['percentage'] }}%"
                ></div>
            </div>

            <a
                class="primary-button"
                href="{{ route('learner.roadmap.show', $currentBranch) }}"
            >
                Continue Learning →
            </a>

        @else

            <div class="empty">
                No learning phases have been published yet.
                Once a phase is available, it will appear here.
            </div>

            <a
                class="primary-button"
                href="{{ route('learner.roadmap.index') }}"
            >
                Explore Learning Roadmap →
            </a>

        @endif

    </section>

    <!-- Published phase summaries -->

    <section
        class="panel"
        aria-label="Published roadmap phases"
    >

        <div class="panel-header">
            <h2 class="panel-title">
                Learning Phases
            </h2>
        </div>

        <p class="panel-subtitle">
            Progress is calculated using published topics
            only. Draft lessons do not affect your percentage.
        </p>

        <div class="phase-list">

            @forelse($branches as $branch)

                @php
                    $phase = $phaseProgress[$branch->id];
                @endphp

                <article class="phase-card">

                    <div class="phase-top">

                        <div>
                            <div class="eyebrow">
                                Phase {{ $branch->phase_number }}
                            </div>

                            <h3 class="phase-name">
                                {{ $branch->title }}
                            </h3>

                            <div class="phase-weeks">
                                Weeks
                                {{ $branch->start_week }}–{{ $branch->end_week }}
                            </div>
                        </div>

                        <span class="phase-percent">
                            {{ $phase['percentage'] }}%
                        </span>

                    </div>

                    <div
                        class="progress-track"
                        role="progressbar"
                        aria-label="Phase {{ $branch->phase_number }} completion"
                        aria-valuemin="0"
                        aria-valuemax="100"
                        aria-valuenow="{{ $phase['percentage'] }}"
                    >
                        <div
                            class="progress-fill"
                            style="width: {{ $phase['percentage'] }}%"
                        ></div>
                    </div>

                    <div class="progress-details">
                        <span>
                            {{ $phase['completed'] }}
                            of
                            {{ $phase['total'] }}
                            topics completed
                        </span>

                        @if(
                            $phase['total'] > 0 &&
                            $phase['completed'] === $phase['total']
                        )
                            <span class="complete-label">
                                ✓ Completed
                            </span>
                        @endif
                    </div>

                    <a
                        href="{{ route('learner.roadmap.show', $branch) }}"
                        class="phase-link"
                    >
                        Open Phase →
                    </a>

                </article>

            @empty

                <div class="empty">
                    The roadmap is being prepared.
                    Published learning phases will appear here.
                </div>

            @endforelse

        </div>

    </section>

    <footer class="footer">
        NeuralPath · Agentic AI Engineering Learning Platform
    </footer>

</main>

</body>
</html>
