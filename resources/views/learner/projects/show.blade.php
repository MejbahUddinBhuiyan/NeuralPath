
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>{{ $project->title }} | NeuralPath</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <style>
        * { box-sizing: border-box; }
        body { margin: 0; background: #080e1e; color: #fff; font-family: system-ui, sans-serif; line-height: 1.7; }
        main { max-width: 900px; margin: auto; padding: 40px 20px 80px; }
        a { color: #67e8f9; text-decoration: none; }
        .top { display: flex; align-items: center; justify-content: space-between; gap: 16px; flex-wrap: wrap; margin-bottom: 42px; }
        .brand { font-size: 19px; font-weight: 850; }
        .back { padding: 11px 15px; border: 1px solid #475569; background: #172239; border-radius: 9px; color: #fff; }
        .eyebrow { color: #67e8f9; font-size: 12px; text-transform: uppercase; font-weight: 800; }
        h1 { margin: 13px 0; font-size: clamp(27px, 4vw, 38px); }
        h2 { font-size: 20px; margin: 0 0 14px; }
        .intro { color: #cbd5e1; font-size: 14px; }
        .panel { margin: 21px 0; padding: 25px; background: #131e33; border: 1px solid #30415b; border-radius: 14px; }
        .meta { display: flex; gap: 10px; flex-wrap: wrap; margin: 22px 0; }
        .pill { background: #103548; border: 1px solid #155e75; color: #a5f3fc; border-radius: 7px; font-size: 12px; padding: 7px 11px; font-weight: 800; }
        .content { color: #cbd5e1; white-space: pre-line; overflow-wrap: anywhere; font-size: 14px; }
        .link { display: inline-block; padding: 11px 17px; background: #0891b2; color: #fff; border-radius: 9px; font-weight: 800; }
        .note { color: #94a3b8; font-size: 12px; margin-top: 22px; }
        a:focus-visible { outline: 3px solid #67e8f9; outline-offset: 3px; }
    </style>
</head>
<body>
<main>
    <header class="top">
        <a class="brand" href="{{ route('learner.dashboard') }}">◈ NeuralPath</a>
        <a class="back" href="{{ route('learner.projects.index', $branch) }}">← All Phase Projects</a>
    </header>

    <div class="eyebrow">Phase {{ $branch->phase_number }} · Recommended Project</div>
    <h1>{{ $project->title }}</h1>
    <p class="intro">{{ $project->description }}</p>

    <div class="meta">
        <span class="pill">{{ ucfirst($project->difficulty) }}</span>
        @if($project->estimated_weeks)
            <span class="pill">{{ $project->estimated_weeks }}</span>
        @endif
    </div>

    @if($project->tech_stack)
        <section class="panel">
            <h2>Recommended Technology Stack</h2>
            <div class="content">{{ $project->tech_stack }}</div>
        </section>
    @endif

    @if($project->requirements)
        <section class="panel">
            <h2>Project Requirements</h2>
            <div class="content">{{ $project->requirements }}</div>
        </section>
    @endif

    @if($project->deliverables)
        <section class="panel">
            <h2>Expected Deliverables</h2>
            <div class="content">{{ $project->deliverables }}</div>
        </section>
    @endif

    @if($project->resource_url)
        <section class="panel">
            <h2>Reference Material</h2>
            <a
                href="{{ $project->resource_url }}"
                class="link"
                target="_blank"
                rel="noopener noreferrer"
            >
                Open Reference ↗
            </a>
        </section>
    @endif

    <p class="note">
        Recommended projects are separate from the learning topic completion tracker.
        Working on a project does not automatically change your roadmap progress.
    </p>
</main>
</body>
</html>
