
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, initial-scale=1">

    <title>Admin Dashboard | NeuralPath</title>

    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body class="min-h-screen bg-slate-950 text-white">

    <main class="mx-auto max-w-6xl px-6 py-12">

        <div class="flex flex-wrap items-center justify-between gap-4">

            <div>
                <h1 class="text-3xl font-bold text-cyan-400">
                    NeuralPath Admin
                </h1>

                <p class="mt-2 text-slate-400">
                    Welcome, {{ auth()->user()->name }}!
                </p>
            </div>

            <form method="POST" action="{{ route('logout') }}">
                @csrf

                <button type="submit"
                    class="rounded-lg border border-slate-700
                           px-4 py-2 hover:bg-slate-800">
                    Logout
                </button>
            </form>

        </div>

        <section class="mt-10 grid gap-5 md:grid-cols-3">

            <div class="rounded-xl border border-slate-800
                        bg-slate-900 p-6">
                <h2 class="text-lg font-semibold">
                    User Management
                </h2>

                <p class="mt-2 text-sm text-slate-400">
                    Manage approved learners and invitations.
                </p>
            </div>

            <div class="rounded-xl border border-slate-800
                        bg-slate-900 p-6">
                <h2 class="text-lg font-semibold">
                    Learning Roadmap
                </h2>

                <p class="mt-2 text-sm text-slate-400">
                    Organize branches, topics and resources.
                </p>
            </div>

            <div class="rounded-xl border border-slate-800
                        bg-slate-900 p-6">
                <h2 class="text-lg font-semibold">
                    Progress Analytics
                </h2>

                <p class="mt-2 text-sm text-slate-400">
                    Monitor learning and project progress.
                </p>
            </div>

        </section>

    </main>

</body>
</html>
