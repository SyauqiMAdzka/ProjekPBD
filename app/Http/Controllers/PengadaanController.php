<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class PengadaanController extends Controller
{
    public function create()
    {   $vendor = DB::select("SELECT idvendor, nama_vendor FROM vendor WHERE status = 'A' ORDER BY nama_vendor");
        $users = DB::select("SELECT iduser, username FROM user ORDER BY username");

        return view('pengadaan.create', compact('vendor', 'users'));
    }

    public function pengadaan(Request $request)
    {
        $request->validate([
            'vendor_idvendor' => 'required|integer',
            'user_iduser' => 'required|integer',
            'status' => 'required|string|size:1',
        ]);

        DB::insert("INSERT INTO pengadaan (user_iduser, vendor_idvendor, status, subtotal_nilai, ppn, total_nilai)VALUES (?, ?, ?, 0, 0, 0)",
            [   $request->user_iduser,
                $request->vendor_idvendor,
                $request->status
            ]);
        $idpengadaan = DB::getPdo()->lastInsertId();

        return redirect()->route('pengadaan.detail', ['id' => $idpengadaan])->with('success', 'Pengadaan berhasil dibuat. Silakan tambahkan barang.');
    }

    public function pengadaandetailform($id)
    {
        $pengadaan = DB::select("SELECT idpengadaan FROM pengadaan WHERE idpengadaan = ?", [$id]);

        if (empty($pengadaan)) {
            abort(404);
        }

        $barang = DB::select(
            "SELECT idbarang, nama FROM barang WHERE status = 1 ORDER BY nama");

        $detail = DB::select(
            "SELECT dp.iddetail_pengadaan, dp.idbarang, b.nama, dp.jumlah, dp.harga_satuan, dp.sub_total
             FROM detail_pengadaan dp
             JOIN barang b ON dp.idbarang = b.idbarang
             WHERE dp.idpengadaan = ?",
            [$id]
        );

        $total = DB::select(
            "SELECT subtotal_nilai, ppn, total_nilai
             FROM pengadaan
             WHERE idpengadaan = ?",
            [$id]
        );

        return view('pengadaan.detail', [
            'idpengadaan' => $id,
            'barang' => $barang,
            'detail' => $detail,
            'total' => $total[0]
        ]);
    }

    public function tambahbarang(Request $request, $id)
{
    // 1. Validasi disesuaikan dengan atribut name pada form (idbarang, jumlah, harga_satuan)
    $request->validate([
        'idbarang'     => 'required|integer',
        'jumlah'       => 'required|integer|min:1',
        'harga_satuan' => 'required|integer|min:0',
    ]);

    // 2. Hitung subtotal barang
    $subtotal = $request->jumlah * $request->harga_satuan;

    // 3. Simpan ke detail_pengadaan menggunakan idbarang dari dropdown
    DB::insert(
        "INSERT INTO detail_pengadaan (harga_satuan, jumlah, sub_total, idbarang, idpengadaan)
         VALUES (?, ?, ?, ?, ?)",
        [
            $request->harga_satuan,
            $request->jumlah,
            $subtotal,
            $request->idbarang,
            $id
        ]
    );

    return redirect()->route('pengadaan.detail', ['id' => $id])
        ->with('success', 'Barang berhasil ditambahkan.');
}

    public function hapusbarang($id)
    {
        $detail = DB::select(
            "SELECT idpengadaan FROM detail_pengadaan WHERE iddetail_pengadaan = ?", [$id]);

        if (empty($detail)) {
            abort(404);
        }

        $idpengadaan = $detail[0]->idpengadaan;

        DB::delete(
            "DELETE FROM detail_pengadaan WHERE iddetail_pengadaan = ?",
            [$id]
        );

        return redirect()->route(
            'pengadaan.detail',
            ['id' => $idpengadaan]
        )->with('success', 'Barang berhasil dihapus.');
    }
}
