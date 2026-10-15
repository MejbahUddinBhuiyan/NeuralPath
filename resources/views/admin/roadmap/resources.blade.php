
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="color-scheme" content="dark">
    <title>Learning Resources | NeuralPath Admin</title>

    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <style>
        * { box-sizing: border-box; }

        body.np {
            margin: 0;
            background: #080e1e !important;
            color: #fff !important;
            min-height: 100vh;
            font-family: Inter, system-ui, sans-serif;
            line-height: 1.6;
        }

        .np a { text-decoration: none; }

        .shell {
            width: min(1050px, calc(100% - 32px));
            margin: auto;
            padding: 40px 0 70px;
        }

        .header, .item-top, .actions, .section-head {
            display: flex;
            justify-content: space-between;
            align-items: center;
            flex-wrap: wrap;
            gap: 15px;
        }

        .header { margin-bottom: 38px; }

        .brand {
            color: #67e8f9 !important;
            font-size: 14px;
            font-weight: 800;
        }

        h1, h2, h3 { color: #fff !important; }

        h1 {
            margin: 9px 0;
            font-size: clamp(27px, 4vw, 36px);
            line-height: 1.3;
        }

        h2 { font-size: 20px; margin: 0; }
        h3 { font-size: 16px; margin: 0; }

        .muted {
            color: #cbd5e1 !important;
            font-size: 13px;
        }

        .back, .btn {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            padding: 10px 16px;
            border-radius: 10px;
            font-size: 13px;
            font-weight: 750;
            cursor: pointer;
            transition: transform .2s, background .2s,
                        border-color .2s, box-shadow .2s;
        }

        .back, .btn.secondary {
            background: #25344e !important;
            border: 1px solid #475569;
            color: #fff !important;
        }

        .back:hover, .btn.secondary:hover {
            background: #30415b !important;
            border-color: #22d3ee;
        }

        .btn.primary {
            background: #0891b2 !important;
            border: 1px solid #22d3ee;
            color: #fff !important;
        }

        .btn.primary:hover {
            background: #06b6d4 !important;
            box-shadow: 0 5px 20px #06b6d440;
        }

        .btn.warning {
            background: #3d2b18 !important;
            color: #fde68a !important;
            border: 1px solid #b45309;
        }

        .btn.warning:hover { background: #633c17 !important; }

        .btn:hover, .back:hover { transform: translateY(-2px); }

        .btn:focus-visible, .back:focus-visible,
        input:focus-visible, textarea:focus-visible,
        select:focus-visible {
            outline: 3px solid #67e8f9;
            outline-offset: 2px;
        }

        .card {
            background: #131e33;
            border: 1px solid #30415b;
            border-radius: 16px;
            padding: 24px;
            margin-top: 22px;
        }

        .notice {
            background: #103a32;
            color: #a7f3d0 !important;
            border: 1px solid #059669;
            padding: 13px 17px;
            border-radius: 10px;
            margin: 20px 0;
        }

        .field {
            display: flex;
            flex-direction: column;
            gap: 7px;
            margin-bottom: 17px;
        }

        .field label {
            color: #fff !important;
            font-weight: 700;
            font-size: 13px;
        }

        .field input, .field textarea, .field select {
            width: 100%;
            padding: 11px 13px;
            min-height: 45px;
            border-radius: 9px;
            background: #1d2a40 !important;
            border: 1px solid #475569;
            color: #fff !important;
            font: inherit;
            font-size: 14px;
        }

        .field textarea { min-height: 90px; resize: vertical; }
        .field select option { background: #1d2a40; color: #fff; }

        .form-grid {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 16px;
        }

        .error {
            color: #fda4af !important;
            font-size: 12px;
        }

        .resource-list { display: grid; gap: 15px; margin-top: 20px; }

        .resource {
            background: #1d2a40;
            border: 1px solid #334763;
            border-radius: 12px;
            padding: 18px;
        }

        .resource-title {
            font-size: 15px;
            color: #fff !important;
            font-weight: 750;
            overflow-wrap: anywhere;
        }

        .resource-url {
            color: #a5f3fc !important;
            font-size: 12px;
            overflow-wrap: anywhere;
        }

        .tag {
            display: inline-block;
            padding: 5px 10px;
            font-size: 12px;
            font-weight: 700;
            border-radius: 8px;
            background: #103548;
            border: 1px solid #155e75;
            color: #a5f3fc !important;
        }

        .tag.published {
            background: #103a32;
            border-color: #059669;
            color: #a7f3d0 !important;
        }

        .tag.draft {
            background: #263349;
            border-color: #475569;
            color: #e2e8f0 !important;
        }

        .edit-panel { margin-top: 16px; }
        .edit-panel summary {
            color: #67e8f9;
            cursor: pointer;
            font-weight: 700;
            font-size: 13px;
        }

        .edit-panel form { padding-top: 16px; }

        .empty {
            border: 1px dashed #475569;
            padding: 32px;
            text-align: center;
            border-radius: 12px;
            color: #cbd5e1 !important;
        }

        @media(max-width:650px) {
            .form-grid { grid-template-columns: 1fr; gap: 0; }
            .card { padding: 18px; }
        }

        @media(prefers-reduced-motion:reduce) {
            .np * { transition: none !important; }
        }
    </style>
</head>
<body class="np">
<main class="shell">

    <header class="header">
        <div class="brand">◈ NeuralPath Admin</div>

        <a class="back"
           href="{{ route('admin.roadmap.sections', $branch) }}">
            ← Back to Modules
        </a>
    </header>

    <p class="brand">
        PHASE {{ $branch->phase_number }}
        / {{ $section->title }}
    </p>

    <h1>Learning Resources</h1>
    <p class="muted">
        Topic: {{ $topic->title }}
    </p>

    @if(session('status'))
        <div class="notice" role="status">{{ session('status') }}</div>
    @endif

    <section class="card">
        <h2>Add Learning Resource</h2>
        <p class="muted">
            Add trusted documentation, YouTube tutorials,
            articles, courses, or useful references.
        </p>

        <form method="POST"
              action="{{ route('admin.roadmap.resources.store', [$branch, $section, $topic]) }}">
            @csrf

            <div class="field">
                <label for="new-title">Resource Title</label>
                <input id="new-title" name="title" type="text"
                       maxlength="180" required
                       value="{{ old('title') }}"
                       placeholder="Example: Python Typing Documentation">
                @error('title') <span class="error">{{ $message }}</span> @enderror
            </div>

            <div class="field">
                <label for="new-url">Resource URL</label>
                <input id="new-url" name="url" type="url"
                       maxlength="2048" required
                       value="{{ old('url') }}"
                       placeholder="https://...">
                @error('url') <span class="error">{{ $message }}</span> @enderror
            </div>

            <div class="form-grid">
                <div class="field">
                    <label for="new-type">Resource Type</label>
                    <select id="new-type" name="type">
                        @foreach([
                            'documentation' => 'Documentation',
                            'youtube' => 'YouTube',
                            'article' => 'Article',
                            'course' => 'Course',
                            'other' => 'Other'
                        ] as $value => $label)
                            <option value="{{ $value }}"
                                @selected(old('type', 'documentation') === $value)>
                                {{ $label }}
                            </option>
                        @endforeach
                    </select>
                    @error('type') <span class="error">{{ $message }}</span> @enderror
                </div>

                <div class="field">
                    <label for="new-sort">Display Order</label>
                    <input id="new-sort" name="sort_order" type="number"
                           min="0" max="100000" required
                           value="{{ old('sort_order', 0) }}">
                    @error('sort_order') <span class="error">{{ $message }}</span> @enderror
                </div>
            </div>

            <div class="field">
                <label for="new-desc">Description (Optional)</label>
                <textarea id="new-desc" name="description"
                          maxlength="3000"
                          placeholder="What will the learner gain from this resource?">{{ old('description') }}</textarea>
                @error('description') <span class="error">{{ $message }}</span> @enderror
            </div>

            <button class="btn primary" type="submit">
                + Add Resource
            </button>

            <p class="muted">Resources are saved as drafts by default.</p>
        </form>
    </section>

    <section class="card">
        <div class="section-head">
            <h2>Attached Resources</h2>
            <span class="tag">{{ $topic->resources->count() }} Total</span>
        </div>

        <div class="resource-list">
            @forelse($topic->resources as $resource)
                <article class="resource">
                    <div class="item-top">
                        <div>
                            <div class="resource-title">
                                {{ $resource->title }}
                            </div>

                            <span class="tag">{{ ucfirst($resource->type) }}</span>

                            <span class="tag {{ $resource->is_published ? 'published' : 'draft' }}">
                                {{ $resource->is_published ? 'Published' : 'Draft' }}
                            </span>
                        </div>

                        <form method="POST"
                              action="{{ route('admin.roadmap.resources.publication', [
                                  $branch, $section, $topic, $resource
                              ]) }}">
                            @csrf
                            @method('PATCH')

                            <button type="submit"
                                    class="btn {{ $resource->is_published ? 'warning' : 'primary' }}">
                                {{ $resource->is_published ? 'Unpublish' : 'Publish' }}
                            </button>
                        </form>
                    </div>

                    <p class="muted">{{ $resource->description }}</p>

                    <a class="resource-url"
                       href="{{ $resource->url }}"
                       target="_blank"
                       rel="noopener noreferrer">
                        {{ $resource->url }} ↗
                    </a>

                    <details class="edit-panel">
                        <summary>Edit Resource</summary>

                        <form method="POST"
                              action="{{ route('admin.roadmap.resources.update', [
                                  $branch, $section, $topic, $resource
                              ]) }}">
                            @csrf
                            @method('PUT')

                            <div class="field">
                                <label for="title-{{ $resource->id }}">Title</label>
                                <input id="title-{{ $resource->id }}"
                                       name="title" required maxlength="180"
                                       value="{{ $resource->title }}">
                            </div>

                            <div class="field">
                                <label for="url-{{ $resource->id }}">URL</label>
                                <input id="url-{{ $resource->id }}"
                                       name="url" type="url" required
                                       maxlength="2048"
                                       value="{{ $resource->url }}">
                            </div>

                            <div class="form-grid">
                                <div class="field">
                                    <label for="type-{{ $resource->id }}">Type</label>
                                    <select id="type-{{ $resource->id }}" name="type">
                                        @foreach([
                                            'documentation' => 'Documentation',
                                            'youtube' => 'YouTube',
                                            'article' => 'Article',
                                            'course' => 'Course',
                                            'other' => 'Other'
                                        ] as $value => $label)
                                            <option value="{{ $value }}"
                                                @selected($resource->type === $value)>
                                                {{ $label }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>

                                <div class="field">
                                    <label for="sort-{{ $resource->id }}">Order</label>
                                    <input id="sort-{{ $resource->id }}"
                                           type="number"
                                           name="sort_order"
                                           min="0" max="100000"
                                           required
                                           value="{{ $resource->sort_order }}">
                                </div>
                            </div>

                            <div class="field">
                                <label for="desc-{{ $resource->id }}">Description</label>
                                <textarea id="desc-{{ $resource->id }}"
                                          name="description"
                                          maxlength="3000">{{ $resource->description }}</textarea>
                            </div>

                            <button class="btn primary" type="submit">
                                Save Changes
                            </button>
                        </form>
                    </details>
                </article>
            @empty
                <div class="empty">
                    No learning resources have been added yet.
                </div>
            @endforelse
        </div>
    </section>
</main>
</body>
</html>
