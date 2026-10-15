
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, initial-scale=1">

    <title>My Dashboard | NeuralPath</title>

    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body class="min-h-screen bg-slate-950 text-white">

    <main class="mx-auto max-w-6xl px-6 py-10">

        <header class="flex flex-wrap items-center
                       justify-between gap-4">

            <div>
                <h1 class="text-3xl font-bold text-cyan-400">
                    NeuralPath
                </h1>

                <p class="mt-2 text-slate-400">
                    Welcome back, {{ auth()->user()->name }}!
                </p>
            </div>

            <form method="POST" action="{{ route('logout') }}">
                @csrf

                <button type="submit"
                    class="rounded-lg border border-slate-700
                           px-5 py-2 hover:bg-slate-800">
                    Logout
                </button>
            </form>
        </header>

        <section class="mt-10">
            <h2 class="text-2xl font-semibold">
                Your AI Engineering Journey
            </h2>

            <p class="mt-2 text-slate-400">
                Track your learning, improve your skills,
                and build real-world projects.
            </p>
        </section>

        <section class="mt-8 grid gap-5 md:grid-cols-3">

            <div class="rounded-xl border border-slate-800
                        bg-slate-900 p-6">
                <p class="text-sm text-slate-400">
                    Overall Progress
                </p>
                <p class="mt-3 text-3xl font-bold text-cyan-400">
                    Coming Soon
                </p>
            </div>

            <div class="rounded-xl border border-slate-800
                        bg-slate-900 p-6">
                <p class="text-sm text-slate-400">
                    Current Branch
                </p>
                <p class="mt-3 text-xl font-semibold">
                    Python Engineering
                </p>
            </div>

            <div class="rounded-xl border border-slate-800
                        bg-slate-900 p-6">
                <p class="text-sm text-slate-400">
                    Learning Projects
                </p>
                <p class="mt-3 text-3xl font-bold text-cyan-400">
                    5 Planned
                </p>
            </div>

        </section>

        <section class="mt-8 rounded-2xl border border-slate-800
                        bg-slate-900 p-6">

            <h3 class="text-xl font-semibold">
                Continue Learning
            </h3>

            <p class="mt-2 text-slate-400">
                Your first branch is Python Engineering.
                Topics and checklists will appear here
                when the roadmap module is ready.
            </p>

            <div class="mt-5 rounded-xl border border-slate-700
                        bg-slate-800 p-4">

                <p class="font-medium">
                    Python Fundamentals
                </p>

                <p class="mt-1 text-sm text-slate-400">
                    Variables, data types, functions,
                    OOP, and asynchronous programming.
                </p>

                <span class="mt-3 inline-block text-sm text-cyan-400">
                    Not Started
                </span>
            </div>
            
<a href="{{ route('learner.roadmap.index') }}"
   style="
       display:inline-flex;
       align-items:center;
       gap:10px;
       margin-top:22px;
       padding:12px 20px;
       background:#0891b2;
       color:#ffffff;
       border:1px solid #22d3ee;
       border-radius:10px;
       font-weight:700;
       text-decoration:none;
       transition:background .2s, transform .2s;
   "
   onmouseover="this.style.background='#06b6d4';this.style.transform='translateY(-2px)'"
   onmouseout="this.style.background='#0891b2';this.style.transform='translateY(0)'">
    Explore Learning Roadmap →
</a>


        </section>


    </main>

</body>
</html>
