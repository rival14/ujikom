<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DB;
use Validator;
use Session;

class loginadminController extends Controller
{
    public function login()
	{
    	return view('login.indexadmin');
	}

	public function loginAdmin(Request $Request)
	{
		$validasi = Validator::make($Request->all(), [
    		'username' => 'required',
    		'pwd' => 'required',
    	]);

    	if ($validasi->fails()) {
            return redirect('login')
                        ->withErrors($validasi)
                        ->withInput();
        }else{
	    	$cekuser = DB::table('petugas')->where('username', Request('username'))->first();

	    	if ($cekuser) {
	    		if (Request('pwd') == $cekuser->password) {
	    			Session::put('login',true);
	    			Session::put('id_petugas',$cekuser->id_petugas);
	    			Session::put('nama',$cekuser->nama_petugas);
	    			Session::put('username',$cekuser->username);
	    			Session::put('status',$cekuser->level);
	    			Session::put('foto',$cekuser->foto_petugas);
	    			return redirect('admin')->with(['sukses' => 'Halo ' .$cekuser->nama_petugas. '! Selamat datang di website Pengaduan dan Pelaporan Masyarakat!']);
	    		}else{
	    			return redirect('loginadmin')->withErrors('Username atau Password Salah !');
	    		}
	    	}else{
	    		return redirect('loginadmin')->withErrors('Username atau Password Salah !');
	    	}
	    }
	}
}
