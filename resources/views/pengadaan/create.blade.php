
<!DOCTYPE html>
<html>
<head>
    <title>Tambah Pengadaan</title>
</head>
<body>

    <h2>Tambah Pengadaan</h2>

    @if(session('success'))
        <p>{{ session('success') }}</p>
    @endif

    @if($errors->any())
        @foreach($errors->all() as $error)
            <p>{{ $error }}</p>
        @endforeach
    @endif

    <form action="{{ route('pengadaan.store') }}" method="POST">
        @csrf

        <label>Vendor</label><br>
        <select name="vendor_idvendor" required>
            <option value="">-- Pilih Vendor --</option>
            @foreach($vendor as $v)
                <option value="{{ $v->idvendor }}">
                    {{ $v->nama_vendor }}
                </option>
            @endforeach
        </select>

        <br><br>

        <label>User</label><br>
        <select name="user_iduser" required>
            <option value="">-- Pilih User --</option>
            @foreach($users as $u)
                <option value="{{ $u->iduser }}">
                    {{ $u->username }}
                </option>
            @endforeach
        </select>

        <br><br>

        <label>Status</label><br>
        <select name="status" required>
            <option value="">-- Pilih Status --</option>
            <option value="A">Aktif</option>
            <option value="N">Nonaktif</option>
        </select>

        <br><br>

        <button type="submit">Simpan Pengadaan</button>
    </form>

    <br>
    <a href="{{ url('/') }}">Kembali</a>

</body>
</html>
