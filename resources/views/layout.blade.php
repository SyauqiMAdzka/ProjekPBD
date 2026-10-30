
<!doctype html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width,initial-scale=1">

    <title>@yield('title', 'Dashboard')</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>

<body class="bg-light">

<div class="container-fluid">
    <div class="row">

        <!-- SIDEBAR -->
        <aside class="col-md-2 bg-dark text-white min-vh-100 p-3">

            <h4>Sistem Penjualan</h4>
            <hr>

            <!-- Dashboard -->
            <a class="d-block text-white mb-3 text-decoration-none"
               href="{{ route('dashboard') }}">
                Dashboard
            </a>

            <hr>

            <h6 class="text-secondary">MASTER DATA</h6>

            @foreach([
                'role'=>'Role',
                'satuan'=>'Satuan',
                'vendor'=>'Vendor',
                'user'=>'User',
                'barang'=>'Barang',
                'margin'=>'Margin Penjualan'
            ] as $k=>$v)

                <a class="d-block text-white mb-3 text-decoration-none"
                   href="{{ route('crud.index', $k) }}">
                    {{ $v }}
                </a>

            @endforeach

        </aside>

        <!-- KONTEN UTAMA -->
        <main class="col-md-10 p-4">

            @if(session('msg'))
                <div class="alert alert-success">
                    {{ session('msg') }}
                </div>
            @endif

            @if(session('success'))
                <div class="alert alert-success">
                    {{ session('success') }}
                </div>
            @endif

            @if($errors->any())
                <div class="alert alert-danger">
                    {{ $errors->first() }}
                </div>
            @endif

            @yield('content')

        </main>

    </div>
</div>

</body>
</html>
