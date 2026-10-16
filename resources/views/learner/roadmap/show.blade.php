
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="color-scheme" content="dark">

    <title>{{ $branch->title }} | NeuralPath</title>

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
            width: min(1050px, calc(100% - 32px));
            margin: auto;
            padding: 40px 0 70px;
        }

        .header {
            display: flex;
            align-items: center;
            justify-content: space-between;
            flex-wrap: wrap;
            gap: 20px;
            margin-bottom: 40px;
        }

        .brand {
            color: #67e8f9 !important;
            font-size: 16px;
            font-weight: 800;
        }

        .back {
            display: inline-flex;
            align-items: center;
            padding: 11px 18px;
            background: #172239;
            border: 1px solid #475569;
            border-radius: 10px;
            color: #ffffff !important;
            font-size: 13px;
            font-weight: 700;
            transition: .2s;
        }

        .back:hover {
            background: #25344e;
            border-color: #22d3ee;
            transform: translateY(-2px);
        }

        .eyebrow {
            color: #67e8f9 !important;
            font-size: 12px;
            font-weight: 800;
            letter-spacing: 1px;
            text-transform: uppercase;
        }

        h1 {
            margin: 12px 0;
            font-size: clamp(27px, 4vw, 38px);
            line-height: 1.3;
        }

        .description {
            max-width: 800px;
            color: #cbd5e1 !important;
            font-size: 14px;
            line-height: 1.8;
        }

        .summary {
            display: flex;
            flex-wrap: wrap;
            gap: 12px;
            margin: 25px 0 20px;
        }

        .summary-item {
            display: inline-flex;
            align-items: center;
            padding: 9px 14px;
            background: #1c2b43;
            border: 1px solid #334763;
            border-radius: 9px;
            color: #ffffff !important;
            font-size: 12px;
            font-weight: 700;
        }

        /* Phase and module progress */

        .progress-panel {
            margin: 25px 0 38px;
            padding: 22px;
            background: #131e33;
            border: 1px solid #30415b;
            border-radius: 14px;
        }

        .progress-heading {
            display: flex;
            align-items: center;
            justify-content: space-between;
            flex-wrap: wrap;
            gap: 12px;
            margin-bottom: 12px;
        }

        .progress-title {
            margin: 0;
            color: #ffffff !important;
            font-size: 15px;
            font-weight: 800;
        }

        .progress-percent {
            color: #67e8f9 !important;
            font-size: 20px;
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
            transition: width .25s ease;
        }

        .progress-details {
            display: flex;
            align-items: center;
            justify-content: space-between;
            flex-wrap: wrap;
            gap: 8px;
            margin-top: 10px;
            color: #cbd5e1 !important;
            font-size: 12px;
        }

        .progress-complete {
            color: #6ee7b7 !important;
            font-weight: 750;
        }

        .module-progress {
            margin: 18px 0 20px;
            padding: 15px;
            background: #1d2a40;
            border: 1px solid #334763;
            border-radius: 11px;
        }

        .module-progress .progress-title {
            font-size: 13px;
        }

        .module-progress .progress-percent {
            font-size: 16px;
        }

        .module-progress .progress-track {
            height: 7px;
        }

        /* Phase project navigation */
        .project-promo {
            display: flex;
            align-items: center;
            justify-content: space-between;
            flex-wrap: wrap;
            gap: 18px;
            margin: 22px 0 34px;
            padding: 23px;
            background: #131e33;
            border: 1px solid #22d3ee;
            border-radius: 14px;
        }
        .project-promo h2 { margin: 8px 0; font-size: 20px; }
        .project-promo p { margin: 0; color: #cbd5e1; font-size: 13px; line-height: 1.8; }
        .project-cta {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            flex-shrink: 0;
            padding: 12px 18px;
            border: 1px solid #22d3ee;
            border-radius: 9px;
            background: #0891b2;
            color: #ffffff !important;
            font-weight: 800;
            font-size: 13px;
        }
        .project-cta:hover { background: #0e7490; }
        .project-cta:focus-visible { outline: 3px solid #67e8f9; outline-offset: 3px; }

        /* Learning modules */

        .section-title {
            margin: 0 0 20px;
            font-size: 22px;
            font-weight: 800;
        }

        .sections {
            display: grid;
            gap: 20px;
        }

        .section-card {
            padding: 25px;
            background: #131e33;
            border: 1px solid #30415b;
            border-radius: 16px;
            transition: border-color .2s, transform .2s;
        }

        .section-card:hover {
            border-color: #0891b2;
            transform: translateY(-2px);
        }

        .section-name {
            margin: 0 0 8px;
            font-size: 20px;
            font-weight: 800;
        }

        .section-description {
            margin: 0 0 20px;
            color: #cbd5e1 !important;
            font-size: 13px;
            line-height: 1.8;
        }

        /* Learning topics */

        .topics {
            display: grid;
            gap: 12px;
            margin-top: 20px;
        }

        .topic {
            display: flex;
            align-items: flex-start;
            gap: 13px;
            padding: 17px;
            background: #1d2a40;
            border: 1px solid #334763;
            border-radius: 12px;
            transition: border-color .2s;
        }

        .topic.is-completed {
            border-color: #155e75;
        }

        .topic-completion-form {
            flex-shrink: 0;
            margin: 0;
            padding: 0;
        }

        .topic-indicator {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            width: 25px;
            height: 25px;
            margin: 0;
            padding: 0;
            background: #131e33;
            border: 2px solid #64748b;
            border-radius: 7px;
            color: transparent;
            font-size: 15px;
            font-weight: 900;
            cursor: pointer;
            transition: background .2s,
                        border-color .2s,
                        transform .2s;
        }

        .topic-indicator:hover {
            border-color: #22d3ee;
            background: #15384b;
            transform: scale(1.08);
        }

        .topic-indicator.completed {
            background: #0891b2;
            border-color: #22d3ee;
            color: #ffffff;
        }

        .topic-indicator.completed:hover {
            background: #0e7490;
        }

        .topic-indicator:focus-visible {
            outline: 3px solid #67e8f9;
            outline-offset: 3px;
        }

        .topic-body {
            flex: 1;
            min-width: 0;
        }

        .topic-name {
            margin: 0;
            color: #ffffff !important;
            font-size: 15px;
            font-weight: 800;
            line-height: 1.5;
        }

        .topic.is-completed .topic-name {
            color: #a5f3fc !important;
        }

        .topic-completion-state {
            display: inline-flex;
            align-items: center;
            gap: 5px;
            margin-top: 7px;
            color: #6ee7b7 !important;
            font-size: 12px;
            font-weight: 700;
        }

        .topic-meta {
            margin-top: 5px;
            color: #cbd5e1 !important;
            font-size: 12px;
        }

        .topic-description {
            margin: 10px 0 0;
            color: #cbd5e1 !important;
            font-size: 13px;
            line-height: 1.8;
        }

        /* Learning resources */

        .resources {
            display: grid;
            gap: 10px;
            margin-top: 18px;
            padding-top: 17px;
            border-top: 1px solid #334763;
        }

        .resources-heading {
            color: #cbd5e1 !important;
            font-size: 12px;
            font-weight: 800;
        }

        .resource-link {
            display: flex;
            align-items: center;
            gap: 12px;
            padding: 13px 14px;
            background: #131e33;
            border: 1px solid #405574;
            border-radius: 10px;
            color: #ffffff !important;
            transition: background .2s,
                        border-color .2s,
                        transform .2s;
        }

        .resource-link:hover {
            background: #1e3650;
            border-color: #22d3ee;
            transform: translateY(-2px);
        }

        .resource-icon {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            flex-shrink: 0;
            width: 36px;
            height: 36px;
            background: #103548;
            border-radius: 9px;
            color: #67e8f9 !important;
            font-size: 17px;
            font-weight: 800;
        }

        .resource-info {
            display: flex;
            flex-direction: column;
            flex: 1;
            min-width: 0;
            gap: 3px;
        }

        .resource-title {
            color: #ffffff !important;
            font-size: 13px;
            font-weight: 750;
            overflow-wrap: anywhere;
        }

        .resource-type {
            color: #a5f3fc !important;
            font-size: 11px;
            text-transform: capitalize;
        }

        .resource-arrow {
            color: #67e8f9 !important;
            font-size: 18px;
        }

        .resource-link:focus-visible,
        .back:focus-visible {
            outline: 3px solid #67e8f9;
            outline-offset: 3px;
        }

        /* Notifications and empty states */

        .notice {
            padding: 14px 18px;
            margin-bottom: 24px;
            background: #103a32;
            border: 1px solid #059669;
            border-radius: 10px;
            color: #a7f3d0 !important;
            font-size: 13px;
            font-weight: 700;
        }

        .empty {
            padding: 50px 24px;
            background: #131e33;
            border: 1px dashed #475569;
            border-radius: 16px;
            text-align: center;
        }

        .empty h3 {
            margin: 0 0 10px;
            font-size: 20px;
        }

        .empty p {
            margin: 0;
            color: #cbd5e1 !important;
            font-size: 14px;
        }

        .footer {
            margin-top: 50px;
            padding-top: 22px;
            border-top: 1px solid #263349;
            color: #94a3b8 !important;
            text-align: center;
            font-size: 12px;
        }

        @media (max-width: 600px) {
            .shell {
                width: calc(100% - 28px);
            }

            .header {
                margin-bottom: 30px;
            }

            .section-card {
                padding: 20px;
            }

            .topic {
                padding: 13px;
            }

            .resource-link {
                padding: 12px;
            }

            .progress-panel {
                padding: 18px;
            }

            .module-progress {
                padding: 12px;
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

    @if(session('status'))
        <div class="notice" role="status">
            {{ session('status') }}
        </div>
    @endif

    <!-- Header -->
    <header class="header">
@if(auth()->user()->isAdmin())
    <a
        href="{{ route('admin.dashboard') }}"
        class="back"
    >
        ← Admin View
    </a>
@endif

        <div class="brand">
            ◈ NeuralPath
        </div>

        <a
            href="{{ route('learner.roadmap.index') }}"
            class="back"
        >
            ← All Learning Phases
        </a>
    </header>

    <!-- Phase overview -->
    <section aria-label="Learning phase overview">

        <div class="eyebrow">
            Phase {{ $branch->phase_number }}
            · Weeks {{ $branch->start_week }}–{{ $branch->end_week }}
        </div>

        <h1>{{ $branch->title }}</h1>

        @if($branch->description)
            <p class="description">
                {{ $branch->description }}
            </p>
        @endif

        <div class="summary">
            <span class="summary-item">
                {{ $branch->sections->count() }}
                {{ \Illuminate\Support\Str::plural(
                    'Sub-branch',
                    $branch->sections->count()
                ) }}
            </span>

            <span class="summary-item">
                {{ $phaseProgress['total'] }} Published Topics
            </span>

            <span class="summary-item">
                {{ $phaseProgress['completed'] }} Completed
            </span>
        </div>

    </section>

    <!-- Overall phase progress -->
    <section
        class="progress-panel"
        aria-label="Phase learning progress"
    >
        <div class="progress-heading">
            <h2 class="progress-title">
                Phase {{ $branch->phase_number }} Progress
            </h2>

            <span
                class="progress-percent"
                data-testid="phase-percentage"
            >{{ $phaseProgress['percentage'] }}%</span>
        </div>

        <div
            class="progress-track"
            role="progressbar"
            aria-label="Phase completion"
            aria-valuemin="0"
            aria-valuemax="100"
            aria-valuenow="{{ $phaseProgress['percentage'] }}"
        >
            <div
                class="progress-fill"
                style="width: {{ $phaseProgress['percentage'] }}%"
            ></div>
        </div>

        <div class="progress-details">
            <span data-testid="phase-progress-count">
                {{ $phaseProgress['completed'] }}
                of
                {{ $phaseProgress['total'] }}
                published topics completed
            </span>

            @if(
                $phaseProgress['total'] > 0 &&
                $phaseProgress['completed'] === $phaseProgress['total']
            )
                <span class="progress-complete">
                    ✓ Phase Completed
                </span>
            @endif
        </div>
    </section>

    <!-- Phase projects: separate from topic progress -->
    <section class="project-promo" aria-label="Recommended phase projects">
        <div>
            <div class="eyebrow">APPLY WHAT YOU LEARN</div>
            <h2>Recommended Projects</h2>
            <p>Explore five practical project recommendations for Phase {{ $branch->phase_number }}.
               Projects do not change your topic completion percentage.</p>
        </div>
        <a class="project-cta" href="{{ route('learner.projects.index', $branch) }}">
            Explore Projects →
        </a>
    </section>

    <!-- Published modules -->
    <h2 class="section-title">
        Learning Modules
    </h2>

    <section
        class="sections"
        aria-label="Published learning modules"
    >
        @forelse($branch->sections as $section)

            <article class="section-card">

                <h3 class="section-name">
                    {{ $section->title }}
                </h3>

                @if($section->description)
                    <p class="section-description">
                        {{ $section->description }}
                    </p>
                @endif

                @php
                    $progress = $sectionProgress[$section->id];
                @endphp

                <!-- Individual module progress -->
                <div
                    class="module-progress"
                    aria-label="{{ $section->title }} learning progress"
                >
                    <div class="progress-heading">
                        <span class="progress-title">
                            Module Progress
                        </span>

                        <span class="progress-percent">
                            {{ $progress['percentage'] }}%
                        </span>
                    </div>

                    <div
                        class="progress-track"
                        role="progressbar"
                        aria-label="{{ $section->title }} completion"
                        aria-valuemin="0"
                        aria-valuemax="100"
                        aria-valuenow="{{ $progress['percentage'] }}"
                    >
                        <div
                            class="progress-fill"
                            style="width: {{ $progress['percentage'] }}%"
                        ></div>
                    </div>

                    <div class="progress-details">
                        <span>
                            {{ $progress['completed'] }}
                            of
                            {{ $progress['total'] }}
                            topics completed
                        </span>

                        @if(
                            $progress['total'] > 0 &&
                            $progress['completed'] === $progress['total']
                        )
                            <span class="progress-complete">
                                ✓ Module Completed
                            </span>
                        @endif
                    </div>
                </div>

                <!-- Published topics -->
                <div class="topics">

                    @forelse($section->topics as $topic)

                        @php
                            $isCompleted = in_array(
                                (int) $topic->id,
                                $completedTopicIds,
                                true
                            );
                        @endphp

                        <div class="topic {{ $isCompleted ? 'is-completed' : '' }}">

                            <!-- Learner completion form -->
                            <form
                                class="topic-completion-form"
                                method="POST"
                                action="{{ $isCompleted
                                    ? route('learner.topics.incomplete', $topic)
                                    : route('learner.topics.complete', $topic) }}"
                            >
                                @csrf
                                @method($isCompleted ? 'DELETE' : 'PUT')

                                <button
                                    type="submit"
                                    class="topic-indicator {{ $isCompleted ? 'completed' : '' }}"
                                    aria-label="{{ $isCompleted
                                        ? 'Mark ' . $topic->title . ' as incomplete'
                                        : 'Mark ' . $topic->title . ' as complete' }}"
                                    aria-pressed="{{ $isCompleted ? 'true' : 'false' }}"
                                    title="{{ $isCompleted
                                        ? 'Mark as incomplete'
                                        : 'Mark as complete' }}"
                                >
                                    @if($isCompleted)
                                        <span aria-hidden="true">✓</span>
                                    @endif
                                </button>
                            </form>

                            <div class="topic-body">

                                <!-- Topic title -->
                                <div class="topic-name">
                                    {{ $topic->title }}
                                </div>

                                @if($isCompleted)
                                    <span class="topic-completion-state">
                                        ✓ Completed
                                    </span>
                                @endif

                                <!-- Topic study details -->
                                <div class="topic-meta">
                                    @if($topic->target_week)
                                        Week {{ $topic->target_week }}
                                    @endif

                                    @if($topic->estimated_minutes)
                                        @if($topic->target_week)
                                            ·
                                        @endif

                                        {{ $topic->estimated_minutes }} min
                                    @endif
                                </div>

                                @if($topic->description)
                                    <p class="topic-description">
                                        {{ $topic->description }}
                                    </p>
                                @endif

                                <!-- Published learning resources -->
                                @if($topic->resources->isNotEmpty())

                                    <div class="resources">

                                        <div class="resources-heading">
                                            Learning Resources
                                        </div>

                                        @foreach($topic->resources as $resource)

                                            <a
                                                class="resource-link"
                                                href="{{ $resource->url }}"
                                                target="_blank"
                                                rel="noopener noreferrer"
                                            >
                                                <span
                                                    class="resource-icon"
                                                    aria-hidden="true"
                                                >
                                                    {{ $resource->type === 'youtube' ? '▶' : '↗' }}
                                                </span>

                                                <span class="resource-info">
                                                    <span class="resource-title">
                                                        {{ $resource->title }}
                                                    </span>

                                                    <span class="resource-type">
                                                        {{ $resource->type }}
                                                    </span>
                                                </span>

                                                <span
                                                    class="resource-arrow"
                                                    aria-hidden="true"
                                                >
                                                    ↗
                                                </span>
                                            </a>

                                        @endforeach

                                    </div>

                                @endif

                            </div>
                        </div>

                    @empty

                        <p class="section-description">
                            Topics for this module are being prepared.
                        </p>

                    @endforelse

                </div>

            </article>

        @empty

            <div class="empty">
                <h3>Learning modules are coming soon</h3>

                <p>
                    This learning phase has been published,
                    but its sub-branches and topics are still
                    being prepared.
                </p>
            </div>

        @endforelse
    </section>

    <footer class="footer">
        NeuralPath · Agentic AI Engineering Learning Platform
    </footer>

</main>

</body>
</html>
