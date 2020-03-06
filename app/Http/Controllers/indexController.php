<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DB;

class indexController extends Controller
{
    public function index()
    {
    	return view('home.index');
    }

    public function pengaduan()
    {
    	$data = DB::table('pengaduan')->paginate(5);

    	return view('home.pengaduan', compact('data'));
    }

    public function caripengaduan(Request $Request)
    {
    	if (Request('cari') == '') {
            return redirect('pengaduan');
        }else{
            $data = DB::table('pengaduan')->where('judul', 'like', '%'.Request('cari').'%')
                ->orwhere('tgl_pengaduan', 'like', '%'.Request('cari').'%')
                ->paginate(10);        

            return view('home.pengaduan', compact('data'));
        }
    }
}
