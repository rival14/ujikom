<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DB;
use Session;
use Validator;
use Carbon\Carbon;
use File;
use Storage;

class dashboardController extends Controller
{
    public function dashboardIndex()
    {
    	$belumkonfirmasi = DB::table('pengaduan')->where('status', '0')->where('nik', Session::get('nik'))->count();
    	$sudahkonfirmasi = DB::table('pengaduan')->where('status', 'proses')->where('nik', Session::get('nik'))->count();
    	$ok = DB::table('pengaduan')->where('status', 'selesai')->where('nik', Session::get('nik'))->count();

    	return view('dashboard.index', ['belumkonfirmasi' => $belumkonfirmasi, 'sudahkonfirmasi' => $sudahkonfirmasi, 'ok' => $ok]);
    }

    public function dashboardProfile()
    {   
        $session = Session::get('nik');
        $data = DB::table('masyarakat')->where('nik', $session)->first();

        return view('dashboard.profile', compact('data'));
    }

    public function dashboardProfileUpdate(Request $Request)
    {   
        $validasi = Validator::make($Request->all(), [
            'nik' => 'required',
            'nama' => 'required|regex:/[a-zA-Z0-9\s]+/',
            'username' => 'required|regex:^[a-zA-Z0-9_-]+^',
            'telp' => 'required|numeric',
            'foto' => 'nullable|image',
        ]);

        if ($validasi->fails()) {
            return redirect('dashboard/profile')
                        ->withErrors($validasi)
                        ->withInput();
        }else{
            $foto = $Request->file('foto');
            $saveto = storage_path('app/public/masyarakat/profile');
            $nama = Carbon::now()->timestamp . '_' . uniqid() . '.' . $foto->getClientOriginalExtension();

            $foto->move($saveto, $nama);

            DB::table('masyarakat')->where('nik', Request('nik'))->update([
                'nama' => Request('nama'),
                'username' => Request('username'),
                'telp' => Request('telp'),
                'foto_user' => $nama,
            ]);

            return redirect('dashboard/profile')->with('sukses', 'Sukses Mengupdate Data!');
        }
    }
}
