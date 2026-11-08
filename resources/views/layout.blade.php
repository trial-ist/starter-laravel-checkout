<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>@yield('title', 'Northwind Supply')</title>
    <style>
        :root { --ink: #1c1917; --muted: #78716c; --line: #e7e5e4; --accent: #0f766e; }
        * { box-sizing: border-box; }
        body { margin: 0; font: 15px/1.5 ui-sans-serif, system-ui, sans-serif; color: var(--ink); background: #fafaf9; }
        header { background: #fff; border-bottom: 1px solid var(--line); }
        header .wrap { display: flex; align-items: center; justify-content: space-between; padding-block: 14px; }
        header a { color: inherit; text-decoration: none; font-weight: 700; letter-spacing: -0.01em; }
        .wrap { max-width: 880px; margin: 0 auto; padding-inline: 24px; }
        main { padding-block: 32px; }
        h1 { font-size: 26px; margin: 0 0 4px; letter-spacing: -0.02em; }
        .muted { color: var(--muted); }
        .card { background: #fff; border: 1px solid var(--line); border-radius: 10px; padding: 20px; margin-top: 20px; }
        table { width: 100%; border-collapse: collapse; }
        th, td { text-align: left; padding: 10px 8px; border-bottom: 1px solid var(--line); vertical-align: middle; }
        th { font-size: 12px; text-transform: uppercase; letter-spacing: .04em; color: var(--muted); font-weight: 600; }
        td.num, th.num { text-align: right; white-space: nowrap; }
        input[type=number] { width: 64px; }
        input { font: inherit; padding: 7px 9px; border: 1px solid #d6d3d1; border-radius: 6px; }
        button { font: inherit; font-weight: 600; background: var(--accent); color: #fff; border: 0; border-radius: 6px; padding: 9px 16px; cursor: pointer; }
        .row { display: flex; gap: 12px; align-items: end; justify-content: space-between; margin-top: 16px; flex-wrap: wrap; }
        .error { color: #b91c1c; margin: 6px 0 0; font-size: 14px; }
        .totals td { border: 0; padding-block: 4px; }
        .totals tr.total td { font-weight: 700; font-size: 18px; border-top: 1px solid var(--line); padding-top: 10px; }
        a { color: var(--accent); }
    </style>
</head>
<body>
<header><div class="wrap"><a href="{{ route('shop') }}">Northwind Supply</a><span class="muted">Desk gear, shipped fast</span></div></header>
<main class="wrap">
    @yield('content')
</main>
</body>
</html>
