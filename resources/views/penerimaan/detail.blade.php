
<!DOCTYPE html>
<html>
<head>
    <title>Tambah Detail Penerimaan</title>
</head>
<body>

    <h1>Tambah Detail Penerimaan Barang</h1>

    <p>
        ID Penerimaan: {{ $idpenerimaan }}
    </p>

    @if (session('success'))
        <p style="color:green;">
            {{ session('success') }}
        </p>
    @endif

    @if ($errors->any())
        <p style="color:red;">
            @foreach ($errors->all() as $error)
                {{ $error }}<br>
            @endforeach
        </p>
    @endif

    <form action="{{ route('penerimaan.tambahstok', $idpenerimaan) }}"
          method="POST">
        @csrf

        <label>Barang</label><br>
        <select name="barang_idbarang" required>
            <option value="">-- Pilih Barang --</option>

            @foreach ($barang as $b)
                <option value="{{ $b->idbarang }}">
                    {{ $b->nama }}
                </option>
            @endforeach
        </select>

        <br><br>

        <label>Jumlah Diterima</label><br>
        <input type="number" name="jumlah_terima" min="1" required>

        <br><br>

        <label>Harga Satuan</label><br>
        <input type="number" name="harga_satuan" min="0" required>

        <br><br>

        <button type="submit">Simpan Penerimaan</button>
    </form>

</body>
</html>
