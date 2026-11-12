<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class PenerimaanController extends Controller
{
    public function create()
    {
        $pengadaan = DB::select(
            "SELECT idpengadaan FROM pengadaan ORDER BY idpengadaan DESC"
        );

        $users = DB::select(
            "SELECT iduser, username FROM user ORDER BY username"
        );

        return view('penerimaan.create', compact('pengadaan', 'users'));
    }

    public function penerimaan(Request $request)
    {
        $request->validate([
            'idpengadaan' => 'required|integer',
            'iduser' => 'required|integer',
            'status' => 'required|string|size:1',
        ]);

        DB::insert(
            "INSERT INTO penerimaan (status, idpengadaan, iduser)
             VALUES (?, ?, ?)",
            [
                $request->status,
                $request->idpengadaan,
                $request->iduser
            ]
        );

        $idpenerimaan = DB::getPdo()->lastInsertId();

        return redirect()->route(
            'penerimaan.detail',
            ['id' => $idpenerimaan]
        )->with('success', 'Penerimaan berhasil dibuat. Silakan tambahkan stok.');
    }


    public function penerimaandetailform($id)
    {
        $penerimaan = DB::select(
            "SELECT idpenerimaan FROM penerimaan
             WHERE idpenerimaan = ?",
            [$id]
        );

        if (empty($penerimaan)) {
            abort(404);
        }

        $barang = DB::select(
            "SELECT idbarang, nama FROM barang ORDER BY nama"
        );

        return view('penerimaan.detail', [
            'idpenerimaan' => $id,
            'barang' => $barang
        ]);
    }

    public function tambahstok(Request $request, $id)
    {
        $request->validate([
            'barang_idbarang' => 'required|integer',
            'jumlah_terima' => 'required|integer|min:1',
            'harga_satuan' => 'required|integer|min:0',
        ]);

        $subtotal = $request->jumlah_terima * $request->harga_satuan;

        DB::insert(
            "INSERT INTO detail_penerimaan
            (idpenerimaan, barang_idbarang, jumlah_terima,
             harga_satuan_terima, sub_total_terima)
            VALUES (?, ?, ?, ?, ?)",
            [
                $id,
                $request->barang_idbarang,
                $request->jumlah_terima,
                $request->harga_satuan,
                $subtotal
            ]
        );

        return redirect()->route('penerimaan.detail', ['id' => $id])
            ->with('success', 'Detail penerimaan berhasil disimpan.');
    }

   public function cekstok($idbarang)
    {
    $hasil = DB::select(
        "SELECT cek_stok(?) AS stok_sekarang",
        [$idbarang]
    );

    $stok = $hasil[0]->stok_sekarang;

    return view('penerimaan.cekstok', compact('stok'));
    }
}
