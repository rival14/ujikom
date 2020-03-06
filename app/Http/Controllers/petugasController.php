<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DB;
use Validator;

class petugasController extends Controller
{
    public function petugasIndex()
    {
        $data = DB::table('petugas')->paginate(10);

        return view('admin.petugas', compact('data'));
    }

    public function petugasCari(Request $Request)
    {
        if (Request('cari') == '') {
            return redirect('admin/petugas');
        }else{
            $data = DB::table('petugas')->where('nama_petugas', 'like', '%'.Request('cari').'%')
                ->orwhere('username', 'like', '%'.Request('cari').'%')
                ->orwhere('level', 'like', '%'.Request('cari').'%')
                ->paginate(10);        

            return view('admin.petugas', compact('data'));
        }
    }

    public function petugasHapus($id)
    {
        DB::table('petugas')->where('id_petugas', $id)->delete();
        return redirect('admin/petugas')->with('sukses', 'Sukses Menghapus Data Petugas!');
    }

    public function petugasAjax($id)
    {
        $ajax = DB::table('petugas')->where('id_petugas', $id)->first();

        return response()->json($ajax);
    }

    public function petugasUbah(Request $Request)
    {
        $validasi = Validator::make($Request->all(), [
            'nama' => 'required|regex:/^[\pL\s\-]+$/u',
            'username' => 'required|regex:^[a-zA-Z0-9_-]+^',
            'pwd' => 'required',
            'telp' => 'required|numeric',
            'level' => 'required'
        ]);

        if ($validasi->fails()) {
            return redirect('admin/petugas')
                        ->withErrors($validasi)
                        ->withInput();
        }else{
            DB::table('petugas')->where('id_petugas', Request('id'))->update([
                'nama_petugas' => Request('nama'), 
                'username' => Request('username'), 
                'password' => Request('pwd'), 
                'telp' => Request('telp'),
                'level' => Request('level')
            ]);

            return redirect('admin/petugas/')->with(['sukses' => 'Sukses Mengupdate Data Petugas']);
        }
    }

    public function petugasTambah(Request $Request)
    {
    	$validasi = Validator::make($Request->all(), [
    		'nama' => 'required|regex:/^[\pL\s\-]+$/u',
    		'username' => 'required|unique:petugas|regex:^[a-zA-Z0-9_-]+^',
    		'pwd' => 'required',
            'telp' => 'required|numeric',
    		'level' => 'required'
    	]);

    	if ($validasi->fails()) {
            return redirect('admin/petugas')
                        ->withErrors($validasi)
                        ->withInput();
        }else{
            DB::table('petugas')->insert([
                'nama_petugas' => Request('nama'), 
                'username' => Request('username'), 
                'password' => Request('pwd'), 
                'telp' => Request('telp'),
                'level' => Request('level')
            ]);

            return redirect('admin/petugas')->with(['sukses' => 'Sukses Menambahkan Data Petugas']);
        }
    }
}
