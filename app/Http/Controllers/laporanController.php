<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DB;
use App\Exports\laporanExport;
use Maatwebsite\Excel\Facades\Excel;

class laporanController extends Controller
{
    public function laporanIndex()
    {
    	$data = DB::table('pengaduan')->where('status', 'selesai')->paginate(10);
    	return view('admin.laporan', compact('data'));
    }

    public function laporanExport()
    {
        return Excel::download(new laporanExport, 'Laporan Pengaduan.xlsx');
    }
}
