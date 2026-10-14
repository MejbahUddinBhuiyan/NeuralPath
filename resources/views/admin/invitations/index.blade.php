
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, initial-scale=1">

    <title>Invitations | NeuralPath</title>

    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body class="min-h-screen bg-slate-950 text-white">

<main class="mx-auto max-w-5xl px-6 py-12">

    <a href="{{ route('admin.dashboard') }}"
       class="text-sm text-cyan-400 hover:underline">
        ← Back to Dashboard
    </a>

    <div class="mt-6">
        <h1 class="text-3xl font-bold">
            Learner Invitations
        </h1>

        <p class="mt-2 text-slate-400">
            Invite approved learners to NeuralPath.
        </p>
    </div>

    @if (session('success'))
        <div class="mt-6 rounded-xl border border-emerald-800
                    bg-emerald-950 p-4 text-emerald-300">
            {{ session('success') }}
        </div>
    @endif

    <section class="mt-8 rounded-2xl border border-slate-800
                    bg-slate-900 p-6">

        <h2 class="text-lg font-semibold">
            Send New Invitation
        </h2>

        <form method="POST"
              action="{{ route('admin.invitations.store') }}"
              class="mt-5 space-y-4">

            @csrf

            <div>
                <label for="email"
                       class="mb-2 block text-sm">
                    Learner Email Address
                </label>

                <input
                    type="email"
                    name="email"
                    id="email"
                    value="{{ old('email') }}"
                    required
                    class="w-full rounded-lg border border-slate-700
                           bg-slate-800 px-4 py-3 text-white
                           focus:border-cyan-400 focus:outline-none"
                    placeholder="learner@example.com"
                >

                @error('email')
                    <p class="mt-2 text-sm text-red-400">
                        {{ $message }}
                    </p>
                @enderror
            </div>

            <button type="submit"
                    class="rounded-lg bg-cyan-400 px-5 py-3
                           font-semibold text-slate-950
                           hover:bg-cyan-300">
                Send Invitation
            </button>
        </form>
    </section>

    <section class="mt-10">
        <h2 class="text-xl font-semibold">
            Invitation History
        </h2>

        <div class="mt-5 overflow-x-auto rounded-xl
                    border border-slate-800">

            <table class="w-full text-left text-sm">
                <thead class="bg-slate-900 text-slate-400">
                    <tr>
                        <th class="p-4">Email</th>
                        <th class="p-4">Status</th>
                        <th class="p-4">Expiration</th>
                    </tr>
                </thead>

                <tbody>
                    @forelse ($invitations as $invitation)
                        <tr class="border-t border-slate-800">
                            <td class="p-4">
                                {{ $invitation->email }}
                            </td>

                            <td class="p-4">
                                @if ($invitation->accepted_at)
                                    Accepted
                                @elseif ($invitation->expires_at->isPast())
                                    Expired
                                @else
                                    Pending
                                @endif
                            </td>

                            <td class="p-4 text-slate-400">
                                {{ $invitation->expires_at->format('d M Y, h:i A') }}
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="3"
                                class="p-6 text-center text-slate-400">
                                No invitations yet.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <div class="mt-5">
            {{ $invitations->links() }}
        </div>
    </section>

</main>
</body>
</html>
