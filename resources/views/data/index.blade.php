@extends('layouts.app')

@section('title', $dataset['title'])
@section('breadcrumb', $dataset['title'])

@section('content')
    <div class="d-flex flex-wrap align-items-end justify-content-between gap-3 mb-4">
        <div>
            <div class="small text-primary fw-semibold mb-2">DATA MASTER / READ ONLY</div>
            <h1 class="h2 page-title mb-1">{{ $dataset['title'] }}</h1>
            <p class="muted mb-0">Sumber data: <code>{{ $dataset['view'] }}</code></p>
        </div>
        <span class="badge rounded-pill text-bg-light border px-3 py-2">Total hasil: {{ number_format($rows->total()) }}</span>
    </div>

    <div class="surface p-3 p-lg-4">
        <form method="GET" action="{{ route('data.index', ['dataset' => $datasetKey]) }}" class="row g-2 align-items-center mb-3">
            <div class="col-12 col-md">
                <label class="visually-hidden" for="search">Cari data</label>
                <input id="search" name="q" type="search" value="{{ $term }}" class="form-control" placeholder="Cari {{ strtolower($dataset['title']) }}...">
            </div>
            <div class="col-6 col-md-auto">
                <button class="btn btn-primary w-100" type="submit">Cari</button>
            </div>
            <div class="col-6 col-md-auto">
                <a class="btn btn-outline-secondary w-100" href="{{ route('data.index', ['dataset' => $datasetKey]) }}">Reset</a>
            </div>
        </form>

        @if($term !== '')
            <div class="small muted mb-3">Kata kunci: <strong>{{ $term }}</strong></div>
        @endif

        <div class="table-responsive">
            <table class="table table-hover align-middle mb-0">
                <thead>
                    <tr>
                        @foreach($dataset['columns'] as $column => $label)
                            <th scope="col">{{ $label }}</th>
                        @endforeach
                    </tr>
                </thead>
                <tbody>
                    @forelse($rows as $row)
                        <tr>
                            @foreach($dataset['columns'] as $column => $label)
                                <td>
                                    @php($value = data_get($row, $column))
                                    @if($column === 'status')
                                        @if((string) $value === '1')
                                            <span class="badge rounded-pill text-bg-success">Aktif</span>
                                        @elseif((string) $value === '0')
                                            <span class="badge rounded-pill text-bg-secondary">Tidak aktif</span>
                                        @else
                                            {{ $value ?? '—' }}
                                        @endif
                                    @elseif($column === 'harga')
                                        {{ is_numeric($value) ? 'Rp ' . number_format((float) $value, 0, ',', '.') : ($value ?? '—') }}
                                    @elseif($column === 'persen')
                                        {{ $value === null ? '—' : $value . '%' }}
                                    @else
                                        {{ $value ?? '—' }}
                                    @endif
                                </td>
                            @endforeach
                        </tr>
                    @empty
                        <tr>
                            <td colspan="{{ count($dataset['columns']) }}" class="text-center py-5">
                                <div class="fw-semibold">Data tidak ditemukan</div>
                                <div class="small muted mt-1">Coba kata kunci lain atau reset pencarian.</div>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <div class="d-flex flex-wrap align-items-center justify-content-between gap-3 pt-3">
            <div class="small muted">
                @if($rows->total() > 0)
                    Menampilkan {{ $rows->firstItem() }}–{{ $rows->lastItem() }} dari {{ $rows->total() }} baris
                @else
                    0 baris
                @endif
            </div>
            {{ $rows->onEachSide(1)->links('pagination::bootstrap-5') }}
        </div>
    </div>
@endsection
