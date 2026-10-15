<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="color-scheme" content="dark">
    <title>{{ $branch->title }} | NeuralPath Admin</title>

    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <style>
        *, *::before, *::after { box-sizing: border-box; }
        body.np {
            margin: 0; min-height: 100vh;
            background: #080e1e !important; color: #ffffff !important;
            font-family: Inter, ui-sans-serif, system-ui, sans-serif;
            line-height: 1.6;
        }
        .np a { text-decoration: none; }
        .np h1, .np h2, .np h3 { color: #ffffff !important; }
        .shell { width: min(1180px, calc(100% - 32px)); margin: auto; padding: 40px 0 70px; }
        .header { display: flex; align-items: center; justify-content: space-between; flex-wrap: wrap; gap: 20px; margin-bottom: 35px; }
        .brand { color: #67e8f9 !important; font-size: 14px; font-weight: 800; }
        h1 { font-size: clamp(27px, 4vw, 36px); line-height: 1.25; margin: 12px 0; }
        .muted { color: #cbd5e1 !important; font-size: 14px; }
        .back { display: inline-flex; padding: 11px 17px; border-radius: 10px; border: 1px solid #475569; background: #172239; color: #ffffff !important; font-weight: 700; font-size: 13px; transition: .2s; }
        .back:hover { border-color: #22d3ee; background: #25344e; transform: translateY(-2px); }
        .notice { padding: 14px 18px; margin-bottom: 25px; background: #103a32; border: 1px solid #059669; border-radius: 10px; color: #a7f3d0 !important; font-weight: 700; font-size: 13px; }
        .summary { display: flex; flex-wrap: wrap; gap: 12px; margin: 25px 0 35px; }
        .summary span { background: #1e2d45; border: 1px solid #334763; border-radius: 9px; color: #ffffff !important; padding: 9px 15px; font-size: 13px; font-weight: 700; }
        .toolbar { display: flex; justify-content: space-between; align-items: center; flex-wrap: wrap; gap: 15px; margin-bottom: 22px; }
        .toolbar h2 { margin: 0; font-size: 21px; font-weight: 800; }
        .section-list { display: grid; gap: 20px; }
        .section-card { padding: 25px; border: 1px solid #30415b; border-radius: 16px; background: #131e33; transition: border-color .2s, transform .2s; }
        .section-card:hover { border-color: #0891b2; transform: translateY(-2px); }
        .section-heading { display: flex; align-items: center; justify-content: space-between; gap: 20px; margin-bottom: 20px; }
        .section-info { min-width: 0; flex: 1; }
        .section-heading h2 { margin: 0 0 5px; font-size: 20px; }
        .section-heading p { margin: 0; }
        .section-actions, .topic-actions { display: flex; align-items: center; flex-wrap: wrap; gap: 10px; flex-shrink: 0; }
        .section-actions form, .topic-actions form { margin: 0; }
        .topics-toolbar { display: flex; justify-content: space-between; align-items: center; flex-wrap: wrap; gap: 12px; margin: 24px 0 15px; padding-top: 18px; border-top: 1px solid #30415b; }
        .topics-label { color: #cbd5e1 !important; font-weight: 700; font-size: 13px; }
        .topics { display: grid; gap: 10px; }
        .topic-row { display: flex; justify-content: space-between; align-items: center; gap: 20px; padding: 14px; background: #1d2a40; border: 1px solid #334763; border-radius: 10px; }
        .topic-details { min-width: 0; flex: 1; }
        .topic-name { color: #ffffff !important; font-size: 14px; font-weight: 700; overflow-wrap: anywhere; }
        .topic-meta { color: #cbd5e1 !important; font-size: 12px; }
        .status { display: inline-block; margin-top: 7px; font-size: 12px; font-weight: 700; }
        .status.draft { color: #cbd5e1 !important; }
        .status.published { color: #6ee7b7 !important; }
        .btn { display: inline-flex; align-items: center; justify-content: center; gap: 7px; min-width: 105px; min-height: 40px; padding: 9px 14px; border-radius: 9px; font-weight: 750; font-size: 13px; cursor: pointer; transition: background .2s, border-color .2s, transform .2s, box-shadow .2s; text-align: center; }
        .btn.publish { background: #0891b2 !important; color: #ffffff !important; border: 1px solid #22d3ee; }
        .btn.publish:hover { background: #06b6d4 !important; box-shadow: 0 5px 20px #06b6d455; transform: translateY(-2px); }
        .btn.unpublish { background: #3d2b18 !important; color: #fde68a !important; border: 1px solid #b45309; }
        .btn.unpublish:hover { background: #633c17 !important; transform: translateY(-2px); }
        .btn.edit { background: #25344e !important; color: #ffffff !important; border: 1px solid #64748b; }
        .btn.edit:hover { background: #334763 !important; border-color: #67e8f9; transform: translateY(-2px); }
        .btn:focus-visible, .back:focus-visible { outline: 3px solid #67e8f9; outline-offset: 3px; }
        .empty { padding: 40px 20px; border: 1px dashed #475569; border-radius: 14px; background: #131e33; text-align: center; color: #cbd5e1 !important; }
        .footer { margin-top: 40px; padding-top: 18px; border-top: 1px solid #263349; text-align: center; color: #94a3b8 !important; font-size: 12px; }
        @media (max-width: 760px) {
            .section-heading, .topic-row { align-items: stretch; flex-direction: column; }
            .section-actions, .topic-actions { width: 100%; }
            .section-actions > *, .topic-actions > * { flex: 1; }
            .section-actions form .btn, .topic-actions form .btn, .section-actions > a, .topic-actions > a { width: 100%; }
        }
        @media (max-width: 480px) {
            .section-card { padding: 18px; }
            .section-actions, .topic-actions { flex-direction: column; }
            .section-actions > *, .topic-actions > * { width: 100%; }
        }
        @media (prefers-reduced-motion: reduce) { .np * { transition: none !important; } }
    </style>
</head>
<body class="np">
<main class="shell">
    <header class="header">
        <div class="brand">◈ NeuralPath Admin</div>
        <a class="back" href="{{ route('admin.roadmap.index') }}">← All Roadmap Phases</a>
    </header>

    @if(session('status'))
        <div role="status" class="notice">{{ session('status') }}</div>
    @endif

    <section aria-label="Phase overview">
        <div class="brand">
            PHASE {{ $branch->phase_number }} · WEEKS {{ $branch->start_week }}–{{ $branch->end_week }}
        </div>
        <h1>{{ $branch->title }}</h1>
        <p class="muted">{{ $branch->description }}</p>
        <div class="summary">
            <span>{{ $branch->sections->count() }} {{ \Illuminate\Support\Str::plural('Sub-branch', $branch->sections->count()) }}</span>
            <span>{{ $branch->sections->sum(fn ($section) => $section->topics->count()) }} Topics</span>
        </div>
    </section>

    <div class="toolbar">
        <h2>Learning Modules</h2>
        <a href="{{ route('admin.roadmap.sections.create', $branch) }}" class="btn publish">+ Add Sub-branch</a>
    </div>

    <section class="section-list" aria-label="Sub-branches and topics">
        @forelse($branch->sections as $section)
            <article class="section-card">
                <div class="section-heading">
                    <div class="section-info">
                        <h2>{{ $section->title }}</h2>
                        @if($section->description)
                            <p class="muted">{{ $section->description }}</p>
                        @endif
                        <span class="status {{ $section->is_published ? 'published' : 'draft' }}">
                            {{ $section->is_published ? '● Published' : '● Draft' }}
                        </span>
                    </div>

                    <div class="section-actions">
                        <a class="btn edit" href="{{ route('admin.roadmap.sections.edit', [$branch, $section]) }}">Edit Module</a>
                        <form method="POST" action="{{ route('admin.roadmap.sections.publication', [$branch, $section]) }}">
                            @csrf
                            @method('PATCH')
                            <button type="submit" class="btn {{ $section->is_published ? 'unpublish' : 'publish' }}">
                                {{ $section->is_published ? 'Unpublish' : 'Publish' }}
                            </button>
                        </form>
                    </div>
                </div>

                <div class="topics-toolbar">
                    <span class="topics-label">Learning Topics · {{ $section->topics->count() }}</span>
                    <a class="btn publish" href="{{ route('admin.roadmap.topics.create', [$branch, $section]) }}">+ Add Topic</a>
                </div>

                <div class="topics">
                    @forelse($section->topics as $topic)
                        <div class="topic-row">
                            <div class="topic-details">
                                <div class="topic-name">{{ $topic->title }}</div>
                                <div class="topic-meta">
                                    @if($topic->target_week)Week {{ $topic->target_week }}@endif
                                    @if($topic->estimated_minutes)
                                        @if($topic->target_week) · @endif{{ $topic->estimated_minutes }} min
                                    @endif
                                </div>
                                <span class="status {{ $topic->is_published ? 'published' : 'draft' }}">
                                    {{ $topic->is_published ? '● Published' : '● Draft' }}
                                </span>
                            </div>
                            <div class="topic-actions">
                                <a class="btn edit" href="{{ route('admin.roadmap.topics.edit', [$branch, $section, $topic]) }}">Edit Topic</a>
                                <form method="POST" action="{{ route('admin.roadmap.topics.publication', [$branch, $section, $topic]) }}">
                                    @csrf
                                    @method('PATCH')
                                    <button type="submit" class="btn {{ $topic->is_published ? 'unpublish' : 'publish' }}">
                                        {{ $topic->is_published ? 'Unpublish' : 'Publish' }}
                                    </button>
                                    
<a href="{{ route('admin.roadmap.resources.index', [
        $branch, $section, $topic
    ]) }}"
   class="btn"
   style="
       background:#103548;
       color:#ffffff;
       border:1px solid #22d3ee;
       text-decoration:none;
   ">
    Resources
</a>

                                </form>
                            </div>
                        </div>
                    @empty
                        <p class="muted">No topics in this sub-branch yet.</p>
                    @endforelse
                </div>
            </article>
        @empty
            <div class="empty">No sub-branches have been added to this phase yet. Use “Add Sub-branch” to create one.</div>
        @endforelse
    </section>

    <footer class="footer">NeuralPath · Agentic AI Engineering Learning Platform</footer>
</main>
</body>
</html>
