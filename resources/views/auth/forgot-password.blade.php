
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>Forgot Password | NeuralPath</title>

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
            display: flex;
            align-items: center;
            justify-content: center;
            min-height: 100vh;
            padding: 24px;
        }

        .card {
            width: 100%;
            max-width: 440px;
            padding: 35px;
            background: #131e33;
            border: 1px solid #30415b;
            border-radius: 18px;
        }

        .brand {
            margin-bottom: 12px;
            color: #67e8f9;
            font-size: 25px;
            font-weight: 850;
            text-decoration: none;
        }

        h1 {
            margin: 20px 0 8px;
            font-size: 24px;
        }

        .description {
            margin-bottom: 26px;
            color: #cbd5e1;
            font-size: 13px;
            line-height: 1.8;
        }

        label {
            display: block;
            margin-bottom: 9px;
            color: #ffffff;
            font-size: 13px;
            font-weight: 700;
        }

        input {
            width: 100%;
            padding: 13px;
            background: #1d2a40;
            border: 1px solid #475569;
            border-radius: 9px;
            color: #ffffff;
            font: inherit;
        }

        input:focus {
            outline: 2px solid #22d3ee;
        }

        button {
            width: 100%;
            margin-top: 20px;
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

        .notice {
            margin-bottom: 20px;
            padding: 14px;
            background: #103a32;
            border: 1px solid #059669;
            border-radius: 9px;
            color: #a7f3d0;
            font-size: 13px;
        }

        .error {
            margin-top: 9px;
            color: #fda4af;
            font-size: 12px;
        }

        .links {
            display: flex;
            justify-content: center;
            flex-wrap: wrap;
            gap: 20px;
            margin-top: 25px;
        }

        .links a {
            color: #67e8f9;
            font-size: 13px;
            text-decoration: none;
        }
    </style>
</head>

<body>
<main class="page">

    <section class="card" aria-label="Password recovery">

        <a class="brand" href="{{ url('/') }}">
            ◈ NeuralPath
        </a>

        <h1>Forgot your password?</h1>

        <p class="description">
            Enter the email associated with your NeuralPath account.
            If the address is eligible, a password-reset link
            will be sent to your inbox.
        </p>

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

        <form method="POST" action="{{ route('password.email') }}">
            @csrf

            <label for="email">Email Address</label>

            <input
                id="email"
                type="email"
                name="email"
                value="{{ old('email') }}"
                autocomplete="email"
                required
                autofocus
            >

            @error('email')
                <p class="error">{{ $message }}</p>
            @enderror

            <button type="submit">
                Email Password Reset Link →
            </button>
        </form>

        <div class="links">
            <a href="{{ route('login') }}">← Back to Sign In</a>
            <a href="{{ url('/') }}">Home</a>
        </div>

    </section>

</main>
</body>
</html>
