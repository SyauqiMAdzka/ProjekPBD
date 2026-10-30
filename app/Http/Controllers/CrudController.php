<?php
namespace App\Http\Controllers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class CrudController extends Controller
{
    private function config($menu)
    {
        $data = [
            'role' => [
                'title' => 'Role',
                'view' => 'view_role',
                'table' => 'role',
                'pk' => 'idrole',
                'fields' => [
                    'nama_role' => 'Nama Role'
                ]
            ],

            'satuan' => [
                'title' => 'Satuan',
                'view' => 'view_satuan',
                'table' => 'satuan',
                'pk' => 'idsatuan',
                'fields' => [
                    'nama_satuan' => 'Nama Satuan',
                    'status' => 'Status'
                ]
            ],

            'vendor' => [
                'title' => 'Vendor',
                'view' => 'view_vendor',
                'table' => 'vendor',
                'pk' => 'idvendor',
                'fields' => [
                    'nama_vendor' => 'Nama Vendor',
                    'badan_hukum' => 'Badan Hukum',
                    'status' => 'Status'
                ]
            ],

            'user' => [
                'title' => 'User',
                'view' => 'view_user',
                'table' => 'user',
                'pk' => 'iduser',
                'fields' => [
                    'username' => 'Username',
                    'password' => 'Password',
                    'idrole' => 'Role'
                ]
            ],

            'barang' => [
                'title' => 'Barang',
                'view' => 'view_barang',
                'table' => 'barang',
                'pk' => 'idbarang',
                'fields' => [
                    'nama' => 'Nama Barang',
                    'jenis' => 'Jenis',
                    'harga' => 'Harga',
                    'status' => 'Status',
                    'idsatuan' => 'Satuan'
                ]
            ],

            'margin' => [
                'title' => 'Margin Penjualan',
                'view' => 'view_margin',
                'table' => 'margin_penjualan',
                'pk' => 'idmargin_penjualan',
                'fields' => [
                    'persen' => 'Persentase Margin',
                    'status' => 'Status',
                    'iduser' => 'Pembuat'
                ]
            ]
        ];

        abort_unless(isset($data[$menu]), 404);

        return $data[$menu];
    }

    private function getOptions($menu)
    {
        $options = [];

        if ($menu == 'user') {
            $options['idrole'] = DB::table('role')
                ->get(['idrole', 'nama_role']);
        }

        if ($menu == 'barang') {
            $options['idsatuan'] = DB::table('satuan')
                ->get(['idsatuan', 'nama_satuan']);
        }

        if ($menu == 'margin') {
            $options['iduser'] = DB::table('user')
                ->get(['iduser', 'username']);
        }

        return $options;
    }

   public function index($menu)
{
    $config = $this->config($menu);

    $data = DB::table($config['view'])->paginate(10);

    $columns = [
        'role' => [
            'idrole' => 'ID',
            'nama_role' => 'Nama Role'
        ],
        'satuan' => [
            'idsatuan' => 'ID',
            'nama_satuan' => 'Nama Satuan',
            'status_keterangan' => 'Status'
        ],
        'vendor' => [
            'idvendor' => 'ID',
            'nama_vendor' => 'Nama Vendor',
            'badan_hukum' => 'Badan Hukum',
            'status' => 'Status'
        ],
        'user' => [
            'iduser' => 'ID',
            'username' => 'Username',
            'idrole' => 'ID Role',
            'nama_role' => 'Nama Role'
        ],
        'barang' => [
            'idbarang' => 'ID',
            'nama_barang' => 'Nama Barang',
            'jenis' => 'Jenis',
            'harga' => 'Harga',
            'status_keterangan' => 'Status',
            'nama_satuan' => 'Satuan'
        ],
        'margin' => [
            'idmargin_penjualan' => 'ID',
            'persen' => 'Persentase',
            'status_keterangan' => 'Status',
            'created_at' => 'Dibuat',
            'updated_at' => 'Diubah',
            'pembuat' => 'Pembuat'
        ]
    ];

    return view('crud.index', [
        'data' => $data,
        'config' => $config,
        'menu' => $menu,
        'columns' => $columns[$menu]
    ]);
}

    public function create($menu)
    {
        $config = $this->config($menu);
        $options = $this->getOptions($menu);

        return view('crud.form', [
            'config' => $config,
            'menu' => $menu,
            'options' => $options,
            'item' => null,
            'mode' => 'create'
        ]);
    }

    public function store(Request $request, $menu)
    {
        $config = $this->config($menu);

        $fields = array_keys($config['fields']);

        $rules = [];

        foreach ($fields as $field) {
            $rules[$field] = 'required';
        }

        if ($menu == 'user') {
            $rules['password'] = 'required|min:6';
        }

        if ($menu == 'satuan' || $menu == 'vendor'
            || $menu == 'barang' || $menu == 'margin') {
            $rules['status'] = 'required|in:0,1';
        }

        $request->validate($rules);

        $insert = $request->only($fields);

        if ($menu == 'user') {
            $insert['password'] = Hash::make($request->password);
        }

        DB::table($config['table'])->insert($insert);

        return redirect()
            ->route('crud.index', $menu)
            ->with('success', 'Data berhasil ditambahkan.');
    }

    public function edit($menu, $id)
    {
        $config = $this->config($menu);

        $item = DB::table($config['table'])
            ->where($config['pk'], $id)
            ->first();

        abort_if(!$item, 404);

        $options = $this->getOptions($menu);

        return view('crud.form', [
            'config' => $config,
            'menu' => $menu,
            'options' => $options,
            'item' => $item,
            'mode' => 'edit'
        ]);
    }

    public function update(Request $request, $menu, $id)
    {
        $config = $this->config($menu);

        $fields = array_keys($config['fields']);

        $rules = [];

        foreach ($fields as $field) {
            $rules[$field] = 'required';
        }

        if ($menu == 'user') {
            $rules['password'] = 'nullable|min:6';
        }

        if ($menu == 'satuan' || $menu == 'vendor'
            || $menu == 'barang' || $menu == 'margin') {
            $rules['status'] = 'required|in:0,1';
        }

        $request->validate($rules);

        $update = $request->only($fields);

        if ($menu == 'user') {
            if ($request->filled('password')) {
                $update['password'] = Hash::make($request->password);
            } else {
                unset($update['password']);
            }
        }

        DB::table($config['table'])
            ->where($config['pk'], $id)
            ->update($update);

        return redirect()
            ->route('crud.index', $menu)
            ->with('success', 'Data berhasil diubah.');
    }

    public function destroy($menu, $id)
    {
        $config = $this->config($menu);

        DB::table($config['table'])
            ->where($config['pk'], $id)
            ->delete();

        return redirect()
            ->route('crud.index', $menu)
            ->with('success', 'Data berhasil dihapus.');
    }
}
