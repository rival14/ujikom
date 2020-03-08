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
            if (!$Request->file('foto')) {
                DB::table('masyarakat')->where('nik', Request('nik'))->update([
                    'nama' => Request('nama'),
                    'username' => Request('username'),
                    'telp' => Request('telp'),
                ]);

                return redirect('dashboard/profile')->with('sukses', 'Sukses Mengupdate Data!');
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
                Session::put('foto',$nama);

                return redirect('dashboard/profile')->with('sukses', 'Sukses Mengupdate Data!');
            }
        }
    }

    public function dashboardPassword()
    {
        return view('admin.gantipassword');
    }

    public function dashboardGantiPassword(Request $Request)
    {
        $validasi = Validator::make($Request->all(), [
            'password' => [
                'required',
                Rule::exists('masyarakat')->where('nik', Session::get('nik')),
            ],
            'pwdbaru' => 'required',
            'pwdkonfirmasi' => 'required|same:pwdbaru',
        ]);

        if ($validasi->fails()) {
            return redirect('dashboard/password')
                        ->withErrors($validasi)
                        ->withInput();
        }else{
            DB::table('masyarakat')->where('nik', Session::get('nik'))->update([
                'password' => Request('pwdbaru')
            ]);

            return redirect('dashboard/password')->with('sukses', 'Sukses Mengubah Password!');
        }
    }
}
