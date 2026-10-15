
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="color-scheme" content="dark">

    <title>{{ $branch->title }} | NeuralPath</title>

    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <style>
        * { box-sizing: border-box; }

        body.np {
            margin: 0;
            background: #080e1e !important;
            color: #ffffff !important;
            min-height: 100vh;
            font-family: Inter, ui-sans-serif, system-ui, sans-serif;
            line-height: 1.6;
        }

        .np a { text-decoration: none; }

        .shell {
            width: min(1050px, calc(100% - 40px));
            margin: auto;
            padding: 40px 0 70px;
        }

        .header {
            display: flex;
            align-items: center;
            justify-content: space-between;
            flex-wrap: wrap;
            gap: 20px;
            margin-bottom: 42px;
        }

        .brand {
            color: #67e8f9 !important;
            font-weight: 800;
            font-size: 16px;
        }

        .back {
            display: inline-flex;
            align-items: center;
            padding: 11px 17px;
            background: #172239;
            border: 1px solid #475569;
            border-radius: 10px;
            color: #ffffff !important;
            font-size: 13px;
            font-weight: 750;
            transition: .2s;
        }

        .back:hover {
            background: #25344e;
            border-color: #22d3ee;
        }

        .eyebrow {
            color: #67e8f9 !important;
            text-transform: uppercase;
            font-size: 12px;
            letter-spacing: 1.2px;
            font-weight: 800;
        }

        h1, h2, h3 {
            color: #ffffff !important;
        }

        h1 {
            font-size: clamp(27px, 4vw, 38px);
            letter-spacing: -.8px;
            line-height: 1.3;
            margin: 10px 0 15px;
        }

        .description {
            color: #cbd5e1 !important;
            font-size: 14px;
            line-height: 1.8;
            max-width: 800px;
        }

        .summary {
            display: flex;
            flex-wrap: wrap;
            gap: 12px;
            margin-top: 24px;
        }

        .summary span {
            padding: 9px 14px;
            background: #1c2b43;
            border: 1px solid #334763;
            border-radius: 9px;
            color: #e2e8f0 !important;
            font-size: 12px;
            font-weight: 700;
        }

        .content-head {
            margin: 45px 0 20px;
            font-size: 22px;
            font-weight: 800;
        }

        .sections {
            display: grid;
            gap: 18px;
        }

        .section {
            padding: 25px;
            background: #131e33;
            border: 1px solid #30415b;
            border-radius: 16px;
            transition: border-color .2s, transform .2s;
        }

        .section:hover {
            border-color: #0891b2;
            transform: translateY(-2px);
        }

        .section h3 {
            margin: 0 0 10px;
            font-size: 19px;
        }

        .section p {
            margin: 0 0 16px;
            color: #cbd5e1 !important;
            font-size: 13px;
        }

        .topics {
            display: grid;
            gap: 10px;
            margin-top: 18px;
        }

        .topic {
            display: flex;
            align-items: flex-start;
            gap: 12px;
            padding: 13px 15px;
            background: #1d2a40;
            border: 1px solid #334763;
            border-radius: 10px;
        }

        .topic-indicator {
            display: inline-block;
            width: 17px;
            height: 17px;
            flex-shrink: 0;
            margin-top: 3px;
            border: 2px solid #94a3b8;
            border-radius: 5px;
        }

        .topic-name {
            color: #ffffff !important;
            font-weight: 700;
            font-size: 13px;
        }

        .topic-meta {
            color: #cbd5e1 !important;
            font-size: 12px;
            margin-top: 3px;
        }

        .empty {
            text-align: center;
            padding: 60px 24px;
            background: #131e33;
            border: 1px dashed #475569;
            border-radius: 16px;
        }

        .empty h3 {
            margin: 0 0 10px;
            font-size: 20px;
        }

        .empty p {
            color: #cbd5e1 !important;
            font-size: 14px;
        }

        .footer {
            margin-top: 50px;
            padding-top: 22px;
            border-top: 1px solid #263349;
            color: #94a3b8 !important;
            font-size: 12px;
            text-align: center;
        }

        @media (max-width: 600px) {
            .shell { width: calc(100% - 28px); }
            .section { padding: 20px; }
        }

        @media (prefers-reduced-motion: reduce) {
            .np * { transition: none !important; }
        }
    </style>
</head>

<body class="np">

<main class="shell">

    <header class="header">
        <div class="brand">◈ NeuralPath</div>

        <a href="{{ route('learner.roadmap.index') }}"
           class="back">
            ← All Learning Phases
        </a>
    </header>

    <section>
        <div class="eyebrow">
            Phase {{ $branch->phase_number }}
            · Weeks {{ $branch->start_week }}–{{ $branch->end_week }}
        </div>

        <h1>{{ $branch->title }}</h1>

        <p class="description">
            {{ $branch->description }}
        </p>

        <div class="summary">
            <span>
                {{ $branch->sections->count() }}
                {{ \Illuminate\Support\Str::plural(
                    'Sub-branch',
                    $branch->sections->count()
                ) }}
            </span>

            <span>
                {{ $branch->sections->sum(
                    fn ($section) => $section->topics->count()
                ) }}
                Published Topics
            </span>

            <span>Learning Phase</span>
        </div>
    </section>

    <h2 class="content-head">
        Learning Modules
    </h2>

    <section class="sections">

        @forelse($branch->sections as $section)

            <article class="section">
                <h3>{{ $section->title }}</h3>

                @if($section->description)
                    <p>{{ $section->description }}</p>
                @endif

                <div class="topics">

                    @forelse($section->topics as $topic)

                        <div class="topic">
                            <span class="topic-indicator"
                                  aria-hidden="true"></span>

                            <div>
                                <div class="topic-name">
                                    {{ $topic->title }}
                                </div>

                                <div class="topic-meta">
                                    @if($topic->target_week)
                                        Week {{ $topic->target_week }}
                                    @endif

                                    @if($topic->estimated_minutes)
                                        · {{ $topic->estimated_minutes }} min
                                    @endif
                                </div>

                                @if($topic->description)
                                    <p style="margin-top:7px;margin-bottom:0">
                                        {{ $topic->description }}
                                    </p>
                                @endif
                            </div>
                        </div>

                    @empty
                        <p>
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
