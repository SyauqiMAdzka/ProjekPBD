
@extends('layout')

@section('content')

<div class="container-fluid">

    <h2>
        {{ $mode == 'create' ? 'Tambah' : 'Edit' }}
        {{ $config['title'] }}
    </h2>

    <div class="card shadow-sm mt-3">
        <div class="card-body">

            <form method="POST"
                action="{{ $mode == 'create'
                    ? route('crud.store', $menu)
                    : route('crud.update', [$menu, $item->{$config['pk']}]) }}">

                @csrf

                @if($mode == 'edit')
                    @method('PUT')
                @endif

                @foreach($config['fields'] as $field => $label)

                    <div class="mb-3">

                        <label class="form-label">
                            {{ $label }}
                        </label>

                        @if($field == 'status')

                            <select name="status" class="form-select">
                                <option value="1"
                                    {{ old('status', $item->status ?? 1) == 1 ? 'selected' : '' }}>
                                    Aktif
                                </option>

                                <option value="0"
                                    {{ old('status', $item->status ?? 1) == 0 ? 'selected' : '' }}>
                                    Tidak Aktif
                                </option>
                            </select>

                        @elseif($field == 'idrole' || $field == 'idsatuan' || $field == 'iduser')

                            <select name="{{ $field }}" class="form-select">
                                <option value="">-- Pilih {{ $label }} --</option>

                                @foreach($options[$field] ?? [] as $option)
                                    @php
                                        $idField = $field;
                                        $textField = $field == 'idrole'
                                            ? 'nama_role'
                                            : ($field == 'idsatuan'
                                                ? 'nama_satuan'
                                                : 'username');
                                    @endphp

                                    <option value="{{ $option->$idField }}"
                                        {{ old($field, $item->$field ?? '') == $option->$idField ? 'selected' : '' }}>
                                        {{ $option->$textField }}
                                    </option>
                                @endforeach
                            </select>

                        @elseif($field == 'password')

                            <input type="password"
                                name="password"
                                class="form-control"
                                placeholder="{{ $mode == 'edit' ? 'Kosongkan jika tidak diubah' : 'Masukkan password' }}">

                        @else

                            <input type="{{ $field == 'harga' || $field == 'persen' ? 'number' : 'text' }}"
                                name="{{ $field }}"
                                class="form-control"
                                step="{{ $field == 'harga' || $field == 'persen' ? '0.01' : 'any' }}"
                                value="{{ old($field, $item->$field ?? '') }}">

                        @endif

                        @error($field)
                            <small class="text-danger">{{ $message }}</small>
                        @enderror

                    </div>

                @endforeach

                <button type="submit" class="btn btn-primary">
                    Simpan
                </button>

                <a href="{{ route('crud.index', $menu) }}"
                   class="btn btn-secondary">
                    Kembali
                </a>

            </form>

        </div>
    </div>

</div>

@endsection
