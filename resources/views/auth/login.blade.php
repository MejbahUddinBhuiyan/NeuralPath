
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, initial-scale=1">

    <title>Login | NeuralPath</title>

    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body class="min-h-screen bg-slate-950 text-white">

    <main class="flex min-h-screen items-center justify-center p-6">

        <div class="w-full max-w-md rounded-2xl border
                    border-slate-800 bg-slate-900 p-8 shadow-2xl">

            <div class="mb-8 text-center">
                <h1 class="text-3xl font-bold text-cyan-400">
                    NeuralPath
                </h1>

                <p class="mt-2 text-sm text-slate-400">
                    Your AI Engineering Workspace
                </p>
            </div>

            @if ($errors->any())
                <div class="mb-5 rounded-lg bg-red-500/10 p-3 text-sm text-red-300">
                    {{ $errors->first() }}
                </div>
            @endif
            @if (session('status'))
                <div class="mb-5 rounded-lg border border-emerald-800
                        bg-emerald-950 p-3 text-sm text-emerald-300">
                        {{ session('status') }}
                </div>
            @endif
            <form method="POST" action="{{ route('login.store') }}"
                  class="space-y-5">

                @csrf

                <div>
                    <label for="email" class="mb-2 block text-sm">
                        Email Address
                    </label>

                    <input type="email"
                           name="email"
                           id="email"
                           value="{{ old('email') }}"
                           required
                           autocomplete="username"
                           class="w-full rounded-lg border border-slate-700
                                  bg-slate-800 px-4 py-3 outline-none
                                  focus:border-cyan-400">
                </div>

                <div>
                    <label for="password" class="mb-2 block text-sm">
                        Password
                    </label>

                    <input type="password"
                           name="password"
                           id="password"
                           required
                           autocomplete="current-password"
                           class="w-full rounded-lg border border-slate-700
                                  bg-slate-800 px-4 py-3 outline-none
                                  focus:border-cyan-400">
                </div>

                <label class="flex items-center gap-2 text-sm text-slate-300">
                    <input type="checkbox" name="remember" value="1">
                    Remember me
                </label>

                <button type="submit"
                        class="w-full rounded-lg bg-cyan-400
                               px-4 py-3 font-semibold text-slate-950
                               hover:bg-cyan-300">
                    Sign In
                </button>
            </form>

            <p class="mt-6 text-center text-sm text-slate-400">
                Access is restricted to approved members.
            </p>
        </div>

    </main>

</body>
</html>
