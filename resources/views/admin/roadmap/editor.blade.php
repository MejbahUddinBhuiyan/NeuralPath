
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="color-scheme" content="dark">

    <title>Curriculum Editor | NeuralPath</title>

    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <style>
        * { box-sizing: border-box; }

        body.np {
            margin: 0;
            min-height: 100vh;
            background: #080e1e !important;
            color: #ffffff !important;
            font-family: Inter, ui-sans-serif, system-ui, sans-serif;
            line-height: 1.6;
        }

        .np a { text-decoration: none; }

        .shell {
            width: min(880px, calc(100% - 32px));
            margin: 0 auto;
            padding: 46px 0 70px;
        }

        .topbar {
            display: flex;
            align-items: center;
            justify-content: space-between;
            gap: 20px;
            flex-wrap: wrap;
            margin-bottom: 45px;
        }

        .brand {
            color: #67e8f9 !important;
            font-size: 15px;
            font-weight: 800;
        }

        .back {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            padding: 11px 19px;
            border-radius: 10px;
            border: 1px solid #475569;
            background: #172239;
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
            text-transform: uppercase;
            letter-spacing: 1px;
            font-size: 12px;
            font-weight: 800;
        }

        h1, h2 { color: #ffffff !important; }

        h1 {
            font-size: clamp(28px, 4vw, 38px);
            line-height: 1.25;
            margin: 10px 0;
            font-weight: 800;
        }

        .description {
            color: #cbd5e1 !important;
            font-size: 14px;
            margin: 12px 0 30px;
        }

        .card {
            padding: 32px;
            border: 1px solid #30415b;
            border-radius: 18px;
            background: #131e33;
        }

        .context {
            margin-bottom: 25px;
            padding: 15px 18px;
            border: 1px solid #155e75;
            border-radius: 11px;
            background: #103548;
            color: #cffafe !important;
            font-size: 13px;
        }

        .field {
            display: flex;
            flex-direction: column;
            gap: 8px;
            margin-bottom: 24px;
        }

        .field label {
            color: #ffffff !important;
            font-size: 14px;
            font-weight: 750;
        }

        .field .hint {
            color: #aebed3 !important;
            font-size: 12px;
        }

        .field input,
        .field textarea {
            display: block;
            width: 100%;
            min-height: 47px;
            padding: 12px 14px;
            background: #1d2a40 !important;
            border: 1px solid #475569;
            border-radius: 10px;
            color: #ffffff !important;
            font-family: inherit;
            font-size: 14px;
            outline: none;
            transition: border-color .2s, box-shadow .2s;
        }

        .field textarea {
            min-height: 145px;
            resize: vertical;
        }

        .field input:focus,
        .field textarea:focus {
            border-color: #22d3ee;
            box-shadow: 0 0 0 3px #22d3ee22;
        }

        .field input::placeholder,
        .field textarea::placeholder {
            color: #94a3b8;
        }

        .field input[aria-invalid="true"],
        .field textarea[aria-invalid="true"] {
            border-color: #fb7185;
        }

        .error {
            color: #fda4af !important;
            font-size: 12px;
            font-weight: 650;
        }

        .form-grid {
            display: grid;
            grid-template-columns: repeat(2, minmax(0, 1fr));
            gap: 20px;
        }

        .actions {
            display: flex;
            flex-wrap: wrap;
            align-items: center;
            gap: 14px;
            margin-top: 12px;
            padding-top: 26px;
            border-top: 1px solid #30415b;
        }

        .btn {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            min-height: 46px;
            padding: 12px 22px;
            border-radius: 11px;
            font-size: 14px;
            font-weight: 750;
            cursor: pointer;
            transition: .2s;
        }

        .save {
            background: #0891b2 !important;
            border: 1px solid #22d3ee;
            color: #ffffff !important;
        }

        .save:hover {
            background: #06b6d4 !important;
            box-shadow: 0 7px 24px #06b6d444;
            transform: translateY(-2px);
        }

        .cancel {
            background: #25344e;
            border: 1px solid #475569;
            color: #ffffff !important;
        }

        .cancel:hover {
            border-color: #22d3ee;
            background: #30415b;
        }

        .notice {
            margin-top: 20px;
            padding: 15px;
            border: 1px solid #475569;
            border-radius: 10px;
            color: #cbd5e1 !important;
            background: #1e2d45;
            font-size: 13px;
        }

        .footer {
            margin-top: 45px;
            padding-top: 22px;
            border-top: 1px solid #263349;
            text-align: center;
            color: #94a3b8 !important;
            font-size: 12px;
        }

        @media (max-width: 600px) {
            .card { padding: 22px; }
            .form-grid { grid-template-columns: 1fr; gap: 0; }
            .btn { width: 100%; }
        }

        @media (prefers-reduced-motion: reduce) {
            .np * { transition: none !important; }
        }
    </style>
</head>

<body class="np">

@php
    $isTopic = $editorType === 'topic';
    $model = $isTopic ? $topic : $section;

    if ($isTopic) {
        $formRoute = $isEditing
            ? route('admin.roadmap.topics.update', [$branch, $section, $topic])
            : route('admin.roadmap.topics.store', [$branch, $section]);
    } else {
        $formRoute = $isEditing
            ? route('admin.roadmap.sections.update', [$branch, $section])
            : route('admin.roadmap.sections.store', $branch);
    }

    $itemLabel = $isTopic ? 'Learning Topic' : 'Sub-branch';
@endphp

<main class="shell">

    <header class="topbar">
        <div class="brand">
            ◈ NeuralPath Admin
        </div>

        <a class="back"
           href="{{ route('admin.roadmap.sections', $branch) }}">
            ← Back to Modules
        </a>
    </header>

    <div class="eyebrow">
        Phase {{ $branch->phase_number }}
        · Curriculum Management
    </div>

    <h1>
        {{ $isEditing ? 'Edit' : 'Create' }}
        {{ $itemLabel }}
    </h1>

    <p class="description">
        Organize the learning content for your
        Agentic AI Engineering roadmap.
    </p>

    <section class="card">

        <div class="context">
            <strong>Phase:</strong> {{ $branch->title }}

            @if($isTopic)
                <div style="margin-top:5px">
                    <strong>Sub-branch:</strong>
                    {{ $section->title }}
                </div>
            @endif
        </div>

        <form method="POST" action="{{ $formRoute }}">
            @csrf

            @if($isEditing)
                @method('PUT')
            @endif

            <div class="field">
                <label for="title">
                    {{ $itemLabel }} Title
                </label>

                <input
                    id="title"
                    type="text"
                    name="title"
                    maxlength="150"
                    required
                    value="{{ old('title', $model?->title ?? '') }}"
                    placeholder="{{ $isTopic ? 'Example: Python Type Hints' : 'Example: Python Engineering' }}"
                    aria-invalid="{{ $errors->has('title') ? 'true' : 'false' }}"
                >

                @error('title')
                    <span class="error">{{ $message }}</span>
                @enderror
            </div>

            <div class="field">
                <label for="description">
                    Description
                </label>

                <textarea
                    id="description"
                    name="description"
                    maxlength="{{ $isTopic ? 5000 : 3000 }}"
                    placeholder="Describe what learners will study..."
                    aria-invalid="{{ $errors->has('description') ? 'true' : 'false' }}"
                >{{ old('description', $model?->description ?? '') }}</textarea>

                @error('description')
                    <span class="error">{{ $message }}</span>
                @enderror
            </div>

            <div class="form-grid">

                <div class="field">
                    <label for="sort_order">
                        Display Order
                    </label>

                    <input
                        id="sort_order"
                        type="number"
                        name="sort_order"
                        min="0"
                        max="100000"
                        required
                        value="{{ old('sort_order', $model?->sort_order ?? 0) }}"
                        aria-invalid="{{ $errors->has('sort_order') ? 'true' : 'false' }}"
                    >

                    <span class="hint">
                        Lower numbers appear first.
                    </span>

                    @error('sort_order')
                        <span class="error">{{ $message }}</span>
                    @enderror
                </div>

                @if($isTopic)
                    <div class="field">
                        <label for="target_week">
                            Target Week
                        </label>

                        <input
                            id="target_week"
                            type="number"
                            name="target_week"
                            min="{{ $branch->start_week }}"
                            max="{{ $branch->end_week }}"
                            value="{{ old('target_week', $model?->target_week ?? '') }}"
                            aria-invalid="{{ $errors->has('target_week') ? 'true' : 'false' }}"
                        >

                        <span class="hint">
                            Allowed: Weeks
                            {{ $branch->start_week }}–{{ $branch->end_week }}
                        </span>

                        @error('target_week')
                            <span class="error">{{ $message }}</span>
                        @enderror
                    </div>

                    <div class="field">
                        <label for="estimated_minutes">
                            Estimated Study Time (Minutes)
                        </label>

                        <input
                            id="estimated_minutes"
                            type="number"
                            name="estimated_minutes"
                            min="1"
                            max="65535"
                            value="{{ old('estimated_minutes', $model?->estimated_minutes ?? '') }}"
                            aria-invalid="{{ $errors->has('estimated_minutes') ? 'true' : 'false' }}"
                        >

                        @error('estimated_minutes')
                            <span class="error">{{ $message }}</span>
                        @enderror
                    </div>
                @endif

            </div>

            <div class="actions">
                <button class="btn save" type="submit">
                    {{ $isEditing ? 'Save Changes' : 'Create '.$itemLabel }}
                </button>

                <a class="btn cancel"
                   href="{{ route('admin.roadmap.sections', $branch) }}">
                    Cancel
                </a>
            </div>
        </form>

        <div class="notice">
            @if($isEditing)
                Changes to published content will become visible to learners
                according to the existing publication settings.
            @else
                New content will be saved as a draft.
                Publish it when you are ready for learners to see it.
            @endif
        </div>

    </section>

    <footer class="footer">
        NeuralPath · Agentic AI Engineering Learning Platform
    </footer>

</main>
</body>
</html>
