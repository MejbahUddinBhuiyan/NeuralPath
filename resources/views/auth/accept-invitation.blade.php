
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, initial-scale=1">

    <meta name="referrer" content="no-referrer">

    <title>Join NeuralPath</title>

    @vite([
        'resources/css/app.css',
        'resources/js/app.js'
    ])
</head>

<body class="min-h-screen bg-slate-950 text-white">

<main class="flex min-h-screen items-center
             justify-center px-5 py-12">

    <section class="w-full max-w-md rounded-2xl
                    border border-slate-800
                    bg-slate-900 p-8 shadow-2xl">

        <div class="mb-8 text-center">

            <h1 class="text-3xl font-bold text-cyan-400">
                NeuralPath
            </h1>

            <p class="mt-2 text-sm text-slate-400">
                Start your AI engineering journey
            </p>

        </div>

        <h2 class="text-xl font-semibold">
            Complete Your Registration
        </h2>

        <p class="mt-2 text-sm text-slate-400">
            You've been invited to join NeuralPath.
            Create your password to activate your account.
        </p>

        @if ($errors->any())
            <div class="mt-5 rounded-lg border border-red-800
                        bg-red-950 p-3 text-sm text-red-300">
                {{ $errors->first() }}
            </div>
        @endif

        <form
            method="POST"
            action="{{ route('invitations.complete', ['token' => $token]) }}"
            class="mt-7 space-y-5"
        >
            @csrf

            <div>
                <label class="mb-2 block text-sm">
                    Full Name
                </label>

                <input
                    type="text"
                    name="name"
                    value="{{ old('name') }}"
                    required
                    maxlength="255"
                    autocomplete="name"
                    class="w-full rounded-lg border border-slate-700
                           bg-slate-800 px-4 py-3 text-white
                           outline-none focus:border-cyan-400"
                    placeholder="Enter your full name"
                >
            </div>

            <div>
                <label class="mb-2 block text-sm">
                    Approved Email
                </label>

                <input
                    type="email"
                    value="{{ $invitation->email }}"
                    disabled
                    class="w-full rounded-lg border border-slate-700
                           bg-slate-800 px-4 py-3 text-slate-400"
                >
            </div>

            <div>
                <label class="mb-2 block text-sm">
                    Create Password
                </label>

                <input
                    type="password"
                    name="password"
                    required
                    autocomplete="new-password"
                    class="w-full rounded-lg border border-slate-700
                           bg-slate-800 px-4 py-3 text-white
                           outline-none focus:border-cyan-400"
                >

                <p class="mt-2 text-xs text-slate-400">
                    Use at least 12 characters, including
                    uppercase, lowercase, number and symbol.
                </p>
            </div>

            <div>
                <label class="mb-2 block text-sm">
                    Confirm Password
                </label>

                <input
                    type="password"
                    name="password_confirmation"
                    required
                    autocomplete="new-password"
                    class="w-full rounded-lg border border-slate-700
                           bg-slate-800 px-4 py-3 text-white
                           outline-none focus:border-cyan-400"
                >
            </div>

            <button
                type="submit"
                class="w-full rounded-lg bg-cyan-400 px-4 py-3
                       font-semibold text-slate-950
                       transition hover:bg-cyan-300"
            >
                Create My Account
            </button>
        </form>

        <p class="mt-6 text-center text-sm text-slate-400">
            Already registered?
            <a href="{{ route('login') }}"
               class="text-cyan-400 hover:underline">
                Sign in
            </a>
        </p>

    </section>

</main>
</body>
</html>
