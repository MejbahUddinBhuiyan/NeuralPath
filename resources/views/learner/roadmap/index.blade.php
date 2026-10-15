
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="color-scheme" content="dark">
    <title>Learning Roadmap | NeuralPath</title>

    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <style>
        * { box-sizing: border-box; }

        body.np {
            margin: 0;
            min-height: 100vh;
            background: #080e1e !important;
            color: #fff !important;
            font-family: Inter, ui-sans-serif, system-ui, sans-serif;
            line-height: 1.6;
        }

        .np a { text-decoration: none; }

        .shell {
            width: min(1180px, calc(100% - 40px));
            margin: auto;
            padding: 40px 0 70px;
        }

        .topbar {
            display: flex;
            justify-content: space-between;
            align-items: center;
            flex-wrap: wrap;
            gap: 18px;
            margin-bottom: 40px;
        }

        .brand {
            color: #67e8f9 !important;
            font-size: 16px;
            font-weight: 800;
            letter-spacing: .3px;
        }

        .navlinks {
            display: flex;
            flex-wrap: wrap;
            align-items: center;
            gap: 12px;
        }

        .navlink {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            padding: 10px 17px;
            border: 1px solid #475569;
            border-radius: 10px;
            background: #172239;
            color: #fff !important;
            font-size: 13px;
            font-weight: 700;
            transition: .2s ease;
        }

        .navlink:hover {
            border-color: #22d3ee;
            background: #25344e;
            transform: translateY(-2px);
        }

        .eyebrow {
            color: #67e8f9 !important;
            font-weight: 750;
            font-size: 12px;
            letter-spacing: 1.5px;
            text-transform: uppercase;
        }

        .hero h1 {
            color: #fff !important;
            font-size: clamp(28px, 4vw, 40px);
            line-height: 1.2;
            margin: 10px 0;
            letter-spacing: -.8px;
        }

        .muted {
            color: #cbd5e1 !important;
            font-size: 14px;
        }

        .hero {
            margin-bottom: 32px;
        }

        .stats {
            display: grid;
            grid-template-columns: repeat(3, minmax(0, 1fr));
            gap: 18px;
            margin: 30px 0 44px;
        }

        .stat {
            padding: 23px;
            border-radius: 16px;
            border: 1px solid #30415b;
            background: #131e33;
        }

        .stat-label {
            color: #cbd5e1 !important;
            font-size: 13px;
            font-weight: 600;
        }

        .stat-value {
            margin: 8px 0 3px;
            font-size: 34px;
            color: #fff !important;
            font-weight: 800;
            line-height: 1.3;
        }

        .stat-value.cyan { color: #67e8f9 !important; }

        .stat-note {
            color: #aebed3 !important;
            font-size: 12px;
        }

        .section-header {
            display: flex;
            align-items: center;
            justify-content: space-between;
            flex-wrap: wrap;
            gap: 12px;
            margin: 0 0 20px;
        }

        .section-title {
            color: #fff !important;
            margin: 0;
            font-size: 22px;
            font-weight: 800;
        }

        .pill {
            display: inline-block;
            border-radius: 999px;
            border: 1px solid #475569;
            background: #1e2d45;
            color: #e2e8f0 !important;
            padding: 7px 13px;
            font-size: 12px;
            font-weight: 700;
        }

        .phases {
            display: grid;
            grid-template-columns: repeat(2, minmax(0, 1fr));
            gap: 18px;
        }

        .phase-card {
            display: flex;
            flex-direction: column;
            gap: 14px;
            padding: 25px;
            border-radius: 17px;
            border: 1px solid #30415b;
            background: #131e33;
            transition: border-color .2s, transform .2s,
                        box-shadow .2s;
        }

        .phase-card:hover {
            border-color: #22d3ee;
            transform: translateY(-3px);
            box-shadow: 0 12px 30px #00000040;
        }

        .phase-head {
            display: flex;
            justify-content: space-between;
            flex-wrap: wrap;
            gap: 10px;
            align-items: center;
        }

        .phase-label {
            color: #a5f3fc !important;
            background: #103548;
            border: 1px solid #155e75;
            padding: 6px 11px;
            border-radius: 8px;
            font-size: 12px;
            font-weight: 750;
        }

        .weeks {
            color: #cbd5e1 !important;
            font-size: 12px;
            font-weight: 600;
        }

        .phase-title {
            margin: 0;
            color: #fff !important;
            font-size: 20px;
            line-height: 1.4;
            font-weight: 800;
        }

        .phase-desc {
            color: #cbd5e1 !important;
            margin: 0;
            font-size: 13px;
            line-height: 1.8;
            flex: 1;
        }

        .phase-footer {
            display: flex;
            align-items: center;
            justify-content: space-between;
            flex-wrap: wrap;
            gap: 12px;
            padding-top: 15px;
            border-top: 1px solid #30415b;
        }

        .section-count {
            color: #cbd5e1 !important;
            font-size: 12px;
            font-weight: 650;
        }

        .explore {
            display: inline-flex;
            align-items: center;
            gap: 8px;
            border-radius: 10px;
            background: #0891b2 !important;
            color: #fff !important;
            padding: 10px 15px;
            font-size: 13px;
            font-weight: 750;
            transition: .2s;
        }

        .explore:hover {
            background: #06b6d4 !important;
            box-shadow: 0 6px 20px #06b6d44d;
            transform: translateY(-2px);
        }

        .explore:focus-visible,
        .navlink:focus-visible {
            outline: 3px solid #67e8f9;
            outline-offset: 3px;
        }

        .empty {
            border: 1px dashed #475569;
            background: #131e33;
            border-radius: 17px;
            text-align: center;
            padding: 60px 25px;
        }

        .empty h3 {
            color: #fff !important;
            margin: 0 0 10px;
            font-size: 20px;
        }

        .footer {
            border-top: 1px solid #263349;
            margin-top: 50px;
            padding-top: 22px;
            color: #94a3b8 !important;
            font-size: 12px;
            text-align: center;
        }

        @media (max-width: 800px) {
            .phases { grid-template-columns: 1fr; }
        }

        @media (max-width: 600px) {
            .stats { grid-template-columns: 1fr; }
            .shell { width: calc(100% - 28px); }
            .phase-card { padding: 20px; }
        }

        @media (prefers-reduced-motion: reduce) {
            .np * { transition: none !important; }
        }
    </style>
</head>

<body class="np">
<main class="shell">

    <header class="topbar">
        <div class="brand">◈ NeuralPath</div>

        <nav class="navlinks" aria-label="Learner navigation">
            <a class="navlink"
               href="{{ route('learner.dashboard') }}">
                Dashboard
            </a>

            <a class="navlink"
               href="{{ route('learner.roadmap.index') }}"
               aria-current="page">
                Roadmap
            </a>

            <form method="POST"
                  action="{{ route('logout') }}"
                  style="margin:0">
                @csrf
                <button class="navlink" type="submit"
                        style="cursor:pointer">
                    Logout
                </button>
            </form>
        </nav>
    </header>

    <section class="hero">
        <p class="eyebrow">Your AI Engineering Journey</p>

        <h1>Learning Roadmap</h1>

        <p class="muted">
            Explore your 60-week path from software engineering
            foundations to production Agentic AI systems.
        </p>

        <p class="muted">
            Welcome, {{ auth()->user()->name }}!
        </p>
    </section>

    <section class="stats" aria-label="Roadmap statistics">
        <div class="stat">
            <div class="stat-label">Available Phases</div>
            <div class="stat-value">
                {{ $branches->count() }}
            </div>
            <div class="stat-note">
                Published learning phases
            </div>
        </div>

        <div class="stat">
            <div class="stat-label">Roadmap Duration</div>
            <div class="stat-value cyan">
                60 <span style="font-size:17px;color:#cbd5e1">Weeks</span>
            </div>
            <div class="stat-note">
                Full curriculum duration
            </div>
        </div>

        <div class="stat">
            <div class="stat-label">Your Progress</div>
            <div class="stat-value" style="font-size:23px">
                Coming Soon
            </div>
            <div class="stat-note">
                Topic tracking will be added next
            </div>
        </div>
    </section>

    <section>
        <div class="section-header">
            <div>
                <h2 class="section-title">Explore Learning Phases</h2>
                <p class="muted" style="margin:6px 0 0">
                    Select a phase to explore its learning modules.
                </p>
            </div>

            <span class="pill">
                {{ $branches->count() }} Available
            </span>
        </div>

        @if($branches->isEmpty())
            <div class="empty">
                <h3>No published learning phases yet</h3>

                <p class="muted">
                    The roadmap is being prepared.
                    Please check back once the administrator
                    publishes the learning phases.
                </p>
            </div>
        @else
            <div class="phases">
                @foreach($branches as $branch)
                    <article class="phase-card">
                        <div class="phase-head">
                            <span class="phase-label">
                                Phase {{ $branch->phase_number }}
                            </span>

                            <span class="weeks">
                                Weeks {{ $branch->start_week }}–{{ $branch->end_week }}
                            </span>
                        </div>

                        <h3 class="phase-title">
                            {{ $branch->title }}
                        </h3>

                        <p class="phase-desc">
                            {{ $branch->description }}
                        </p>

                        <div class="phase-footer">
                            <span class="section-count">
                                {{ $branch->published_sections_count }}
                                {{ \Illuminate\Support\Str::plural(
                                    'sub-branch',
                                    $branch->published_sections_count
                                ) }}
                            </span>

                            <a class="explore"
                               href="{{ route('learner.roadmap.show', $branch) }}">
                                Explore Phase
                                <span aria-hidden="true">→</span>
                            </a>
                        </div>
                    </article>
                @endforeach
            </div>
        @endif
    </section>

    <footer class="footer">
        NeuralPath · Agentic AI Engineering Learning Platform
    </footer>
</main>
</body>
</html>
