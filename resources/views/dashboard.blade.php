@extends('layout')

@section('title', 'Dashboard')

@section('content')
    <h2 class="mb-4">Dashboard</h2>

    <div class="row g-3">

        <div class="col-md-4">
            <div class="card p-3">
                <h5>Total Role</h5>
                <h2>{{ $totalRole }}</h2>
            </div>
        </div>

        <div class="col-md-4">
            <div class="card p-3">
                <h5>Total Satuan</h5>
                <h2>{{ $totalSatuan }}</h2>
            </div>
        </div>

        <div class="col-md-4">
            <div class="card p-3">
                <h5>Total Vendor</h5>
                <h2>{{ $totalVendor }}</h2>
            </div>
        </div>

        <div class="col-md-4">
            <div class="card p-3">
                <h5>Total User</h5>
                <h2>{{ $totalUser }}</h2>
            </div>
        </div>

        <div class="col-md-4">
            <div class="card p-3">
                <h5>Total Barang</h5>
                <h2>{{ $totalBarang }}</h2>
            </div>
        </div>

        <div class="col-md-4">
            <div class="card p-3">
                <h5>Total Margin Penjualan</h5>
                <h2>{{ $totalMargin }}</h2>
            </div>
        </div>

    </div>
@endsection
