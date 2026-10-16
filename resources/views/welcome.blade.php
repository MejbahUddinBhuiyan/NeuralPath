
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="color-scheme" content="dark">

    <meta
        name="description"
        content="NeuralPath is a private, structured 60-week learning platform for Agentic AI Engineering, LLM applications, AI agents, and production systems."
    >

    <title>NeuralPath | Your Path to Agentic AI Engineering</title>

    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <style>
        :root {
            color-scheme: dark;
            scroll-behavior: smooth;
        }

        * {
            box-sizing: border-box;
        }

        body.np {
            margin: 0;
            min-height: 100vh;
            background: #080e1e !important;
            color: #ffffff !important;
            font-family: Inter, ui-sans-serif, system-ui, sans-serif;
            line-height: 1.65;
        }

        .np h1,
        .np h2,
        .np h3,
        .np p {
            margin-top: 0;
        }

        .np h1,
        .np h2,
        .np h3 {
            color: #ffffff !important;
        }

        .np a {
            text-decoration: none;
        }

        .shell {
            width: min(1120px, calc(100% - 36px));
            margin: auto;
        }

        /* Navigation */

        .header {
            position: relative;
            z-index: 10;
            border-bottom: 1px solid #1e293b;
        }

        .nav {
            display: flex;
            justify-content: space-between;
            align-items: center;
            flex-wrap: wrap;
            gap: 16px;
            min-height: 83px;
        }

        .brand {
            display: inline-flex;
            align-items: center;
            gap: 10px;
            color: #67e8f9 !important;
            font-weight: 850;
            font-size: 21px;
            letter-spacing: -.5px;
        }

        .brand-symbol {
            display: grid;
            place-items: center;
            width: 34px;
            height: 34px;
            background: #103548;
            border: 1px solid #155e75;
            border-radius: 10px;
        }

        .nav-links {
            display: flex;
            align-items: center;
            flex-wrap: wrap;
            gap: 20px;
        }

        .nav-link {
            color: #cbd5e1 !important;
            font-size: 13px;
            font-weight: 700;
        }

        .nav-link:hover {
            color: #67e8f9 !important;
        }

        /* Buttons */

        .btn {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            gap: 9px;
            min-height: 45px;
            padding: 11px 20px;
            border: 1px solid transparent;
            border-radius: 10px;
            font-family: inherit;
            font-size: 13px;
            font-weight: 800;
            text-align: center;
            transition:
                background .2s,
                border-color .2s,
                transform .2s,
                box-shadow .2s;
        }

        .btn:hover {
            transform: translateY(-2px);
        }

        .btn-primary {
            background: #0891b2;
            border-color: #22d3ee;
            color: #ffffff !important;
        }

        .btn-primary:hover {
            background: #0e7490;
            box-shadow: 0 0 22px rgba(34, 211, 238, .20);
        }

        .btn-secondary {
            background: #172239;
            border-color: #475569;
            color: #ffffff !important;
        }

        .btn-secondary:hover {
            background: #25344e;
            border-color: #22d3ee;
        }

        .eyebrow {
            display: inline-flex;
            align-items: center;
            gap: 8px;
            padding: 8px 13px;
            background: #103548;
            border: 1px solid #155e75;
            border-radius: 999px;
            color: #a5f3fc !important;
            font-size: 11px;
            font-weight: 800;
            letter-spacing: .6px;
            text-transform: uppercase;
        }

        /* Animated hero */

        .hero {
            position: relative;
            isolation: isolate;
            overflow: hidden;
            padding: 90px 0 75px;
            text-align: center;
        }

        .hero::before {
            content: "";
            position: absolute;
            z-index: 0;
            top: 20px;
            left: 50%;
            width: min(700px, 100%);
            height: 370px;
            transform: translateX(-50%);
            background: radial-gradient(
                ellipse,
                rgba(8, 145, 178, .14),
                transparent 70%
            );
            pointer-events: none;
        }

        .neural-network-canvas {
            position: absolute;
            inset: 0;
            z-index: 0;
            display: block;
            width: 100%;
            height: 100%;
            opacity: .58;
            pointer-events: none;
        }

        .hero-content {
            position: relative;
            z-index: 1;
        }

        .hero h1 {
            max-width: 870px;
            margin: 25px auto 20px;
            font-size: clamp(36px, 6.5vw, 68px);
            font-weight: 850;
            letter-spacing: -2px;
            line-height: 1.13;
            text-shadow: 0 2px 22px rgba(8, 14, 30, .8);
        }

        .accent {
            color: #67e8f9 !important;
        }

        .hero-description {
            max-width: 720px;
            margin: 0 auto 28px;
            color: #cbd5e1 !important;
            font-size: clamp(14px, 2vw, 17px);
            line-height: 1.85;
            text-shadow: 0 2px 14px #080e1e;
        }

        .hero-actions {
            display: flex;
            justify-content: center;
            flex-wrap: wrap;
            gap: 12px;
            margin-top: 30px;
        }

        .hero-note {
            margin-top: 17px;
            color: #94a3b8 !important;
            font-size: 12px;
        }

        /* Statistics */

        .stats {
            display: grid;
            grid-template-columns: repeat(3, minmax(0, 1fr));
            gap: 16px;
            margin-top: 55px;
        }

        .stat-card,
        .feature-card,
        .phase-card {
            background: #131e33;
            border: 1px solid #30415b;
            border-radius: 15px;
        }

        .stat-card {
            padding: 24px;
        }

        .stat-number {
            color: #67e8f9 !important;
            font-size: clamp(27px, 4vw, 38px);
            font-weight: 850;
            line-height: 1.2;
        }

        .stat-label {
            margin-top: 7px;
            color: #cbd5e1 !important;
            font-size: 12px;
            font-weight: 700;
        }

        /* General sections */

        .section {
            padding: 70px 0;
        }

        .section-heading {
            margin-bottom: 35px;
        }

        .section-kicker {
            color: #67e8f9 !important;
            font-size: 12px;
            font-weight: 800;
            letter-spacing: 1.4px;
            text-transform: uppercase;
        }

        .section-heading h2 {
            margin: 12px 0;
            font-size: clamp(25px, 4vw, 36px);
            letter-spacing: -.8px;
        }

        .section-description {
            max-width: 740px;
            color: #cbd5e1 !important;
            font-size: 14px;
            line-height: 1.85;
        }

        /* Feature cards */

        .feature-grid {
            display: grid;
            grid-template-columns: repeat(3, minmax(0, 1fr));
            gap: 17px;
        }

        .feature-card {
            padding: 25px;
            transition:
                border-color .2s,
                transform .2s;
        }

        .feature-card:hover,
        .phase-card:hover {
            border-color: #0891b2;
            transform: translateY(-2px);
        }

        .feature-icon {
            display: inline-grid;
            place-items: center;
            width: 45px;
            height: 45px;
            margin-bottom: 20px;
            background: #103548;
            border: 1px solid #155e75;
            border-radius: 11px;
            color: #67e8f9;
            font-size: 20px;
        }

        .feature-card h3 {
            margin-bottom: 8px;
            font-size: 17px;
        }

        .feature-card p {
            margin-bottom: 0;
            color: #cbd5e1 !important;
            font-size: 13px;
            line-height: 1.8;
        }

        /* Roadmap phase cards */

        .phase-grid {
            display: grid;
            grid-template-columns: repeat(3, minmax(0, 1fr));
            gap: 15px;
        }

        .phase-card {
            padding: 21px;
            transition:
                border-color .2s,
                transform .2s;
        }

        .phase-number {
            color: #67e8f9 !important;
            font-size: 11px;
            font-weight: 850;
            letter-spacing: .7px;
            text-transform: uppercase;
        }

        .phase-card h3 {
            margin: 11px 0 8px;
            font-size: 15px;
            font-weight: 800;
        }

        .phase-weeks {
            color: #94a3b8 !important;
            font-size: 12px;
        }

        /* How it works */

        .how-grid {
            display: grid;
            grid-template-columns: repeat(3, minmax(0, 1fr));
            gap: 17px;
        }

        .step {
            padding: 25px;
            background: #131e33;
            border: 1px solid #30415b;
            border-radius: 14px;
        }

        .step-number {
            color: #67e8f9;
            font-size: 28px;
            font-weight: 850;
        }

        .step h3 {
            margin: 12px 0;
            font-size: 17px;
        }

        .step p {
            color: #cbd5e1 !important;
            font-size: 13px;
            line-height: 1.8;
        }

        /* Request access */

        .access-panel {
            padding: 48px 35px;
            background: linear-gradient(
                135deg,
                #131e33 0%,
                #103548 100%
            );
            border: 1px solid #155e75;
            border-radius: 20px;
            text-align: center;
        }

        .access-panel h2 {
            margin: 14px auto;
            font-size: clamp(24px, 4vw, 34px);
        }

        .access-panel p {
            max-width: 630px;
            margin: 0 auto 20px;
            color: #cbd5e1 !important;
            font-size: 14px;
            line-height: 1.85;
        }

        .contact-email {
            display: inline-block;
            margin: 0 0 25px;
            color: #a5f3fc !important;
            font-size: 15px;
            font-weight: 800;
            overflow-wrap: anywhere;
        }

        .access-note {
            margin-top: 20px !important;
            color: #94a3b8 !important;
            font-size: 12px !important;
        }

        /* Footer */

        .footer {
            margin-top: 25px;
            padding: 28px 0;
            border-top: 1px solid #263349;
        }

        .footer-inner {
            display: flex;
            justify-content: space-between;
            align-items: center;
            gap: 16px;
            flex-wrap: wrap;
            color: #94a3b8;
            font-size: 12px;
        }

        .footer a {
            color: #67e8f9 !important;
        }

        .np a:focus-visible {
            outline: 3px solid #67e8f9;
            outline-offset: 4px;
        }

        /* Responsive */

        @media (max-width: 800px) {
            .feature-grid,
            .phase-grid,
            .how-grid {
                grid-template-columns: repeat(2, minmax(0, 1fr));
            }

            .hero {
                padding: 65px 0 45px;
            }
        }

        @media (max-width: 600px) {
            .nav {
                padding: 17px 0;
            }

            .nav-links {
                gap: 12px;
            }

            .nav-links .section-nav {
                display: none;
            }

            .hero h1 {
                letter-spacing: -1px;
            }

            .neural-network-canvas {
                opacity: .35;
            }

            .stats {
                grid-template-columns: repeat(3, minmax(0, 1fr));
                gap: 9px;
            }

            .stat-card {
                padding: 17px 10px;
            }

            .feature-grid,
            .phase-grid,
            .how-grid {
                grid-template-columns: 1fr;
            }

            .section {
                padding: 45px 0;
            }

            .access-panel {
                padding: 35px 20px;
            }

            .hero-actions .btn {
                width: 100%;
            }
        }

        @media (prefers-reduced-motion: reduce) {
            :root {
                scroll-behavior: auto;
            }

            .np * {
                transition: none !important;
            }

            .neural-network-canvas {
                opacity: .25;
            }
        }
    </style>
</head>

<body class="np">

<!-- Header -->
<header class="header">
    <div class="shell">
        <nav class="nav" aria-label="Main navigation">

            <a href="{{ url('/') }}" class="brand">
                <span class="brand-symbol" aria-hidden="true">◈</span>
                NeuralPath
            </a>

            <div class="nav-links">
                <a class="nav-link section-nav" href="#features">
                    Features
                </a>

                <a class="nav-link section-nav" href="#roadmap">
                    Roadmap
                </a>

                <a class="nav-link section-nav" href="#how-it-works">
                    How It Works
                </a>

                @auth
                    <a
                        class="btn btn-secondary"
                        href="{{ auth()->user()->isAdmin()
                            ? route('admin.dashboard')
                            : route('learner.dashboard') }}"
                    >
                        My Dashboard →
                    </a>
                @else
                    <a
                        class="btn btn-secondary"
                        href="{{ route('login') }}"
                    >
                        Sign In
                    </a>
                @endauth
            </div>

        </nav>
    </div>
</header>

<main>

    <!-- Hero with animated neural network -->
    <section class="hero">

        <canvas
            id="neural-network-canvas"
            class="neural-network-canvas"
            aria-hidden="true"
        ></canvas>

        <div class="shell hero-content">

            <span class="eyebrow">
                ◉ Invitation-Only Learning Platform
            </span>

            <h1>
                Your Structured Path to
                <span class="accent">
                    Agentic AI Engineering
                </span>
            </h1>

            <p class="hero-description">
                NeuralPath is a private learning platform designed
                to help aspiring AI engineers build practical skills
                through a structured 60-week roadmap, curated
                learning resources, hands-on projects, and
                personalized progress tracking.
            </p>

            <div class="hero-actions">
                <a
                    href="#roadmap"
                    class="btn btn-primary"
                >
                    Explore the Learning Path →
                </a>

                <a
                    href="mailto:mejbahu475@gmail.com?subject=NeuralPath%20Access%20Request"
                    class="btn btn-secondary"
                >
                    ✉ Request Access
                </a>
            </div>

            <p class="hero-note">
                Private access · Structured roadmap · Learn at your own pace
            </p>

            <div class="stats">
                <article class="stat-card">
                    <div class="stat-number">60</div>
                    <div class="stat-label">Learning Weeks</div>
                </article>

                <article class="stat-card">
                    <div class="stat-number">9</div>
                    <div class="stat-label">Learning Phases</div>
                </article>

                <article class="stat-card">
                    <div class="stat-number">131</div>
                    <div class="stat-label">Planned Topics</div>
                </article>
            </div>

        </div>
    </section>

    <!-- Platform features -->
    <section class="section" id="features">
        <div class="shell">

            <div class="section-heading">
                <div class="section-kicker">
                    Platform Features
                </div>

                <h2>A Clear Roadmap. Real Progress.</h2>

                <p class="section-description">
                    NeuralPath brings learning structure, selected
                    resources, and progress tracking together in one
                    place, helping learners stay focused on becoming
                    capable AI engineers.
                </p>
            </div>

            <div class="feature-grid">

                <article class="feature-card">
                    <div class="feature-icon" aria-hidden="true">▤</div>
                    <h3>Structured Learning Roadmap</h3>
                    <p>
                        Follow organized learning phases and modules
                        with weekly targets covering foundational
                        engineering through advanced AI systems.
                    </p>
                </article>

                <article class="feature-card">
                    <div class="feature-icon" aria-hidden="true">↗</div>
                    <h3>Curated Learning Resources</h3>
                    <p>
                        Access administrator-approved documentation,
                        tutorials, and learning references associated
                        with individual topics.
                    </p>
                </article>

                <article class="feature-card">
                    <div class="feature-icon" aria-hidden="true">✓</div>
                    <h3>Topic Completion Tracking</h3>
                    <p>
                        Mark topics complete, undo completion when
                        needed, and keep personal learning records.
                    </p>
                </article>

                <article class="feature-card">
                    <div class="feature-icon" aria-hidden="true">◫</div>
                    <h3>Personal Learning Dashboard</h3>
                    <p>
                        Monitor completion percentages, published
                        learning phases, and your next available topic.
                    </p>
                </article>

                <article class="feature-card">
                    <div class="feature-icon" aria-hidden="true">⌘</div>
                    <h3>Practical AI Engineering</h3>
                    <p>
                        Study LLM applications, retrieval systems,
                        agents, MCP integrations, evaluation,
                        security, and production operations.
                    </p>
                </article>

                <article class="feature-card">
                    <div class="feature-icon" aria-hidden="true">◇</div>
                    <h3>Private Learning Environment</h3>
                    <p>
                        Access is invitation-only, with account
                        verification and separate administrator
                        permissions.
                    </p>
                </article>

            </div>

        </div>
    </section>

    <!-- Learning roadmap -->
    <section class="section" id="roadmap">
        <div class="shell">

            <div class="section-heading">
                <div class="section-kicker">
                    The Learning Path
                </div>

                <h2>
                    From Foundations to Production AI Systems
                </h2>

                <p class="section-description">
                    The complete roadmap covers 60 weeks across
                    nine phases. Individual lessons are made
                    available as they are reviewed and published
                    by the administrator.
                </p>
            </div>

            @php
                $roadmapPreview = [
                    [0, 'Software Engineering Foundations', '1–4'],
                    [1, 'LLM Engineering and RAG', '5–12'],
                    [2, 'AI Agents and Frameworks', '13–22'],
                    [3, 'MCP and Tool Integrations', '23–28'],
                    [4, 'Multi-Agent Systems', '29–33'],
                    [5, 'Evaluation and Reliability', '34–39'],
                    [6, 'AI Safety and Security', '40–43'],
                    [7, 'Production and LLMOps', '44–51'],
                    [8, 'Specialization and Capstone', '52–60'],
                ];
            @endphp

            <div class="phase-grid">

                @foreach($roadmapPreview as [$number, $name, $weeks])
                    <article class="phase-card">
                        <div class="phase-number">
                            Phase {{ $number }}
                        </div>

                        <h3>{{ $name }}</h3>

                        <div class="phase-weeks">
                            Weeks {{ $weeks }}
                        </div>
                    </article>
                @endforeach

            </div>

        </div>
    </section>

    <!-- How it works -->
    <section class="section" id="how-it-works">
        <div class="shell">

            <div class="section-heading">
                <div class="section-kicker">
                    Getting Started
                </div>

                <h2>How NeuralPath Works</h2>
            </div>

            <div class="how-grid">

                <article class="step">
                    <div class="step-number">01</div>
                    <h3>Request an Invitation</h3>
                    <p>
                        Contact the administrator by email.
                        Approved users receive a private
                        invitation to create an account.
                    </p>
                </article>

                <article class="step">
                    <div class="step-number">02</div>
                    <h3>Explore the Roadmap</h3>
                    <p>
                        After signing in, browse published
                        learning phases, modules, topics,
                        and available resources.
                    </p>
                </article>

                <article class="step">
                    <div class="step-number">03</div>
                    <h3>Track Your Progress</h3>
                    <p>
                        Complete topics at your own pace
                        and monitor your progress through
                        the learner dashboard.
                    </p>
                </article>

            </div>

        </div>
    </section>

    <!-- Request access -->
    <section class="section" id="request-access">
        <div class="shell">

            <div class="access-panel">

                <span class="eyebrow">
                    Private Membership
                </span>

                <h2>
                    Ready to Start Your AI Engineering Journey?
                </h2>

                <p>
                    NeuralPath is currently an invitation-only
                    learning platform. To request access, email the
                    administrator with your name and a brief
                    introduction explaining your interest in
                    Agentic AI Engineering.
                </p>

                <a
                    class="contact-email"
                    href="mailto:mejbahu475@gmail.com"
                >
                    mejbahu475@gmail.com
                </a>

                <div>
                    <a
                        class="btn btn-primary"
                        href="mailto:mejbahu475@gmail.com?subject=NeuralPath%20Access%20Request&amp;body=Hello%2C%0A%0AI%20would%20like%20to%20request%20access%20to%20NeuralPath.%0A%0AName%3A%20%0AReason%20for%20joining%3A%20%0A%0AThank%20you."
                    >
                        ✉ Email Administrator to Request Access →
                    </a>
                </div>

                <p class="access-note">
                    The button opens your email application.
                    Access requests are reviewed before
                    invitations are issued.
                </p>

            </div>

        </div>
    </section>

</main>

<!-- Footer -->
<footer class="footer">
    <div class="shell footer-inner">

        <span>
            © {{ date('Y') }} NeuralPath.
            Agentic AI Engineering Learning Platform.
        </span>

        <span>
            <a href="{{ url('/') }}">Home</a>
            ·
            <a href="#request-access">Request Access</a>
            ·
            <a href="{{ route('login') }}">Sign In</a>
        </span>

    </div>
</footer>

<!-- Animated AI neural network -->
<script>
(() => {
    'use strict';

    const canvas = document.getElementById(
        'neural-network-canvas'
    );

    if (!canvas) {
        return;
    }

    const ctx = canvas.getContext('2d');

    if (!ctx) {
        return;
    }

    const hero = canvas.parentElement;

    const motionPreference = window.matchMedia(
        '(prefers-reduced-motion: reduce)'
    );

    let reducedMotion = motionPreference.matches;

    let width = 0;
    let height = 0;
    let nodes = [];
    let animationFrame = null;

    const connectionDistance = 145;

    const nodeCount = window.innerWidth < 600
        ? 22
        : 55;

    function createNodes() {
        nodes = Array.from(
            { length: nodeCount },
            () => ({
                x: Math.random() * width,
                y: Math.random() * height,
                vx: (Math.random() - 0.5) * 0.28,
                vy: (Math.random() - 0.5) * 0.28,
                radius: 1.5 + Math.random() * 1.6
            })
        );
    }

    function resize() {
        const previousWidth = width;
        const previousHeight = height;

        width = hero.clientWidth;
        height = hero.clientHeight;

        const pixelRatio = Math.min(
            window.devicePixelRatio || 1,
            2
        );

        canvas.width = Math.round(width * pixelRatio);
        canvas.height = Math.round(height * pixelRatio);

        ctx.setTransform(
            pixelRatio,
            0,
            0,
            pixelRatio,
            0,
            0
        );

        if (nodes.length === 0) {
            createNodes();
        } else if (previousWidth > 0 && previousHeight > 0) {
            const scaleX = width / previousWidth;
            const scaleY = height / previousHeight;

            nodes.forEach(node => {
                node.x *= scaleX;
                node.y *= scaleY;
            });
        }

        draw(0);
    }

    function drawConnections(time) {
        for (let i = 0; i < nodes.length; i++) {
            for (let j = i + 1; j < nodes.length; j++) {
                const first = nodes[i];
                const second = nodes[j];

                const dx = first.x - second.x;
                const dy = first.y - second.y;

                const distance = Math.hypot(dx, dy);

                if (distance >= connectionDistance) {
                    continue;
                }

                const strength =
                    1 - distance / connectionDistance;

                ctx.beginPath();
                ctx.moveTo(first.x, first.y);
                ctx.lineTo(second.x, second.y);

                ctx.strokeStyle =
                    `rgba(34, 211, 238, ${strength * 0.3})`;

                ctx.lineWidth = 0.8;
                ctx.stroke();

                // A moving light represents data traveling
                // between connected neural network nodes.
                if (!reducedMotion && (i + j) % 7 === 0) {
                    const progress =
                        (
                            time * 0.0003 +
                            i * 0.13 +
                            j * 0.07
                        ) % 1;

                    const signalX =
                        first.x +
                        (second.x - first.x) * progress;

                    const signalY =
                        first.y +
                        (second.y - first.y) * progress;

                    ctx.beginPath();

                    ctx.arc(
                        signalX,
                        signalY,
                        1.5,
                        0,
                        Math.PI * 2
                    );

                    ctx.fillStyle =
                        `rgba(103, 232, 249, ${strength * 0.8})`;

                    ctx.fill();
                }
            }
        }
    }

    function drawNodes() {
        nodes.forEach(node => {
            ctx.beginPath();

            ctx.arc(
                node.x,
                node.y,
                node.radius,
                0,
                Math.PI * 2
            );

            ctx.fillStyle = 'rgba(103, 232, 249, 0.8)';
            ctx.shadowBlur = 12;
            ctx.shadowColor = '#22d3ee';

            ctx.fill();

            ctx.shadowBlur = 0;
        });
    }

    function moveNodes() {
        nodes.forEach(node => {
            node.x += node.vx;
            node.y += node.vy;

            if (node.x <= 0) {
                node.x = 0;
                node.vx = Math.abs(node.vx);
            }

            if (node.x >= width) {
                node.x = width;
                node.vx = -Math.abs(node.vx);
            }

            if (node.y <= 0) {
                node.y = 0;
                node.vy = Math.abs(node.vy);
            }

            if (node.y >= height) {
                node.y = height;
                node.vy = -Math.abs(node.vy);
            }
        });
    }

    function draw(time = 0) {
        ctx.clearRect(0, 0, width, height);

        drawConnections(time);
        drawNodes();
    }

    function animate(time) {
        if (document.hidden || reducedMotion) {
            animationFrame = null;
            return;
        }

        draw(time);
        moveNodes();

        animationFrame = requestAnimationFrame(animate);
    }

    function startAnimation() {
        if (
            animationFrame === null &&
            !document.hidden &&
            !reducedMotion
        ) {
            animationFrame = requestAnimationFrame(animate);
        }
    }

    function stopAnimation() {
        if (animationFrame !== null) {
            cancelAnimationFrame(animationFrame);
            animationFrame = null;
        }
    }

    resize();

    const resizeObserver = new ResizeObserver(resize);
    resizeObserver.observe(hero);

    startAnimation();

    document.addEventListener(
        'visibilitychange',
        () => {
            if (document.hidden) {
                stopAnimation();
            } else {
                startAnimation();
            }
        }
    );

    const handleMotionChange = event => {
        reducedMotion = event.matches;

        if (reducedMotion) {
            stopAnimation();
            draw(0);
        } else {
            startAnimation();
        }
    };

    if (motionPreference.addEventListener) {
        motionPreference.addEventListener(
            'change',
            handleMotionChange
        );
    }

    window.addEventListener(
        'pagehide',
        () => {
            stopAnimation();
            resizeObserver.disconnect();
        },
        { once: true }
    );
})();
</script>

</body>
</html>
