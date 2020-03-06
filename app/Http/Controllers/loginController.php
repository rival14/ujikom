<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DB;
use Validator;
use Session;

class loginController extends Controller
{
	public function login()
	{
    	return view('login.index');
	}

	public function loginMember(Request $Request)
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
	    	$cekuser = DB::table('masyarakat')->where('username', Request('username'))->first();

	    	if ($cekuser) {
	    		if (Request('pwd') == $cekuser->password) {
	    			Session::put('login',true);
	    			Session::put('nik',$cekuser->nik);
	    			Session::put('nama',$cekuser->nama);
	    			Session::put('username',$cekuser->username);
                    Session::put('foto',$cekuser->foto_user);
	    			return redirect('dashboard')->with(['sukses' => 'Halo ' .$cekuser->nama. '! Selamat datang di website Pengaduan dan Pelaporan Masyarakat!']);
	    		}else{
	    			return redirect('login')->withErrors('Username atau Password Salah !');
	    		}
	    	}else{
	    		return redirect('login')->withErrors('Username atau Password Salah !');
	    	}
    	}
	}

	public function daftar()
	{
    	return view('login.daftar');
	}

	public function daftarMember(Request $Request)
	{
		$validasi = Validator::make($Request->all(), [
    		'nik' => 'required|numeric|digits:16',
    		'nama' => 'required|regex:/^[\pL\s\-]+$/u',
    		'username' => 'required|unique:masyarakat|regex:^[a-zA-Z0-9_-]+^',
    		'pwd' => 'required',
            'telp' => 'required|numeric',
    	]);

    	if ($validasi->fails()) {
            return redirect('daftar')
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

            return redirect('login')->with(['sukses' => 'Sukses Mendatar Sebagai Pelapor!']);
        }
	}

	public function logout()
	{
    	if (Session::has('login')) {
    		Session::flush();
    		return redirect('/');
    	}else{
    		return redirect('/')->withErrors('Gagal Keluar!');
    	}
	}
}
