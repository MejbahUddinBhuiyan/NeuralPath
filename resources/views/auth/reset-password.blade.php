
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>Reset Password | NeuralPath</title>

    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <style>
        * { box-sizing: border-box; }

        body {
            margin: 0;
            min-height: 100vh;
            background: #080e1e;
            color: #ffffff;
            font-family: Inter, ui-sans-serif, system-ui, sans-serif;
        }

        .page {
            min-height: 100vh;
            display: flex;
            justify-content: center;
            align-items: center;
            padding: 24px;
        }

        .card {
            width: 100%;
            max-width: 450px;
            padding: 35px;
            background: #131e33;
            border: 1px solid #30415b;
            border-radius: 18px;
        }

        .brand {
            color: #67e8f9;
            font-size: 25px;
            font-weight: 850;
            text-decoration: none;
        }

        h1 {
            margin: 25px 0 10px;
            font-size: 24px;
        }

        .description {
            margin-bottom: 25px;
            color: #cbd5e1;
            font-size: 13px;
            line-height: 1.8;
        }

        .field {
            margin-bottom: 18px;
        }

        label {
            display: block;
            margin-bottom: 8px;
            font-size: 13px;
            font-weight: 700;
        }

        input {
            width: 100%;
            padding: 12px 13px;
            border: 1px solid #475569;
            border-radius: 9px;
            background: #1d2a40;
            color: #ffffff;
            font: inherit;
        }

        input:focus {
            outline: 2px solid #22d3ee;
        }

        button {
            width: 100%;
            padding: 13px;
            background: #0891b2;
            border: 1px solid #22d3ee;
            border-radius: 9px;
            color: #ffffff;
            font-weight: 800;
            cursor: pointer;
        }

        button:hover {
            background: #0e7490;
        }

        .error {
            margin-top: 8px;
            color: #fda4af;
            font-size: 12px;
        }

        .back {
            display: block;
            margin-top: 25px;
            color: #67e8f9;
            text-align: center;
            text-decoration: none;
            font-size: 13px;
        }
    </style>
</head>

<body>
<main class="page">

    <section class="card" aria-label="Reset password">

        <a href="{{ url('/') }}" class="brand">
            ◈ NeuralPath
        </a>

        <h1>Create a new password</h1>

        <p class="description">
            Enter your account email and choose a strong
            new password to recover access to NeuralPath.
        </p>

        @if($errors->any())
            <div class="error" role="alert">
                {{ $errors->first() }}
            </div>
        @endif

        <form method="POST" action="{{ route('password.update') }}">
            @csrf

            <input
                type="hidden"
                name="token"
                value="{{ $request->route('token') }}"
            >

            <div class="field">
                <label for="email">Email Address</label>

                <input
                    id="email"
                    type="email"
                    name="email"
                    value="{{ old('email', $request->email) }}"
                    autocomplete="email"
                    required
                >

                @error('email')
                    <p class="error">{{ $message }}</p>
                @enderror
            </div>

            <div class="field">
                <label for="password">New Password</label>

                <input
                    id="password"
                    type="password"
                    name="password"
                    autocomplete="new-password"
                    minlength="8"
                    required
                >

                @error('password')
                    <p class="error">{{ $message }}</p>
                @enderror
            </div>

            <div class="field">
                <label for="password_confirmation">
                    Confirm New Password
                </label>

                <input
                    id="password_confirmation"
                    type="password"
                    name="password_confirmation"
                    autocomplete="new-password"
                    minlength="8"
                    required
                >
            </div>

            <button type="submit">
                Reset Password →
            </button>
        </form>

        <a class="back" href="{{ route('login') }}">
            ← Back to Sign In
        </a>

    </section>

</main>
</body>
</html>
