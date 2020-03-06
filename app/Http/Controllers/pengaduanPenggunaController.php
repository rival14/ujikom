<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DB;
use Validator;
use Session;
use File;
use Carbon\Carbon;
use Storage;

class pengaduanPenggunaController extends Controller
{
    public function pengaduanIndex()
    {
    	$data = DB::table('pengaduan')->where('nik', Session::get('nik'))->paginate(10);

    	return view('dashboard.pengaduan', compact('data'));
    }

    public function pengaduanCari(Request $Request)
    {
        if (Request('cari') == '') {
            return redirect('dashboard/pengaduan');
        }else{
            $data = DB::table('pengaduan')->where('nik', Session::get('nik'))
            	->where('judul', 'like', '%'.Request('cari').'%')
                ->paginate(10);        

            return view('dashboard.pengaduan', compact('data'));
        }
    }

    public function pengaduanHapus($id)
    {   
        $hapus = DB::table('pengaduan')->where('id_pengaduan', $id)->first();
        unlink(storage_path('app/public/gambar/'.$hapus->foto));
        DB::table('pengaduan')->where('id_pengaduan', $id)->delete();

        return redirect('dashboard/pengaduan')->with('sukses', 'Sukses Menghapus Pengaduan!');
    }

    public function pengaduanAjax($id)
    {
        $ajax = DB::table('pengaduan')->where('id_pengaduan', $id)->join('masyarakat', 'pengaduan.nik', '=', 'masyarakat.nik')->first();

        return response()->json($ajax);
    }

    public function pengaduanAjaxSelesai($id)
    {
        $ajax = DB::table('tanggapan')->where('tanggapan.id_pengaduan', $id)->join('pengaduan', 'tanggapan.id_pengaduan', '=', 'pengaduan.id_pengaduan')->join('petugas', 'tanggapan.id_petugas', '=', 'petugas.id_petugas')->first();

        return response()->json($ajax);
    }

    public function pengaduanTambah(Request $Request)
    {
    	$validasi = Validator::make($Request->all(), [
    		'judul' => 'required|regex:/^[\pL\s\-]+$/u',
    		'isi_laporan' => 'required|regex:/[a-zA-Z0-9\s]+/',
    		'foto' => 'required|image',
    	]);

    	if ($validasi->fails()) {
            return redirect('dashboard/pengaduan')
                        ->withErrors($validasi)
                        ->withInput();
        }else{
        	$foto = $Request->file('foto');
        	$saveto = storage_path('app/public/gambar');
        	$nama = Carbon::now()->timestamp . '_' . uniqid() . '.' . $foto->getClientOriginalExtension();
        	
        	$foto->move($saveto, $nama);

        	DB::table('pengaduan')->insert([
        		'tgl_pengaduan' => Carbon::now(),
        		'nik' => Session::get('nik'),
        		'judul' => Request('judul'),
        		'isi_laporan' => Request('isi_laporan'),
        		'foto' => $nama,
        	]);

        	return redirect('dashboard/pengaduan')->with('sukses', 'Sukses Melaporkan Pengaduan!');
        }
    }
}
