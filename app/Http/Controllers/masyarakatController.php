<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DB;
use Validator;

class masyarakatController extends Controller
{
    public function penggunaIndex()
    {
        $data = DB::table('masyarakat')->paginate(10);        

        return view('admin.masyarakat', compact('data'));
    }

    public function penggunaCari(Request $Request)
    {
    	if (Request('cari') == '') {
    		return redirect('admin/pengguna');
    	}else{
	        $data = DB::table('masyarakat')->where('nama', 'like', '%'.Request('cari').'%')
	        	->orwhere('nik', 'like', '%'.Request('cari').'%')
	        	->orwhere('username', 'like', '%'.Request('cari').'%')
	        	->paginate(10);        

	        return view('admin.masyarakat', compact('data'));
    	}
    }

    public function penggunaHapus($nik)
    {
        DB::table('masyarakat')->where('nik', $nik)->delete();
        return redirect('admin/pengguna')->with('sukses', 'Sukses Menghapus Data Pengguna!');
    }

    public function penggunaAjax($nik)
    {
        $ajax = DB::table('masyarakat')->where('nik', $nik)->first();

        return response()->json($ajax);
    }

    public function penggunaUbah(Request $Request)
    {
        $validasi = Validator::make($Request->all(), [
            'nik' => 'required|numeric|digits:16',
            'nama' => 'required|regex:/^[\pL\s\-]+$/u',
            'username' => 'required|regex:^[a-zA-Z0-9_-]+^',
            'pwd' => 'required',
            'telp' => 'required|numeric'
        ]);

        if ($validasi->fails()) {
            return redirect('admin/pengguna')
                        ->withErrors($validasi)
                        ->withInput();
        }else{
            DB::table('masyarakat')->where('nik', Request('nik'))->update([
            	'nik' => Request('nik'),
                'nama' => Request('nama'), 
                'username' => Request('username'), 
                'password' => Request('pwd'), 
                'telp' => Request('telp')
            ]);

            return redirect('admin/pengguna/')->with(['sukses' => 'Sukses Mengupdate Data Pengguna']);
        }
    }

    public function penggunaTambah(Request $Request)
    {
    	$validasi = Validator::make($Request->all(), [
    		'nik' => 'required|numeric|digits:16',
    		'nama' => 'required|regex:/^[\pL\s\-]+$/u',
    		'username' => 'required|unique:masyarakat|regex:^[a-zA-Z0-9_-]+^',
    		'pwd' => 'required',
            'telp' => 'required|numeric',
    	]);

    	if ($validasi->fails()) {
            return redirect('admin/pengguna')
                        ->withErrors($validasi)
                        ->withInput();
        }else{
            DB::table('masyarakat')->insert([
            	'nik' => Request('nik'),
                'nama' => Request('nama'), 
                'username' => Request('username'), 
                'password' => Request('pwd'), 
                'telp' => Request('telp')
            ]);

            return redirect('admin/pengguna')->with(['sukses' => 'Sukses Menambahkan Data Pengguna']);
        }
    }
}
