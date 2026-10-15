
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, initial-scale=1.0">
    <meta name="color-scheme" content="dark">

    <title>Roadmap Management | NeuralPath</title>

    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <style>
        :root {
            color-scheme: dark;
            font-family: Inter, ui-sans-serif, system-ui,
                -apple-system, BlinkMacSystemFont,
                "Segoe UI", sans-serif;
        }

        *,
        *::before,
        *::after {
            box-sizing: border-box;
        }

        html {
            background: #080e1e;
        }

        body.np-page {
            margin: 0;
            min-height: 100vh;
            background: #080e1e !important;
            color: #ffffff !important;
            font-size: 15px;
            line-height: 1.6;
        }

        .np-page h1,
        .np-page h2,
        .np-page h3,
        .np-page p,
        .np-page span,
        .np-page a,
        .np-page button {
            font-family: inherit;
        }

        .np-page h1,
        .np-page h2,
        .np-page h3 {
            color: #ffffff !important;
        }

        .np-page a {
            text-decoration: none;
        }

        .np-shell {
            width: min(1180px, calc(100% - 48px));
            margin: 0 auto;
            padding: 44px 0 55px;
        }

        /* Header */

        .np-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            gap: 30px;
            margin-bottom: 34px;
        }

        .np-brand {
            display: flex;
            align-items: center;
            gap: 9px;
            margin-bottom: 14px;
            color: #22d3ee !important;
            font-size: 14px;
            font-weight: 700;
        }

        .np-brand-icon {
            display: grid;
            place-items: center;
            width: 34px;
            height: 34px;
            border: 1px solid #155e75;
            border-radius: 11px;
            background: #103143;
            color: #67e8f9;
        }

        .np-heading {
            margin: 0;
            font-size: clamp(27px, 4vw, 36px);
            font-weight: 800;
            letter-spacing: -1px;
            line-height: 1.2;
        }

        .np-subtitle {
            margin: 12px 0 0;
            color: #cbd5e1 !important;
            font-size: 14px;
        }

        .np-back {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            gap: 9px;
            flex-shrink: 0;
            padding: 12px 19px;
            border: 1px solid #475569;
            border-radius: 11px;
            background: #172239;
            color: #ffffff !important;
            font-size: 14px;
            font-weight: 650;
            transition: background .2s, border-color .2s,
                        transform .2s;
        }

        .np-back:hover {
            background: #25344e;
            border-color: #22d3ee;
            transform: translateY(-2px);
        }

        /* Flash message */

        .np-notice {
            display: flex;
            align-items: center;
            gap: 12px;
            margin-bottom: 28px;
            padding: 15px 18px;
            border: 1px solid #0f766e;
            border-radius: 12px;
            background: #092e2d;
            color: #a7f3d0 !important;
            font-size: 14px;
            font-weight: 600;
        }

        /* Statistics */

        .np-stats {
            display: grid;
            grid-template-columns: repeat(3, minmax(0, 1fr));
            gap: 18px;
            margin-bottom: 42px;
        }

        .np-stat {
            min-width: 0;
            padding: 24px;
            background: #131e33;
            border: 1px solid #2d3c55;
            border-radius: 16px;
            transition: border-color .2s, transform .2s;
        }

        .np-stat:hover {
            border-color: #0891b2;
            transform: translateY(-3px);
        }

        .np-stat-top {
            display: flex;
            justify-content: space-between;
            align-items: center;
            gap: 10px;
        }

        .np-stat-label {
            color: #cbd5e1 !important;
            font-size: 14px;
            font-weight: 600;
        }

        .np-stat-icon {
            display: grid;
            place-items: center;
            flex-shrink: 0;
            width: 43px;
            height: 43px;
            border-radius: 12px;
            background: #103548;
            color: #67e8f9;
        }

        .np-stat-icon.green {
            background: #103a32;
            color: #6ee7b7;
        }

        .np-stat-icon.purple {
            background: #302147;
            color: #c4b5fd;
        }

        .np-stat-number {
            margin: 14px 0 4px;
            color: #ffffff !important;
            font-size: 36px;
            font-weight: 800;
            line-height: 1.2;
        }

        .np-stat-number.accent {
            color: #67e8f9 !important;
        }

        .np-stat-number .unit {
            font-size: 17px;
            font-weight: 600;
            color: #cbd5e1 !important;
        }

        .np-stat-help {
            margin: 8px 0 0;
            color: #aebed3 !important;
            font-size: 12px;
        }

        /* Section heading */

        .np-section-heading {
            display: flex;
            justify-content: space-between;
            align-items: center;
            gap: 16px;
            margin-bottom: 22px;
        }

        .np-section-title {
            margin: 0;
            font-size: 22px;
            font-weight: 800;
        }

        .np-section-desc {
            margin: 5px 0 0;
            color: #cbd5e1 !important;
            font-size: 13px;
        }

        .np-count {
            flex-shrink: 0;
            display: inline-flex;
            align-items: center;
            padding: 8px 14px;
            background: #1c2b43;
            border: 1px solid #3c506e;
            border-radius: 99px;
            color: #ffffff !important;
            font-size: 12px;
            font-weight: 700;
        }

        /* Branch cards */

        .np-branches {
            display: grid;
            gap: 16px;
        }

        .np-branch {
            display: grid;
            grid-template-columns: minmax(0, 1fr) 165px;
            align-items: center;
            gap: 24px;
            padding: 26px 28px;
            border: 1px solid #30415b;
            border-radius: 16px;
            background: #131e33;
            transition: border-color .2s, box-shadow .2s,
                        transform .2s;
        }

        .np-branch:hover {
            border-color: #0891b2;
            box-shadow: 0 10px 30px #00000030;
            transform: translateY(-2px);
        }

        .np-branch-meta {
            display: flex;
            align-items: center;
            flex-wrap: wrap;
            gap: 10px;
            margin-bottom: 12px;
        }

        .np-phase {
            padding: 5px 11px;
            color: #a5f3fc !important;
            background: #103548;
            border: 1px solid #155e75;
            border-radius: 7px;
            font-size: 12px;
            font-weight: 750;
        }

        .np-weeks {
            color: #cbd5e1 !important;
            font-size: 12px;
            font-weight: 600;
        }

        .np-branch-title {
            margin: 0;
            font-size: 19px;
            font-weight: 750;
            line-height: 1.4;
            overflow-wrap: anywhere;
        }

        .np-branch-description {
            margin: 10px 0 0;
            max-width: 760px;
            color: #cbd5e1 !important;
            font-size: 14px;
            line-height: 1.7;
        }

        .np-section-count {
            display: inline-flex;
            align-items: center;
            gap: 7px;
            margin-top: 17px;
            padding: 7px 11px;
            color: #e2e8f0 !important;
            background: #1e2d45;
            border: 1px solid #334763;
            border-radius: 8px;
            font-size: 12px;
            font-weight: 600;
        }

        /* Publication panel */

        .np-controls {
            display: flex;
            flex-direction: column;
            align-items: stretch;
            gap: 14px;
            width: 165px;
        }

        .np-status {
            display: flex;
            justify-content: center;
            align-items: center;
            gap: 8px;
            min-height: 33px;
            padding: 7px 12px;
            border-radius: 9px;
            font-size: 12px;
            font-weight: 750;
        }

        .np-status.draft {
            color: #e2e8f0 !important;
            background: #263349;
            border: 1px solid #475569;
        }

        .np-status.published {
            color: #a7f3d0 !important;
            background: #103a32;
            border: 1px solid #059669;
        }

        .np-dot {
            width: 8px;
            height: 8px;
            border-radius: 50%;
            background: currentColor;
        }

        .np-controls form {
            margin: 0;
            width: 100%;
        }

        .np-action {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            gap: 9px;
            width: 100%;
            min-height: 44px;
            padding: 10px 15px;
            border-radius: 10px;
            font-size: 14px;
            font-weight: 750;
            cursor: pointer;
            transition: background .2s, transform .2s,
                        box-shadow .2s, border-color .2s;
        }

        .np-action.publish {
            color: #ffffff !important;
            background: #0891b2 !important;
            border: 1px solid #22d3ee;
        }

        .np-action.publish:hover {
            background: #06b6d4 !important;
            box-shadow: 0 5px 22px #06b6d44d;
            transform: translateY(-2px);
        }

        .np-action.unpublish {
            color: #fde68a !important;
            background: #3d2b18 !important;
            border: 1px solid #b45309;
        }

        .np-action.unpublish:hover {
            background: #633c17 !important;
            border-color: #f59e0b;
            box-shadow: 0 5px 20px #f59e0b24;
            transform: translateY(-2px);
        }

        /* Manage modules: available for every roadmap phase */

        .np-manage {
            display: inline-flex;
            justify-content: center;
            align-items: center;
            gap: 8px;
            width: 100%;
            min-height: 44px;
            padding: 10px 13px;
            border: 1px solid #67e8f9;
            border-radius: 10px;
            background: #103548;
            color: #ffffff !important;
            font-size: 13px;
            font-weight: 750;
            text-decoration: none !important;
            text-align: center;
            transition: background .2s, transform .2s,
                        border-color .2s, box-shadow .2s;
        }

        .np-manage:hover {
            background: #15546b;
            border-color: #a5f3fc;
            box-shadow: 0 5px 20px #06b6d433;
            transform: translateY(-2px);
        }

        .np-manage:active {
            transform: scale(.97);
        }

        .np-action:active {
            transform: scale(.97);
        }

        .np-action:focus-visible,
        .np-back:focus-visible,
        .np-manage:focus-visible {
            outline: 3px solid #67e8f9;
            outline-offset: 3px;
        }

        .np-empty {
            padding: 55px 20px;
            border: 1px dashed #475569;
            border-radius: 16px;
            background: #131e33;
            text-align: center;
            color: #cbd5e1 !important;
        }

        .np-footer {
            margin-top: 45px;
            padding-top: 22px;
            border-top: 1px solid #263349;
            color: #94a3b8 !important;
            text-align: center;
            font-size: 12px;
        }

        /* Responsive */

        @media (max-width: 850px) {
            .np-stats {
                grid-template-columns: repeat(2, minmax(0, 1fr));
            }

            .np-stats .np-stat:last-child {
                grid-column: 1 / -1;
            }

            .np-branch {
                grid-template-columns: minmax(0, 1fr);
            }

            .np-controls {
                flex-direction: row;
                align-items: center;
                width: 100%;
                padding-top: 17px;
                border-top: 1px solid #30415b;
            }

            .np-status {
                flex: 1;
            }

            .np-controls form {
                flex: 1;
            }
            .np-controls {
                flex-wrap: wrap;
            }

            .np-manage {
                flex: 1 0 100%;
            }
        }

        @media (max-width: 600px) {
            .np-shell {
                width: calc(100% - 28px);
                padding-top: 26px;
            }

            .np-header {
                flex-direction: column;
                align-items: flex-start;
                gap: 18px;
            }

            .np-stats {
                grid-template-columns: 1fr;
            }

            .np-stats .np-stat:last-child {
                grid-column: auto;
            }

            .np-branch {
                padding: 20px;
            }

            .np-section-heading {
                align-items: flex-start;
                flex-direction: column;
            }

            .np-branch-title {
                font-size: 17px;
            }
            .np-status,
            .np-controls form {
                flex: 1 0 100%;
            }
        }

        @media (prefers-reduced-motion: reduce) {
            .np-page *,
            .np-page *::before,
            .np-page *::after {
                transition: none !important;
            }
        }
    </style>
</head>

<body class="np-page">

<main class="np-shell">

    <!-- HEADER -->

    <header class="np-header">
        <div>
            <div class="np-brand">
                <div class="np-brand-icon">
                    <svg width="20" height="20"
                         viewBox="0 0 24 24" fill="none"
                         stroke="currentColor" stroke-width="1.8"
                         stroke-linecap="round"
                         stroke-linejoin="round">
                        <path d="m12 2 9 5-9 5-9-5 9-5Z"/>
                        <path d="m3 12 9 5 9-5"/>
                        <path d="m3 17 9 5 9-5"/>
                    </svg>
                </div>
                NeuralPath Admin
            </div>

            <h1 class="np-heading">
                Roadmap Management
            </h1>

            <p class="np-subtitle">
                Manage your 60-week Agentic AI learning journey.
            </p>
        </div>

        <a href="{{ route('admin.dashboard') }}"
           class="np-back">
            <svg width="17" height="17"
                 viewBox="0 0 24 24" fill="none"
                 stroke="currentColor" stroke-width="2"
                 stroke-linecap="round"
                 stroke-linejoin="round">
                <path d="m15 18-6-6 6-6"/>
            </svg>
            Back to Dashboard
        </a>
    </header>


    <!-- SUCCESS MESSAGE -->

    @if(session('status'))
        <div class="np-notice" role="status">
            <svg width="20" height="20"
                 viewBox="0 0 24 24" fill="none"
                 stroke="currentColor" stroke-width="2"
                 stroke-linecap="round"
                 stroke-linejoin="round">
                <circle cx="12" cy="12" r="10"/>
                <path d="m8 12 3 3 5-6"/>
            </svg>
            {{ session('status') }}
        </div>
    @endif


    <!-- SUMMARY STATISTICS -->

    <section class="np-stats" aria-label="Roadmap overview">

        <div class="np-stat">
            <div class="np-stat-top">
                <span class="np-stat-label">
                    Total Branches
                </span>

                <span class="np-stat-icon">
                    <svg width="21" height="21"
                         viewBox="0 0 24 24" fill="none"
                         stroke="currentColor" stroke-width="1.8">
                        <rect x="3" y="3" width="7" height="7" rx="1"/>
                        <rect x="14" y="3" width="7" height="7" rx="1"/>
                        <rect x="3" y="14" width="7" height="7" rx="1"/>
                        <rect x="14" y="14" width="7" height="7" rx="1"/>
                    </svg>
                </span>
            </div>

            <p class="np-stat-number">
                {{ $branches->count() }}
            </p>

            <p class="np-stat-help">
                Main learning phases
            </p>
        </div>


        <div class="np-stat">
            <div class="np-stat-top">
                <span class="np-stat-label">
                    Published Branches
                </span>

                <span class="np-stat-icon green">
                    <svg width="21" height="21"
                         viewBox="0 0 24 24" fill="none"
                         stroke="currentColor" stroke-width="1.8"
                         stroke-linecap="round"
                         stroke-linejoin="round">
                        <circle cx="12" cy="12" r="10"/>
                        <path d="m8 12 3 3 5-6"/>
                    </svg>
                </span>
            </div>

            <p class="np-stat-number accent">
                {{ $branches->where('is_published', true)->count() }}
            </p>

            <p class="np-stat-help">
                Branches currently published
            </p>
        </div>


        <div class="np-stat">
            <div class="np-stat-top">
                <span class="np-stat-label">
                    Learning Duration
                </span>

                <span class="np-stat-icon purple">
                    <svg width="21" height="21"
                         viewBox="0 0 24 24" fill="none"
                         stroke="currentColor" stroke-width="1.8"
                         stroke-linecap="round"
                         stroke-linejoin="round">
                        <rect x="3" y="5" width="18" height="16" rx="2"/>
                        <path d="M8 3v4M16 3v4M3 11h18"/>
                    </svg>
                </span>
            </div>

            <p class="np-stat-number">
                60 <span class="unit">Weeks</span>
            </p>

            <p class="np-stat-help">
                From foundations to industry-level AI
            </p>
        </div>

    </section>


    <!-- LEARNING PHASES HEADING -->

    <div class="np-section-heading">
        <div>
            <h2 class="np-section-title">
                Learning Phases
            </h2>
            <p class="np-section-desc">
                Review, publish, or unpublish your roadmap branches.
            </p>
        </div>

        <span class="np-count">
            {{ $branches->count() }} Total Phases
        </span>
    </div>


    <!-- BRANCHES -->

    <section class="np-branches">

        @forelse($branches as $branch)

            <article class="np-branch">

                <div>
                    <div class="np-branch-meta">

                        <span class="np-phase">
                            Phase {{ $branch->phase_number }}
                        </span>

                        <span class="np-weeks">
                            Weeks {{ $branch->start_week }}–{{ $branch->end_week }}
                        </span>

                    </div>

                    <h3 class="np-branch-title">
                        {{ $branch->title }}
                    </h3>

                    <p class="np-branch-description">
                        {{ $branch->description }}
                    </p>

                    <span class="np-section-count">
                        <svg width="15" height="15"
                             viewBox="0 0 24 24" fill="none"
                             stroke="currentColor" stroke-width="1.8"
                             stroke-linecap="round"
                             stroke-linejoin="round">
                            <path d="M3 7h6l2 2h10v11H3z"/>
                            <path d="M3 7V4h6l2 3"/>
                        </svg>

                        {{ $branch->sections_count }}

                        {{ \Illuminate\Support\Str::plural(
                            'Sub-branch',
                            $branch->sections_count
                        ) }}
                    </span>
                </div>


                <!-- PUBLICATION ACTIONS -->

                <div class="np-controls">

                    @if($branch->is_published)

                        <span class="np-status published">
                            <span class="np-dot"></span>
                            Published
                        </span>

                        <form method="POST"
                              action="{{ route('admin.roadmap.publication', $branch) }}"
                              onsubmit="return confirm('Are you sure you want to unpublish this phase?');">

                            @csrf
                            @method('PATCH')

                            <button type="submit"
                                    class="np-action unpublish">
                                <svg width="17" height="17"
                                     viewBox="0 0 24 24" fill="none"
                                     stroke="currentColor" stroke-width="2"
                                     stroke-linecap="round"
                                     stroke-linejoin="round">
                                    <path d="M3 3l18 18"/>
                                    <path d="M10 5.3A10 10 0 0 1 12 5c5 0 9 4 10 7a11 11 0 0 1-3 4"/>
                                    <path d="M6.3 6.3A12 12 0 0 0 2 12c1 3 5 7 10 7 1.6 0 3-.3 4.3-1"/>
                                </svg>
                                Unpublish
                            </button>
                        </form>

                    @else

                        <span class="np-status draft">
                            <span class="np-dot"></span>
                            Draft
                        </span>

                        <form method="POST"
                              action="{{ route('admin.roadmap.publication', $branch) }}">

                            @csrf
                            @method('PATCH')

                            <button type="submit"
                                    class="np-action publish">
                                <svg width="17" height="17"
                                     viewBox="0 0 24 24" fill="none"
                                     stroke="currentColor" stroke-width="2"
                                     stroke-linecap="round"
                                     stroke-linejoin="round">
                                    <path d="M12 16V4"/>
                                    <path d="m7 9 5-5 5 5"/>
                                    <path d="M4 16v4h16v-4"/>
                                </svg>
                                Publish
                            </button>
                        </form>

                    @endif

                    <!-- Navigate to this phase's sections and topics -->
                    <a class="np-manage"
                       href="{{ route('admin.roadmap.sections', $branch) }}"
                       aria-label="Manage modules for {{ $branch->title }}">
                        <svg width="17" height="17"
                             viewBox="0 0 24 24" fill="none"
                             stroke="currentColor" stroke-width="2"
                             stroke-linecap="round" stroke-linejoin="round"
                             aria-hidden="true">
                            <rect x="3" y="3" width="7" height="7" rx="1"/>
                            <rect x="14" y="3" width="7" height="7" rx="1"/>
                            <rect x="3" y="14" width="7" height="7" rx="1"/>
                            <rect x="14" y="14" width="7" height="7" rx="1"/>
                        </svg>
                        Manage Modules
                    </a>

                </div>

            </article>

        @empty

            <div class="np-empty">
                <h3>No roadmap branches found</h3>
                <p>
                    Run the RoadmapBranchSeeder to add your learning phases.
                </p>
            </div>

        @endforelse

    </section>


    <!-- FOOTER -->

    <footer class="np-footer">
        NeuralPath · Agentic AI Engineering Learning Platform
    </footer>

</main>

</body>
</html>
