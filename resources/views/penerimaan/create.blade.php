
<!DOCTYPE html>
<html>
<head>
    <title>Tambah Penerimaan</title>
</head>
<body>

    <h1>Tambah Penerimaan Barang</h1>

    @if ($errors->any())
        <p style="color:red;">
            @foreach ($errors->all() as $error)
                {{ $error }}<br>
            @endforeach
        </p>
    @endif

    <form action="{{ route('penerimaan.store') }}" method="POST">
        @csrf

        <label>Pengadaan</label><br>
        <select name="idpengadaan" required>
            <option value="">-- Pilih Pengadaan --</option>

            @foreach ($pengadaan as $p)
                <option value="{{ $p->idpengadaan }}">
                    Pengadaan {{ $p->idpengadaan }}
                </option>
            @endforeach
        </select>

        <br><br>

        <label>User</label><br>
        <select name="iduser" required>
            <option value="">-- Pilih User --</option>

            @foreach ($users as $u)
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

        <button type="submit">Simpan Penerimaan</button>
    </form>

</body>
</html>
