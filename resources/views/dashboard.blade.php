@extends('layouts.app')

@section('title', 'Dashboard')
@section('breadcrumb', 'Dashboard')

@section('content')
    <div class="d-flex flex-wrap align-items-end justify-content-between gap-3 mb-4">
        <div>
            <div class="small text-primary fw-semibold mb-2">RINGKASAN DATABASE</div>
            <h1 class="h2 page-title mb-1">Dashboard</h1>
            <p class="muted mb-0">Ringkasan enam view database yang tersedia.</p>
        </div>
        <span class="badge rounded-pill text-bg-success px-3 py-2">● Read-only aktif</span>
    </div>

    <div class="row g-3">
        @foreach($counts as $key => $item)
            <div class="col-sm-6 col-xl-4">
                <a href="{{ $item['route'] }}" class="text-decoration-none text-reset">
                    <div class="surface p-4 h-100">
                        <div class="d-flex justify-content-between align-items-start">
                            <div>
                                <div class="muted small mb-2">{{ $item['title'] }}</div>
                                <div class="display-6 fw-bold">{{ number_format($item['count']) }}</div>
                                <div class="small muted mt-2">Baris data tersedia</div>
                            </div>
                            <div class="stat-icon">{{ strtoupper(substr($key, 0, 2)) }}</div>
                        </div>
                        <div class="text-primary small fw-semibold mt-4">Lihat data <span aria-hidden="true">→</span></div>
                    </div>
                </a>
            </div>
        @endforeach
    </div>

    <div class="surface p-4 mt-4">
        <h2 class="h6 fw-bold mb-2">Tentang halaman ini</h2>
        <p class="muted mb-0">Halaman ini mengambil jumlah baris dari view MySQL: <code>view_role</code>, <code>view_satuan</code>, <code>view_vendor</code>, <code>view_user</code>, <code>view_barang</code>, dan <code>view_margin</code>. Tidak tersedia aksi tambah, ubah, atau hapus.</p>
    </div>
@endsection
