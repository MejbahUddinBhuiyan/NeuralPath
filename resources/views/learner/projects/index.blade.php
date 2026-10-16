
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Recommended Projects | NeuralPath</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <style>
        * { box-sizing: border-box; }
        body { margin: 0; background: #080e1e; color: #fff; font-family: system-ui, sans-serif; line-height: 1.65; }
        main { width: min(1080px, calc(100% - 32px)); margin: auto; padding: 40px 0 75px; }
        .top { display: flex; justify-content: space-between; align-items: center; flex-wrap: wrap; gap: 15px; margin-bottom: 40px; }
        .brand, a { color: #67e8f9; text-decoration: none; }
        .brand { font-size: 19px; font-weight: 850; }
        .back { padding: 11px 15px; background: #172239; border: 1px solid #475569; border-radius: 9px; color: #fff; font-size: 13px; }
        .eyebrow { color: #67e8f9; text-transform: uppercase; font-size: 12px; font-weight: 800; }
        h1 { font-size: clamp(26px, 4vw, 36px); margin: 12px 0; }
        .intro { color: #cbd5e1; font-size: 14px; }
        .cards { display: grid; grid-template-columns: repeat(2, minmax(0, 1fr)); gap: 18px; margin-top: 32px; }
        .card { background: #131e33; border: 1px solid #30415b; border-radius: 15px; padding: 24px; }
        .card:hover { border-color: #22d3ee; }
        h2 { margin: 12px 0; font-size: 20px; }
        .meta { display: flex; gap: 9px; flex-wrap: wrap; }
        .pill { background: #103548; border: 1px solid #155e75; padding: 5px 10px; color: #a5f3fc; border-radius: 7px; font-size: 11px; font-weight: 750; }
        .description { color: #cbd5e1; font-size: 13px; }
        .stack { color: #94a3b8; font-size: 12px; margin: 13px 0; }
        .open { display: inline-block; margin-top: 10px; font-size: 13px; font-weight: 800; }
        .empty { margin-top: 24px; padding: 25px; border: 1px dashed #475569; border-radius: 12px; color: #cbd5e1; }
        a:focus-visible { outline: 3px solid #67e8f9; outline-offset: 3px; }
        @media(max-width: 700px) { .cards { grid-template-columns: 1fr; } }
    </style>
</head>
<body>
<main>
    <header class="top">
        <a class="brand" href="{{ route('learner.dashboard') }}">◈ NeuralPath</a>
        <a class="back" href="{{ route('learner.roadmap.show', $branch) }}">← Back to Phase</a>
    </header>

    <div class="eyebrow">Phase {{ $branch->phase_number }} · Weeks {{ $branch->start_week }}–{{ $branch->end_week }}</div>
    <h1>Recommended Projects</h1>
    <p class="intro">
        {{ $branch->title }} — choose a project to apply what you have learned.
        Projects are recommendations, not required topic completions.
    </p>

    <section class="cards" aria-label="Published project recommendations">
        @forelse($projects as $project)
            <article class="card">
                <div class="meta">
                    <span class="pill">{{ ucfirst($project->difficulty) }}</span>
                    @if($project->estimated_weeks)
                        <span class="pill">{{ $project->estimated_weeks }}</span>
                    @endif
                </div>

                <h2>{{ $project->title }}</h2>
                <p class="description">{{ $project->description }}</p>

                @if($project->tech_stack)
                    <p class="stack"><strong>Stack:</strong> {{ $project->tech_stack }}</p>
                @endif

                <a class="open" href="{{ route('learner.projects.show', [$branch, $project]) }}">
                    View Project Details →
                </a>
            </article>
        @empty
            <div class="empty">
                No projects have been published for this learning phase yet.
            </div>
        @endforelse
    </section>
</main>
</body>
</html>
