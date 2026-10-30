<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    public function index()
    {
        $totalRole = DB::table('view_role')->count();

        $totalSatuan = DB::table('view_satuan')->count();

        $totalVendor = DB::table('view_vendor')->count();

        $totalUser = DB::table('view_user')->count();

        $totalBarang = DB::table('view_barang')->count();

        $totalMargin = DB::table('view_margin')->count();

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
