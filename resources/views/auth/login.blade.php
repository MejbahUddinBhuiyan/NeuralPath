
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="color-scheme" content="dark">

    <title>Sign In | NeuralPath</title>

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
            font-size: 29px;
            font-weight: 850;
            text-align: center;
        }

        .tagline {
            margin: 10px 0 28px;
            color: #cbd5e1;
            font-size: 13px;
            text-align: center;
        }

        h1 {
            margin: 0 0 22px;
            font-size: 22px;
        }

        label {
            display: block;
            margin-bottom: 8px;
            font-size: 13px;
            font-weight: 700;
        }

        .field {
            margin-bottom: 20px;
        }

        .input {
            width: 100%;
            padding: 13px;
            background: #1d2a40;
            border: 1px solid #475569;
            border-radius: 9px;
            color: #ffffff;
            font: inherit;
        }

        .input:focus {
            outline: 2px solid #22d3ee;
        }

        .options {
            display: flex;
            justify-content: space-between;
            align-items: center;
            flex-wrap: wrap;
            gap: 12px;
            margin: 7px 0 22px;
            font-size: 12px;
        }

        .remember {
            display: flex;
            align-items: center;
            gap: 8px;
            color: #cbd5e1;
        }

        .forgot,
        .links a {
            color: #67e8f9;
            text-decoration: none;
        }

        .submit {
            width: 100%;
            padding: 13px;
            background: #0891b2;
            border: 1px solid #22d3ee;
            border-radius: 9px;
            color: #ffffff;
            font-weight: 800;
            cursor: pointer;
        }

        .submit:hover {
            background: #0e7490;
        }

        .notice {
            margin-bottom: 20px;
            padding: 13px;
            background: #103a32;
            border: 1px solid #059669;
            border-radius: 9px;
            color: #a7f3d0;
            font-size: 13px;
        }

        .error {
            margin-bottom: 15px;
            color: #fda4af;
            font-size: 13px;
        }

        .footer-text {
            margin-top: 23px;
            color: #cbd5e1;
            text-align: center;
            font-size: 12px;
        }

        .links {
            display: flex;
            justify-content: center;
            flex-wrap: wrap;
            gap: 18px;
            margin-top: 23px;
            font-size: 12px;
        }

        a:focus-visible,
        button:focus-visible {
            outline: 3px solid #67e8f9;
            outline-offset: 3px;
        }
    </style>
</head>

<body>
<main class="page">

    <section class="card" aria-label="NeuralPath sign in">

        <div class="brand">◈ NeuralPath</div>

        <p class="tagline">
            Your Agentic AI Engineering Workspace
        </p>

        <h1>Sign In</h1>

        @if(session('status'))
            <div class="notice" role="status">
                {{ session('status') }}
            </div>
        @endif

        @if($errors->any())
            <div class="error" role="alert">
                {{ $errors->first() }}
            </div>
        @endif

        <form method="POST" action="{{ route('login.store') }}">
            @csrf

            <div class="field">
                <label for="email">
                    Email Address
                </label>

                <input
                    class="input"
                    id="email"
                    type="email"
                    name="email"
                    value="{{ old('email') }}"
                    autocomplete="username"
                    required
                    autofocus
                >
            </div>

            <div class="field">
                <label for="password">
                    Password
                </label>

                <input
                    class="input"
                    id="password"
                    type="password"
                    name="password"
                    autocomplete="current-password"
                    required
                >
            </div>

            <div class="options">
                <label class="remember" for="remember">
                    <input
                        id="remember"
                        type="checkbox"
                        name="remember"
                        value="1"
                    >
                    Remember me
                </label>

                <a
                    class="forgot"
                    href="{{ route('password.request') }}"
                >
                    Forgot Password?
                </a>
            </div>

            <button type="submit" class="submit">
                Sign In →
            </button>
        </form>

        <p class="footer-text">
            Access is restricted to approved, invited members.
        </p>

        <div class="links">
            <a href="{{ url('/') }}">← Back to Home</a>

            <a href="mailto:mejbahu475@gmail.com?subject=NeuralPath%20Access%20Request">
                Request Access
            </a>
        </div>

    </section>

</main>
</body>
</html>
