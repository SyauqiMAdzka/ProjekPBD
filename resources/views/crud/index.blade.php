
@extends('layout')

@section('content')

<div class="container-fluid">

    <div class="d-flex justify-content-between mb-4">
        <div>
            <h2>{{ $config['title'] }}</h2>
            <p class="text-muted">Kelola data {{ $config['title'] }}</p>
        </div>

        <a href="{{ route('crud.create', $menu) }}"
           class="btn btn-primary">
            + Tambah Data
        </a>
    </div>

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

    <div class="card shadow-sm">
        <div class="card-body table-responsive">

            <table class="table table-bordered table-striped">
                <thead class="table-dark">
                    <tr>
                        @foreach($columns as $field => $label)
                            <th>{{ $label }}</th>
                        @endforeach
                        <th>Aksi</th>
                    </tr>
                </thead>

                <tbody>
                    @forelse($data as $row)
                        <tr>
                            @foreach($columns as $field => $label)
                                <td>{{ $row->$field ?? '-' }}</td>
                            @endforeach

                            <td>
                                <a href="{{ route('crud.edit', [
                                    $menu,
                                    $row->{$config['pk']}
                                ]) }}"
                                   class="btn btn-warning btn-sm">
                                    Edit
                                </a>

                                <form action="{{ route('crud.destroy', [
                                    $menu,
                                    $row->{$config['pk']}
                                ]) }}"
                                      method="POST"
                                      class="d-inline"
                                      onsubmit="return confirm('Hapus data ini?')">

                                    @csrf
                                    @method('DELETE')

                                    <button class="btn btn-danger btn-sm">
                                        Hapus
                                    </button>
                                </form>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="{{ count($columns) + 1 }}"
                                class="text-center">
                                Belum ada data.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>

            {{ $data->links() }}

        </div>
    </div>
</div>

@endsection
