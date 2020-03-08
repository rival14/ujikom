<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DB;
use Session;
use Validator;
use Carbon\Carbon;
use File;
use Storage;
use Illuminate\Validation\Rule;

class adminController extends Controller
{
    public function adminIndex()
    {
    	$belumkonfirmasi = DB::table('pengaduan')->where('status', '0')->count();
    	$sudahkonfirmasi = DB::table('pengaduan')->where('status', 'proses')->count();
    	$ok = DB::table('pengaduan')->where('status', 'selesai')->count();

    	return view('admin.index', ['belumkonfirmasi' => $belumkonfirmasi, 'sudahkonfirmasi' => $sudahkonfirmasi, 'ok' => $ok]);
    }

    public function adminProfile()
    {   
        $session = Session::get('id_petugas');
        $data = DB::table('petugas')->where('id_petugas', $session)->first();

        return view('admin.profile', compact('data'));
    }

    public function adminProfileUpdate(Request $Request)
    {   
        $validasi = Validator::make($Request->all(), [
            'id_petugas' => 'required',
            'nama' => 'required|regex:/[a-zA-Z0-9\s]+/',
            'username' => 'required|regex:^[a-zA-Z0-9_-]+^',
            'telp' => 'required|numeric',
            'foto' => 'nullable|image',
        ]);

        if ($validasi->fails()) {
            return redirect('admin/profile')
                        ->withErrors($validasi)
                        ->withInput();
        }else{
            if (!$Request->file('foto')) {
                DB::table('petugas')->where('id_petugas', Request('id_petugas'))->update([
                    'nama_petugas' => Request('nama'),
                    'username' => Request('username'),
                    'telp' => Request('telp'),
                ]);

                return redirect('admin/profile')->with('sukses', 'Sukses Mengupdate Data!');
            }else{
                $foto = $Request->file('foto');
                $saveto = storage_path('app/public/petugas/profile');
                $nama = Carbon::now()->timestamp . '_' . uniqid() . '.' . $foto->getClientOriginalExtension();

                $foto->move($saveto, $nama);

                DB::table('petugas')->where('id_petugas', Request('id_petugas'))->update([
                    'nama_petugas' => Request('nama'),
                    'username' => Request('username'),
                    'telp' => Request('telp'),
                    'foto_petugas' => $nama,
                ]);
                Session::put('foto',$nama);

                return redirect('admin/profile')->with('sukses', 'Sukses Mengupdate Data!');
            }
        }
    }

    public function adminPassword()
    {
        return view('admin.gantipassword');
    }

    public function adminGantiPassword(Request $Request)
    {
        $validasi = Validator::make($Request->all(), [
            'password' => [
                'required',
                Rule::exists('petugas')->where('id_petugas', Session::get('id_petugas')),
            ],
            'pwdbaru' => 'required',
            'pwdkonfirmasi' => 'required|same:pwdbaru',
        ]);

        if ($validasi->fails()) {
            return redirect('admin/password')
                        ->withErrors($validasi)
                        ->withInput();
        }else{
            DB::table('petugas')->where('id_petugas', Session::get('id_petugas'))->update([
                'password' => Request('pwdbaru')
            ]);

            return redirect('admin/password')->with('sukses', 'Sukses Mengubah Password!');
        }
    }
}
