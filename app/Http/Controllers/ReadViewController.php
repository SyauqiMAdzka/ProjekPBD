<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ReadViewController extends Controller
{
    private array $views = [
        'role' => ['title' => 'Role', 'table' => 'view_role', 'columns' => ['idrole' => 'ID Role', 'nama_role' => 'Nama Role']],
        'satuan' => ['title' => 'Satuan', 'table' => 'view_satuan', 'columns' => ['idsatuan' => 'ID Satuan', 'nama_satuan' => 'Nama Satuan', 'status' => 'Status']],
        'vendor' => ['title' => 'Vendor', 'table' => 'view_vendor', 'columns' => ['idvendor' => 'ID Vendor', 'nama_vendor' => 'Nama Vendor', 'badan_hukum' => 'Badan Hukum', 'status' => 'Status']],
        'user' => ['title' => 'User', 'table' => 'view_user', 'columns' => ['iduser' => 'ID User', 'username' => 'Username', 'idrole' => 'ID Role', 'nama_role' => 'Nama Role']],
        'barang' => ['title' => 'Barang', 'table' => 'view_barang', 'columns' => ['idbarang' => 'ID Barang', 'nama_barang' => 'Nama Barang', 'jenis' => 'Jenis', 'harga' => 'Harga', 'status' => 'Status', 'nama_satuan' => 'Satuan']],
        'margin' => ['title' => 'Margin Penjualan', 'table' => 'view_margin', 'columns' => ['idmargin_penjualan' => 'ID Margin', 'persen' => 'Persen', 'status' => 'Status', 'created_at' => 'Dibuat', 'updated_at' => 'Diperbarui', 'pembuat' => 'Pembuat']],
    ];

    public function dashboard()
    {
        $counts = [];
        foreach ($this->views as $key => $view) {
            $counts[$key] = ['title' => $view['title'], 'count' => DB::table($view['table'])->count()];
        }
        return view('dashboard', compact('counts'));
    }

    public function index(Request $request, string $view)
    {
        abort_unless(isset($this->views[$view]), 404);
        $data = $this->views[$view];
        $query = DB::table($data['table']);
        $keyword = trim((string) $request->query('q', ''));

        if ($keyword !== '') {
            $query->where(function ($q) use ($data, $keyword) {
                foreach (array_keys($data['columns']) as $column) {
                    $q->orWhere($column, 'like', '%' . $keyword . '%');
                }
            });
        }

        $rows = $query->select(array_keys($data['columns']))
            ->orderBy(array_key_first($data['columns']))
            ->paginate(10)->withQueryString();

        return view('data', compact('data', 'rows', 'keyword'));
    }
}
