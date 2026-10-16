
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="color-scheme" content="dark">

    <title>Learners | NeuralPath Admin</title>

    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <style>
        * { box-sizing: border-box; }

        body {
            margin: 0;
            background: #080e1e;
            color: #ffffff;
            font-family: Inter, ui-sans-serif, system-ui, sans-serif;
        }

        .shell {
            max-width: 1100px;
            margin: auto;
            padding: 35px 20px 70px;
        }

        .top {
            display: flex;
            align-items: center;
            justify-content: space-between;
            gap: 16px;
            flex-wrap: wrap;
            margin-bottom: 38px;
        }

        .brand {
            color: #67e8f9;
            font-weight: 850;
            text-decoration: none;
        }

        .back {
            padding: 11px 16px;
            background: #172239;
            border: 1px solid #475569;
            border-radius: 9px;
            color: #ffffff;
            font-size: 13px;
            text-decoration: none;
        }

        h1 { font-size: 30px; margin: 0 0 10px; }

        .intro {
            color: #cbd5e1;
            font-size: 14px;
            margin-bottom: 25px;
        }

        .filters {
            display: flex;
            gap: 12px;
            flex-wrap: wrap;
            margin-bottom: 24px;
            padding: 18px;
            background: #131e33;
            border: 1px solid #30415b;
            border-radius: 13px;
        }

        .filter-input,
        .filter-select {
            min-width: 170px;
            flex: 1;
            padding: 12px;
            border: 1px solid #475569;
            border-radius: 9px;
            background: #1d2a40;
            color: #ffffff;
            font-size: 13px;
        }

        .filter-button {
            padding: 12px 20px;
            background: #0891b2;
            border: 1px solid #22d3ee;
            border-radius: 9px;
            color: #ffffff;
            font-weight: 800;
            cursor: pointer;
        }

        .table-wrapper {
            overflow-x: auto;
            background: #131e33;
            border: 1px solid #30415b;
            border-radius: 14px;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            text-align: left;
        }

        th, td {
            padding: 16px;
            border-bottom: 1px solid #30415b;
            font-size: 13px;
        }

        th {
            color: #cbd5e1;
            font-size: 11px;
            letter-spacing: .4px;
            text-transform: uppercase;
        }

        tr:last-child td { border-bottom: 0; }

        .name { color: #ffffff; font-weight: 800; }

        .email {
            color: #cbd5e1;
            font-size: 12px;
            overflow-wrap: anywhere;
        }

        .status {
            display: inline-flex;
            padding: 5px 10px;
            border-radius: 7px;
            font-size: 11px;
            font-weight: 800;
        }

        .active {
            color: #6ee7b7;
            background: #103a32;
        }

        .suspended {
            color: #fda4af;
            background: #4c1d2b;
        }

        .action {
            color: #67e8f9;
            font-weight: 800;
            text-decoration: none;
            white-space: nowrap;
        }

        .pagination {
            margin-top: 24px;
            color: #cbd5e1;
        }

        .empty {
            padding: 35px;
            color: #cbd5e1;
            text-align: center;
        }

        a:focus-visible,
        button:focus-visible,
        input:focus-visible,
        select:focus-visible {
            outline: 3px solid #67e8f9;
            outline-offset: 2px;
        }

        @media (max-width: 600px) {
            h1 { font-size: 25px; }
            th, td { padding: 12px; }
        }
    </style>
</head>

<body>
<main class="shell">

    <header class="top">
        <a href="{{ route('admin.dashboard') }}" class="brand">
            ◈ NeuralPath Admin
        </a>

        <a href="{{ route('admin.dashboard') }}" class="back">
            ← Admin Dashboard
        </a>
    </header>

    <h1>Learner Management</h1>

    <p class="intro">
        Find learner accounts, check their status,
        and open individual progress reports.
    </p>

    <form
        class="filters"
        method="GET"
        action="{{ route('admin.learners.index') }}"
    >
        <input
            class="filter-input"
            type="search"
            name="search"
            value="{{ $search }}"
            placeholder="Search name or email"
            aria-label="Search learners"
        >

        <select
            class="filter-select"
            name="status"
            aria-label="Filter account status"
        >
            <option value="all" @selected($status === 'all')>
                All Learners
            </option>
            <option value="active" @selected($status === 'active')>
                Active
            </option>
            <option value="suspended" @selected($status === 'suspended')>
                Suspended
            </option>
        </select>

        <button type="submit" class="filter-button">
            Search
        </button>
    </form>

    <div class="table-wrapper">
        <table>
            <thead>
                <tr>
                    <th>Learner</th>
                    <th>Account Status</th>
                    <th>Email Verification</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                @forelse($learners as $learner)
                    <tr>
                        <td>
                            <div class="name">{{ $learner->name }}</div>
                            <div class="email">{{ $learner->email }}</div>
                        </td>

                        <td>
                            @if($learner->isActive())
                                <span class="status active">Active</span>
                            @else
                                <span class="status suspended">Suspended</span>
                            @endif
                        </td>

                        <td>
                            {{ $learner->hasVerifiedEmail() ? 'Verified' : 'Not Verified' }}
                        </td>

                        <td>
                            <a
                                class="action"
                                href="{{ route('admin.learners.show', $learner) }}"
                            >
                                View Details →
                            </a>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="4" class="empty">
                            No learners found.
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    @if($learners->hasPages())
        <div class="pagination">
            {{ $learners->links() }}
        </div>
    @endif

</main>
</body>
</html>
