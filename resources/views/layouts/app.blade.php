<!doctype html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>@yield('title', 'Data Viewer') · Admin</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        :root { --sidebar: #17243a; --sidebar-muted: #b8c5d8; --page: #f4f7fb; --accent: #4f7cff; }
        body { background: var(--page); color: #1e293b; }
        .sidebar { background: var(--sidebar); min-height: 100vh; }
        .brand { color: #fff; font-weight: 750; letter-spacing: .2px; }
        .sidebar .nav-link { color: var(--sidebar-muted); border-radius: .65rem; padding: .7rem .85rem; margin-bottom: .25rem; }
        .sidebar .nav-link:hover, .sidebar .nav-link.active { color: #fff; background: rgba(255,255,255,.12); }
        .sidebar-label { color: #8395b0; font-size: .72rem; letter-spacing: .1em; text-transform: uppercase; }
        .main-area { min-width: 0; }
        .topbar { background: #fff; border-bottom: 1px solid #e8edf4; }
        .surface { background: #fff; border: 1px solid #e7edf5; border-radius: 1rem; box-shadow: 0 4px 18px rgba(22,34,51,.035); }
        .page-title { font-weight: 750; letter-spacing: -.025em; }
        .table thead th { background: #f8fafc; color: #64748b; font-size: .78rem; text-transform: uppercase; letter-spacing: .04em; white-space: nowrap; border-bottom: 1px solid #e7edf5; }
        .table td { vertical-align: middle; }
        .muted { color: #718096; }
        .stat-icon { width: 42px; height: 42px; display: grid; place-items: center; border-radius: .8rem; background: #edf2ff; color: var(--accent); font-weight: 800; }
        @media (max-width: 767.98px) { .sidebar { min-height: auto; } }
    </style>
</head>
<body>
<div class="container-fluid">
    <div class="row">
        <aside class="col-md-3 col-lg-2 sidebar px-3 py-4">
            <a href="{{ route('dashboard') }}" class="text-decoration-none brand d-flex align-items-center gap-2 mb-4">
                <span class="rounded-3 bg-primary p-2">DB</span><span>DataPanel</span>
            </a>
            <div class="sidebar-label mb-2">Menu utama</div>
            <nav class="nav flex-column">
                <a class="nav-link {{ request()->routeIs('dashboard') ? 'active' : '' }}" href="{{ route('dashboard') }}">⌂ &nbsp; Dashboard</a>
            </nav>
            <div class="sidebar-label mt-4 mb-2">Data master</div>
            <nav class="nav flex-column">
                @php($menus = ['role' => 'Role', 'satuan' => 'Satuan', 'vendor' => 'Vendor', 'user' => 'User', 'barang' => 'Barang', 'margin' => 'Margin Penjualan'])
                @foreach($menus as $key => $label)
                    <a class="nav-link {{ request()->route('dataset') === $key ? 'active' : '' }}" href="{{ route('data.index', ['dataset' => $key]) }}">
                        <span class="me-2">›</span>{{ $label }}
                    </a>
                @endforeach
            </nav>
            <div class="mt-5 p-3 rounded-3" style="background:rgba(255,255,255,.07)">
                <div class="small text-white fw-semibold">Mode Read-only</div>
                <div class="small mt-1" style="color:#b8c5d8">Data hanya dapat dilihat, dicari, dan dijelajahi.</div>
            </div>
        </aside>
        <main class="col-md-9 col-lg-10 main-area px-0">
            <header class="topbar d-flex align-items-center justify-content-between px-4 px-lg-5 py-3">
                <div class="small muted">Admin / @yield('breadcrumb', 'Dashboard')</div>
                <span class="badge text-bg-light border">MySQL Views</span>
            </header>
            <div class="p-3 p-lg-5">
                @if(session('error'))
                    <div class="alert alert-danger">{{ session('error') }}</div>
                @endif
                @yield('content')
                <div class="text-center small muted mt-5">DataPanel · Read-only interface</div>
            </div>
        </main>
    </div>
</div>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
