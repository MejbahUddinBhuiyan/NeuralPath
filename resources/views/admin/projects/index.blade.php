
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Manage Projects | NeuralPath</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <style>
        * { box-sizing: border-box; }
        body { margin: 0; background: #080e1e; color: #fff; font-family: system-ui, sans-serif; line-height: 1.6; }
        main { max-width: 1080px; margin: auto; padding: 34px 20px 80px; }
        a { color: #67e8f9; text-decoration: none; }
        .top, .actions { display: flex; align-items: center; justify-content: space-between; gap: 12px; flex-wrap: wrap; }
        .brand { font-size: 19px; font-weight: 800; }
        .back { padding: 10px 15px; border: 1px solid #475569; border-radius: 9px; color: #fff; background: #172239; }
        .eyebrow { color: #67e8f9; font-size: 12px; font-weight: 800; text-transform: uppercase; }
        h1 { font-size: clamp(25px, 4vw, 34px); margin: 13px 0 8px; }
        .muted { color: #cbd5e1; font-size: 13px; }
        .card { padding: 23px; background: #131e33; border: 1px solid #30415b; border-radius: 15px; margin: 18px 0; }
        .card h2 { margin: 0 0 12px; font-size: 19px; }
        .grid { display: grid; grid-template-columns: 1fr 1fr; gap: 14px; }
        .field { margin-bottom: 14px; min-width: 0; }
        .wide { grid-column: 1 / -1; }
        label { display: block; margin-bottom: 7px; font-size: 12px; font-weight: 700; }
        input, select, textarea { width: 100%; padding: 11px; border: 1px solid #475569; border-radius: 8px; background: #1d2a40; color: #fff; font: inherit; font-size: 13px; }
        textarea { min-height: 100px; resize: vertical; }
        button { padding: 11px 17px; background: #0891b2; border: 1px solid #22d3ee; border-radius: 9px; color: #fff; font-weight: 750; cursor: pointer; font-size: 13px; }
        button:hover { background: #0e7490; }
        .danger { background: #4c1d2b; border-color: #fb7185; }
        .danger:hover { background: #7f1d1d; }
        .neutral { background: #172239; border-color: #64748b; }
        .badge { display: inline-block; padding: 5px 10px; border-radius: 7px; background: #1d2a40; color: #67e8f9; font-size: 12px; font-weight: 700; }
        .notice { padding: 13px; background: #103a32; border: 1px solid #059669; border-radius: 9px; color: #a7f3d0; }
        .errors { color: #fda4af; font-size: 13px; margin: 15px 0; }
        .project-actions { display: flex; gap: 9px; flex-wrap: wrap; margin-top: 16px; }
        input:focus-visible, textarea:focus-visible, select:focus-visible, button:focus-visible, a:focus-visible { outline: 3px solid #67e8f9; outline-offset: 2px; }
        @media(max-width: 650px) { .grid { grid-template-columns: 1fr; } }
    </style>
</head>
<body>
<main>
    <header class="top">
        <a class="brand" href="{{ route('admin.dashboard') }}">◈ NeuralPath Admin</a>
        <a class="back" href="{{ route('admin.roadmap.index') }}">← Roadmap Admin</a>
    </header>

    <div style="margin-top:35px" class="eyebrow">Phase {{ $branch->phase_number }} · Project Recommendations</div>
    <h1>{{ $branch->title }}</h1>
    <p class="muted">{{ $projects->count() }} project recommendations. Draft projects are hidden from learners.</p>

    @if(session('status'))
        <div class="notice" role="status">{{ session('status') }}</div>
    @endif

    @if($errors->any())
        <div class="errors" role="alert">
            @foreach($errors->all() as $error)
                <div>{{ $error }}</div>
            @endforeach
        </div>
    @endif

    <section class="card">
        <h2>Create a Recommended Project</h2>
        <form method="POST" action="{{ route('admin.projects.store', $branch) }}">
            @csrf
            <div class="grid">
                <div class="field wide">
                    <label for="new_title">Project Title</label>
                    <input id="new_title" name="title" required maxlength="255" value="{{ old('title') }}">
                </div>
                <div class="field wide">
                    <label for="new_description">Description</label>
                    <textarea id="new_description" name="description" required>{{ old('description') }}</textarea>
                </div>
                <div class="field">
                    <label for="new_difficulty">Difficulty</label>
                    <select id="new_difficulty" name="difficulty">
                        @foreach(['beginner', 'intermediate', 'advanced'] as $level)
                            <option value="{{ $level }}" @selected(old('difficulty', 'intermediate') === $level)>{{ ucfirst($level) }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="field">
                    <label for="new_duration">Estimated Duration</label>
                    <input id="new_duration" name="estimated_weeks" placeholder="2–3 weeks" value="{{ old('estimated_weeks') }}">
                </div>
                <div class="field wide">
                    <label for="new_stack">Technology Stack</label>
                    <input id="new_stack" name="tech_stack" value="{{ old('tech_stack') }}">
                </div>
                <div class="field wide">
                    <label for="new_requirements">Requirements</label>
                    <textarea id="new_requirements" name="requirements">{{ old('requirements') }}</textarea>
                </div>
                <div class="field wide">
                    <label for="new_deliverables">Expected Deliverables</label>
                    <textarea id="new_deliverables" name="deliverables">{{ old('deliverables') }}</textarea>
                </div>
                <div class="field wide">
                    <label for="new_url">Reference URL (optional)</label>
                    <input id="new_url" type="url" name="resource_url" value="{{ old('resource_url') }}">
                </div>
                <div class="field">
                    <label for="new_order">Display Order</label>
                    <input id="new_order" type="number" min="0" max="10000" name="sort_order" value="{{ old('sort_order', $projects->count() + 1) }}" required>
                </div>
            </div>
            <button type="submit">+ Create Draft Project</button>
        </form>
    </section>

    <h2>Existing Projects</h2>

    @forelse($projects as $project)
        <article class="card">
            <div class="actions">
                <h2>{{ $project->title }}</h2>
                <span class="badge">{{ $project->is_published ? 'Published' : 'Draft' }}</span>
            </div>
            <form method="POST" action="{{ route('admin.projects.update', [$branch, $project]) }}">
                @csrf
                @method('PUT')
                <div class="grid">
                    <div class="field wide">
                        <label for="title_{{ $project->id }}">Title</label>
                        <input id="title_{{ $project->id }}" name="title" value="{{ $project->title }}" required maxlength="255">
                    </div>
                    <div class="field wide">
                        <label for="description_{{ $project->id }}">Description</label>
                        <textarea id="description_{{ $project->id }}" name="description" required>{{ $project->description }}</textarea>
                    </div>
                    <div class="field">
                        <label for="difficulty_{{ $project->id }}">Difficulty</label>
                        <select id="difficulty_{{ $project->id }}" name="difficulty">
                            @foreach(['beginner', 'intermediate', 'advanced'] as $level)
                                <option value="{{ $level }}" @selected($project->difficulty === $level)>{{ ucfirst($level) }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="field">
                        <label for="duration_{{ $project->id }}">Duration</label>
                        <input id="duration_{{ $project->id }}" name="estimated_weeks" value="{{ $project->estimated_weeks }}">
                    </div>
                    <div class="field wide">
                        <label for="stack_{{ $project->id }}">Technology Stack</label>
                        <input id="stack_{{ $project->id }}" name="tech_stack" value="{{ $project->tech_stack }}">
                    </div>
                    <div class="field wide">
                        <label for="requirements_{{ $project->id }}">Requirements</label>
                        <textarea id="requirements_{{ $project->id }}" name="requirements">{{ $project->requirements }}</textarea>
                    </div>
                    <div class="field wide">
                        <label for="deliverables_{{ $project->id }}">Deliverables</label>
                        <textarea id="deliverables_{{ $project->id }}" name="deliverables">{{ $project->deliverables }}</textarea>
                    </div>
                    <div class="field wide">
                        <label for="url_{{ $project->id }}">Reference URL</label>
                        <input id="url_{{ $project->id }}" name="resource_url" type="url" value="{{ $project->resource_url }}">
                    </div>
                    <div class="field">
                        <label for="order_{{ $project->id }}">Display Order</label>
                        <input id="order_{{ $project->id }}" name="sort_order" type="number" min="0" max="10000" value="{{ $project->sort_order }}" required>
                    </div>
                </div>
                <button type="submit">Save Changes</button>
            </form>

            <div class="project-actions">
                <form method="POST" action="{{ route('admin.projects.publication', [$branch, $project]) }}">
                    @csrf
                    @method('PATCH')
                    <button type="submit" class="neutral">
                        {{ $project->is_published ? 'Unpublish' : 'Publish' }}
                    </button>
                </form>

                <form method="POST" action="{{ route('admin.projects.destroy', [$branch, $project]) }}"
                      onsubmit="return confirm('Permanently delete this recommended project?')">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="danger">Delete</button>
                </form>
            </div>
        </article>
    @empty
        <p class="muted">No project recommendations in this phase yet.</p>
    @endforelse
</main>
</body>
</html>
