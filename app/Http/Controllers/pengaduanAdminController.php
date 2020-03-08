<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DB;
use Validator;
use Carbon\Carbon;
use Session;

class pengaduanAdminController extends Controller
{
    public function pengaduanIndex()
    {
        $data = DB::table('pengaduan')->orderBy('status', 'asc')->paginate(10);
        $petugas = DB::table('pengaduan')->whereIn('status', ['0','proses'])->paginate(10);

        return view('admin.pengaduan', ['data' => $data, 'petugas' => $petugas]);
    	
    }

    public function pengaduanCari(Request $Request)
    {
        if (Session::get('status') === 'admin') {
            if (Request('cari') == '') {
                return redirect('admin/pengaduan');
            }else{
                $data = DB::table('pengaduan')->where('judul', 'like', '%'.Request('cari').'%')
                    ->orwhere('tgl_pengaduan', 'like', '%'.Request('cari').'%')
                    ->paginate(10);        

                return view('admin.pengaduan', compact('data'));
            }
        }elseif (Session::get('status') === 'petugas') {
            if (Request('cari') == '') {
                return redirect('admin/pengaduan');
            }else{
                $data = DB::table('pengaduan')->paginate(10);
                $petugas = DB::table('pengaduan')->whereIn('status', ['0','proses'])
                    ->where('judul', 'like', '%'.Request('cari').'%')
                    ->paginate(10);        

                return view('admin.pengaduan', compact('petugas'), compact('data'));
            }
        }
    }

    public function pengaduanFilterIndex(Request $Request)
    {
        if (Request('cari') == '' && Request('status') == '') {
            return redirect('admin/pengaduan');
        }elseif (Request('cari') == '') {
            $data = DB::table('pengaduan')
                ->where('status', 'like', '%'.Request('status').'%')
                ->paginate(10);        

            return view('admin.pengaduan', compact('data'));
        }elseif (Request('status') == '') {
            $data = DB::table('pengaduan')
                ->where('judul', 'like', '%'.Request('judul').'%')
                ->orderBy('status', 'asc')
                ->paginate(10);        

            return view('admin.pengaduan', compact('data'));
        }else{
            $data = DB::table('pengaduan')
                ->where('status', 'like', '%'.Request('status').'%')
                ->where('judul', 'like', '%'.Request('cari').'%')
                ->paginate(10);        

            return view('admin.pengaduan', compact('data'));
        }
        $data = DB::table('pengaduan')->where()->paginate(10);
    }

    public function pengaduanAjax($id)
    {
        $ajax = DB::table('pengaduan')->where('id_pengaduan', $id)->join('masyarakat', 'pengaduan.nik', '=', 'masyarakat.nik')->first();

        return response()->json($ajax);
    }

    public function pengaduanKonfirmasi(Request $Request)
    {
    	$validasi = Validator::make($Request->all(), [
    		'id_pengaduan' => 'required',
    	]);

    	if ($validasi->fails()) {
            return redirect('admin/pengaduan')
                        ->withErrors($validasi)
                        ->withInput();
        }else{
	        DB::table('pengaduan')->where('id_pengaduan', Request('id_pengaduan'))->update([
	        	'status' => 'proses',
	        ]);

	        return redirect('/admin/pengaduan')->with('sukses', 'Sukses Mengkonfirmasi Pengaduan');
    	}
    }

    public function pengaduanSelesai(Request $Request)
    {
    	$validasi = Validator::make($Request->all(), [
    		'id_pengaduan' => 'required',
    		'tanggapan' => 'required',
    	]);

    	if ($validasi->fails()) {
            return redirect('admin/pengaduan')
                        ->withErrors($validasi)
                        ->withInput();
        }else{
	        DB::table('pengaduan')->where('id_pengaduan', Request('id_pengaduan'))->update([
	        	'status' => 'selesai',
	        ]);
	        DB::table('tanggapan')->insert([
	        	'id_pengaduan' => Request('id_pengaduan'),
	        	'tgl_tanggapan' => Carbon::now(),
	        	'tanggapan' => Request('tanggapan'),
	        	'id_petugas' => Session::get('id_petugas'),
	        ]);

	        return redirect('/admin/pengaduan')->with('sukses', 'Sukses Menyelesaikan Pengaduan');
    	}
    }
}
