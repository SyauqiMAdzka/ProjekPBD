<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Detail Pengadaan #{{ $idpengadaan }}</title>
</head>
<body>

    <h2>Detail Pengadaan</h2>
    <p><strong>ID Pengadaan:</strong> {{ $idpengadaan }}</p>

    {{-- Notifikasi Sukses --}}
    @if(session('success'))
        <p style="color: green; font-weight: bold;">{{ session('success') }}</p>
    @endif

    {{-- Notifikasi Error Validasi --}}
    @if($errors->any())
        <div style="color: red;">
            <ul>
                @foreach($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <h3>Tambah Barang ke Pengadaan</h3>

    {{-- Form Tambah Barang --}}
    <form action="{{ route('pengadaan.tambahbarang', ['id' => $idpengadaan]) }}" method="POST">
        @csrf

        <label for="idbarang">Pilih Barang:</label><br>
        <select name="idbarang" id="idbarang" required>
            <option value="">-- Pilih Barang --</option>
            @foreach($barang as $b)
                <option value="{{ $b->idbarang }}" {{ old('idbarang') == $b->idbarang ? 'selected' : '' }}>
                    {{ $b->nama }}
                </option>
            @endforeach
        </select>

        <br><br>

        <label for="jumlah">Jumlah (Qty):</label><br>
        <input type="number" name="jumlah" id="jumlah" min="1" value="{{ old('jumlah') }}" required>

        <br><br>

        <label for="harga_satuan">Harga Satuan (Rp):</label><br>
        <input type="number" name="harga_satuan" id="harga_satuan" min="0" value="{{ old('harga_satuan') }}" required>

        <br><br>

        <button type="submit">Tambah Barang</button>
    </form>

    <hr>

    <h3>Daftar Barang Pengadaan</h3>

    <table border="1" cellpadding="8" cellspacing="0">
        <thead>
            <tr style="background-color: #f2f2f2;">
                <th>ID Detail</th>
                <th>Nama Barang</th>
                <th>Jumlah</th>
                <th>Harga Satuan</th>
                <th>Subtotal</th>
                <th>Aksi</th>
            </tr>
        </thead>
        <tbody>
            @forelse($detail as $d)
                <tr>
                    <td align="center">{{ $d->iddetail_pengadaan }}</td>
                    <td>{{ $d->nama }}</td>
                    <td align="center">{{ $d->jumlah }}</td>
                    <td align="right">Rp {{ number_format($d->harga_satuan, 0, ',', '.') }}</td>
                    <td align="right">Rp {{ number_format($d->sub_total, 0, ',', '.') }}</td>
                    <td align="center">
                        <form action="{{ route('pengadaan.hapusbarang', ['id' => $d->iddetail_pengadaan]) }}" method="POST" style="display:inline;">
                            @csrf
                            @method('DELETE')
                            <button type="submit" onclick="return confirm('Yakin ingin menghapus barang ini?')">
                                Hapus
                            </button>
                        </form>
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="6" align="center">Belum ada barang dalam pengadaan ini.</td>
                </tr>
            @endforelse
        </tbody>
    </table>

    <h3>Total Pengadaan</h3>
    <p><strong>Subtotal:</strong> Rp {{ number_format($total->subtotal_nilai ?? 0, 0, ',', '.') }}</p>
    <p><strong>PPN (11%):</strong> Rp {{ number_format($total->ppn ?? 0, 0, ',', '.') }}</p>
    <p><strong>Total Nilai:</strong> Rp {{ number_format($total->total_nilai ?? 0, 0, ',', '.') }}</p>

    <br>
    <a href="{{ route('pengadaan.create') }}">← Buat Pengadaan Baru</a>

</body>
</html>
