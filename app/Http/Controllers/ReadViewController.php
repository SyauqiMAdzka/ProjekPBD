<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\View\View;

class ReadViewController extends Controller
{

    private array $datasets = [
        'role' => [
            'title' => 'Role',
            'view' => 'view_role',
            'columns' => [
                'idrole' => 'ID Role',
                'nama_role' => 'Nama Role',
            ],
            'search' => ['idrole', 'nama_role'],
        ],
        'satuan' => [
            'title' => 'Satuan',
            'view' => 'view_satuan',
            'columns' => [
                'idsatuan' => 'ID Satuan',
                'nama_satuan' => 'Nama Satuan',
                'status' => 'Status',
            ],
            'search' => ['idsatuan', 'nama_satuan', 'status'],
        ],
        'vendor' => [
            'title' => 'Vendor',
            'view' => 'view_vendor',
            'columns' => [
                'idvendor' => 'ID Vendor',
                'nama_vendor' => 'Nama Vendor',
                'badan_hukum' => 'Badan Hukum',
                'status' => 'Status',
            ],
            'search' => ['idvendor', 'nama_vendor', 'badan_hukum', 'status'],
        ],
        'user' => [
            'title' => 'User',
            'view' => 'view_user',
            'columns' => [
                'iduser' => 'ID User',
                'username' => 'Username',
                'idrole' => 'ID Role',
                'nama_role' => 'Nama Role',
            ],
            'search' => ['iduser', 'username', 'idrole', 'nama_role'],
        ],
        'barang' => [
            'title' => 'Barang',
            'view' => 'view_barang',
            'columns' => [
                'idbarang' => 'ID Barang',
                'nama_barang' => 'Nama Barang',
                'jenis' => 'Jenis',
                'harga' => 'Harga',
                'status' => 'Status',
                'nama_satuan' => 'Satuan',
            ],
            'search' => ['idbarang', 'nama_barang', 'jenis', 'harga', 'status', 'nama_satuan'],
        ],
        'margin' => [
            'title' => 'Margin Penjualan',
            'view' => 'view_margin',
            'columns' => [
                'idmargin_penjualan' => 'ID Margin',
                'persen' => 'Persen',
                'status' => 'Status',
                'created_at' => 'Dibuat Pada',
                'updated_at' => 'Diperbarui Pada',
                'pembuat' => 'Pembuat',
            ],
            'search' => ['idmargin_penjualan', 'persen', 'status', 'created_at', 'updated_at', 'pembuat'],
        ],
    ];

    public function dashboard(): View
    {
        $counts = [];

        foreach ($this->datasets as $key => $dataset) {
            $counts[$key] = [
                'title' => $dataset['title'],
                'count' => DB::table($dataset['view'])->count(),
                'route' => route('data.index', ['dataset' => $key]),
            ];
        }

        return view('dashboard', compact('counts'));
    }

    public function index(Request $request, string $dataset): View
    {
        abort_unless(array_key_exists($dataset, $this->datasets), 404);

        $definition = $this->datasets[$dataset];
        $query = DB::table($definition['view']);
        $term = trim((string) $request->query('q', ''));

        if ($term !== '') {
            $query->where(function ($subQuery) use ($definition, $term) {
                foreach ($definition['search'] as $column) {
                    $subQuery->orWhere($column, 'like', '%' . $term . '%');
                }
            });
        }

        // Columns are selected from a fixed allowlist, never from user input.
        $rows = $query->select(array_keys($definition['columns']))
            ->orderBy(array_key_first($definition['columns']))
            ->paginate(10)
            ->withQueryString();

        return view('data.index', [
            'datasetKey' => $dataset,
            'dataset' => $definition,
            'rows' => $rows,
            'term' => $term,
        ]);
    }
}
