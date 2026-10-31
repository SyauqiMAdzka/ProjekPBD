<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    public function index()
    {
       $totalRole = DB::select("SELECT COUNT(*) AS total FROM view_role")[0]->total;
        $totalSatuan = DB::select("SELECT COUNT(*) AS total FROM view_satuan")[0]->total;
        $totalVendor = DB::select("SELECT COUNT(*) AS total FROM view_vendor")[0]->total;
        $totalUser = DB::select("SELECT COUNT(*) AS total FROM view_user")[0]->total;
        $totalBarang = DB::select("SELECT COUNT(*) AS total FROM view_barang")[0]->total;
        $totalMargin = DB::select("SELECT COUNT(*) AS total FROM view_margin")[0]->total;

        return view('dashboard', compact(
            'totalRole',
            'totalSatuan',
            'totalVendor',
            'totalUser',
            'totalBarang',
            'totalMargin'
        ));
    }
}
