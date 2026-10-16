
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="color-scheme" content="dark">

    <title>Admin Dashboard | NeuralPath</title>

    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <style>
        * { box-sizing: border-box; }

        body {
            margin: 0;
            background: #080e1e;
            color: #ffffff;
            font-family: Inter, ui-sans-serif, system-ui, sans-serif;
            line-height: 1.6;
        }

        .shell {
            max-width: 1120px;
            margin: auto;
            padding: 35px 22px 70px;
        }

        .header {
            display: flex;
            align-items: center;
            justify-content: space-between;
            gap: 18px;
            flex-wrap: wrap;
            margin-bottom: 42px;
        }

        .brand {
            color: #67e8f9;
            font-size: 19px;
            font-weight: 850;
            text-decoration: none;
        }

        .nav {
            display: flex;
            align-items: center;
            flex-wrap: wrap;
            gap: 10px;
        }

        .nav a,
        .nav button {
            display: inline-block;
            padding: 10px 15px;
            background: #172239;
            border: 1px solid #475569;
            border-radius: 9px;
            color: #ffffff;
            font-family: inherit;
            font-size: 13px;
            font-weight: 700;
            text-decoration: none;
            cursor: pointer;
        }

        .nav a:hover,
        .nav button:hover {
            border-color: #22d3ee;
        }

        .eyebrow {
            color: #67e8f9;
            font-size: 12px;
            font-weight: 800;
            letter-spacing: 1px;
            text-transform: uppercase;
        }

        h1 {
            margin: 10px 0;
            font-size: clamp(27px, 4vw, 37px);
        }

        .intro {
            margin: 0 0 34px;
            color: #cbd5e1;
            font-size: 14px;
        }

        .stats {
            display: grid;
            grid-template-columns: repeat(3, minmax(0, 1fr));
            gap: 16px;
        }

        .stat {
            padding: 23px;
            background: #131e33;
            border: 1px solid #30415b;
            border-radius: 14px;
        }

        .stat-label {
            color: #cbd5e1;
            font-size: 12px;
            font-weight: 700;
        }

        .stat-number {
            margin-top: 12px;
            color: #67e8f9;
            font-size: 31px;
            font-weight: 850;
        }

        .section-heading {
            margin: 38px 0 18px;
            font-size: 21px;
        }

        .actions {
            display: grid;
            grid-template-columns: repeat(3, minmax(0, 1fr));
            gap: 16px;
        }

        .action-card {
            display: block;
            padding: 24px;
            background: #131e33;
            border: 1px solid #30415b;
            border-radius: 14px;
            color: #ffffff;
            text-decoration: none;
            transition: border-color .2s, transform .2s;
        }

        .action-card:hover {
            border-color: #22d3ee;
            transform: translateY(-2px);
        }

        .action-card h3 {
            margin: 0 0 8px;
            font-size: 17px;
        }

        .action-card p {
            margin: 0;
            color: #cbd5e1;
            font-size: 13px;
        }

        .action-link {
            display: inline-block;
            margin-top: 18px;
            color: #67e8f9;
            font-size: 13px;
            font-weight: 800;
        }

        .footer {
            margin-top: 50px;
            padding-top: 20px;
            border-top: 1px solid #263349;
            color: #94a3b8;
            text-align: center;
            font-size: 12px;
        }

        a:focus-visible,
        button:focus-visible {
            outline: 3px solid #67e8f9;
            outline-offset: 3px;
        }

        @media (max-width: 750px) {
            .stats, .actions {
                grid-template-columns: 1fr;
            }
        }
    </style>
</head>

<body>
<main class="shell">

    <header class="header">
        <a href="{{ route('admin.dashboard') }}" class="brand">
            ◈ NeuralPath Admin
        </a>

        <nav class="nav" aria-label="Admin navigation">
<a href="{{ route('learner.dashboard') }}">
    Switch to Learner View →
</a>

            <a href="{{ route('admin.learners.index') }}">
                Learners
            </a>

            <a href="{{ route('admin.roadmap.index') }}">
                Roadmap
            </a>

            <a href="{{ route('admin.invitations.index') }}">
                Invitations
            </a>

            <form method="POST" action="{{ route('logout') }}">
                @csrf
                <button type="submit">Logout</button>
            </form>
        </nav>
    </header>

    <div class="eyebrow">Administration</div>

    <h1>Admin Dashboard</h1>

    <p class="intro">
        Welcome, {{ auth()->user()->name }}.
        Manage learners, monitor progress, and maintain
        the NeuralPath learning roadmap.
    </p>

    <section class="stats" aria-label="Platform statistics">
        <article class="stat">
            <div class="stat-label">Total Learners</div>
            <div class="stat-number" data-testid="total-learners">
                {{ $stats['total_learners'] }}
            </div>
        </article>

        <article class="stat">
            <div class="stat-label">Active Learners</div>
            <div class="stat-number">
                {{ $stats['active_learners'] }}
            </div>
        </article>

        <article class="stat">
            <div class="stat-label">Suspended Learners</div>
            <div class="stat-number">
                {{ $stats['suspended_learners'] }}
            </div>
        </article>

        <article class="stat">
            <div class="stat-label">Published Phases</div>
            <div class="stat-number">
                {{ $stats['published_phases'] }}
            </div>
        </article>

        <article class="stat">
            <div class="stat-label">Published Topics</div>
            <div class="stat-number">
                {{ $stats['published_topics'] }}
            </div>
        </article>

        <article class="stat">
            <div class="stat-label">Recorded Topic Completions</div>
            <div class="stat-number">
                {{ $stats['total_completions'] }}
            </div>
        </article>
    </section>

    <h2 class="section-heading">Management</h2>

    <section class="actions" aria-label="Admin management shortcuts">

        <a class="action-card" href="{{ route('admin.learners.index') }}">
            <h3>Learner Management</h3>
            <p>
                Search learners, inspect progress,
                and activate or suspend accounts.
            </p>
            <span class="action-link">Manage Learners →</span>
        </a>

        <a class="action-card" href="{{ route('admin.roadmap.index') }}">
            <h3>Learning Roadmap</h3>
            <p>
                Manage phases, learning modules,
                topics, publication, and resources.
            </p>
            <span class="action-link">Manage Roadmap →</span>
        </a>

        <a class="action-card" href="{{ route('admin.invitations.index') }}">
            <h3>Invitations</h3>
            <p>
                Invite approved learners to join
                the private NeuralPath platform.
            </p>
            <span class="action-link">Manage Invitations →</span>
        </a>

    </section>

    <footer class="footer">
        NeuralPath · Admin Management
    </footer>

</main>
</body>
</html>
