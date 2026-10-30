@extends('layout')
@section('title', $data['title'])
@section('content')
<h2>{{ $data['title'] }}</h2>
<p>Data dari <code>{{ $data['table'] }}</code>.</p>
<form method="GET" action="{{ route('data', request()->route('view')) }}" class="row g-2 mb-3">
    <div class="col-md-5">
        <input type="text" name="q" class="form-control" placeholder="Cari data..." value="{{ $keyword }}">
    </div>
    <div class="col-auto">
        <button type="submit" class="btn btn-primary">Cari</button>
        <a href="{{ route('data', request()->route('view')) }}" class="btn btn-secondary">Reset</a>
    </div>
</form>
<div class="table-responsive bg-white">
<table class="table table-bordered table-striped mb-0">
    <thead class="table-dark"><tr>
        @foreach($data['columns'] as $label)<th>{{ $label }}</th>@endforeach
    </tr></thead>
    <tbody>
    @forelse($rows as $row)
        <tr>
        @foreach($data['columns'] as $column => $label)
            <td>
                @php($value = $row->$column)
                @if($column === 'harga' && is_numeric($value))
                    Rp {{ number_format($value, 0, ',', '.') }}
                @elseif($column === 'persen' && $value !== null)
                    {{ $value }}%
                @else
                    {{ $value ?? '-' }}
                @endif
            </td>
        @endforeach
        </tr>
    @empty
        <tr><td colspan="{{ count($data['columns']) }}" class="text-center">Data tidak ditemukan.</td></tr>
    @endforelse
    </tbody>
</table>
</div>
<div class="mt-3">{{ $rows->links('pagination::bootstrap-5') }}</div>
@endsection
