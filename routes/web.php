<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', 'indexController@index');
Route::get('/pengaduan', 'indexController@pengaduan');
Route::get('/caripengaduan', 'indexController@caripengaduan')->name('pengaduanindex.cari');

Route::middleware(['login'])->group(function () {
	Route::get('/daftar', 'loginController@daftar');
	Route::post('/daftar', 'loginController@daftarMember')->name('daftar');
	Route::get('/login', 'loginController@login');
	Route::post('/login', 'loginController@loginMember')->name('login');
});

Route::get('/logout', 'loginController@logout');

Route::get('/loginadmin', 'loginadminController@login');
Route::post('/loginadmin', 'loginadminController@loginAdmin')->name('login.admin');

Route::middleware(['Masyarakat', 'XSS'])->group(function () {
	Route::get('/dashboard', 'dashboardController@dashboardIndex');
	Route::get('/dashboard/profile', 'dashboardController@dashboardProfile');
	Route::post('/dashboard/profile/update', 'dashboardController@dashboardProfileUpdate')->name('dashboard.profile');
	Route::get('/dashboard/password', 'dashboardController@dashboardPassword');
	Route::post('/dashboard/password', 'dashboardController@dashboardGantiPassword')->name('dashboard.pwd');

	Route::get('/dashboard/pengaduan', 'pengaduanPenggunaController@pengaduanIndex');
	Route::get('/dashboard/pengaduan/cari/', 'pengaduanPenggunaController@pengaduanCari')->name('pengaduanPengguna.cari');
	Route::get('/dashboard/pengaduan/hapus/{id}', 'pengaduanPenggunaController@pengaduanHapus');
	Route::get('/dashboard/pengaduan/ajax/{id}', 'pengaduanPenggunaController@pengaduanAjax');
	Route::get('/dashboard/pengaduan/ajaxselesai/{id}', 'pengaduanPenggunaController@pengaduanAjaxSelesai');
	Route::post('/dashboard/pengaduan/ubah', 'pengaduanPenggunaController@pengaduanUbah')->name('pengaduan.ubah');
	Route::post('/dashboard/pengaduan/tambah', 'pengaduanPenggunaController@pengaduanTambah')->name('pengaduan.tambah');
});

Route::middleware(['adminLogin', 'XSS'])->group(function () {
	Route::get('/admin', 'adminController@adminIndex');
	Route::get('/admin/profile', 'adminController@adminProfile');
	Route::post('/admin/profile/update', 'adminController@adminProfileUpdate')->name('admin.profile');
	Route::get('/admin/password', 'adminController@adminPassword');
	Route::post('/admin/password', 'adminController@adminGantiPassword')->name('admin.pwd');

	Route::get('/admin/petugas', 'petugasController@petugasIndex');
	Route::get('/admin/petugas/cari/', 'petugasController@petugasCari')->name('petugas.cari');
	Route::get('/admin/petugas/hapus/{id}', 'petugasController@petugasHapus');
	Route::get('/admin/petugas/ajax/{id}', 'petugasController@petugasAjax');
	Route::post('/admin/petugas/ubah', 'petugasController@petugasUbah')->name('petugas.ubah');
	Route::post('/admin/petugas/tambah', 'petugasController@petugasTambah')->name('petugas.tambah');

	Route::get('/admin/pengguna', 'masyarakatController@penggunaIndex');
	Route::get('/admin/pengguna/cari/', 'masyarakatController@penggunaCari')->name('pengguna.cari');
	Route::get('/admin/pengguna/hapus/{id}', 'masyarakatController@penggunaHapus');
	Route::get('/admin/pengguna/ajax/{id}', 'masyarakatController@penggunaAjax');
	Route::post('/admin/pengguna/ubah', 'masyarakatController@penggunaUbah')->name('pengguna.ubah');
	Route::post('/admin/pengguna/tambah', 'masyarakatController@penggunaTambah')->name('pengguna.tambah');

	Route::get('/admin/pengaduan', 'pengaduanAdminController@pengaduanIndex');
	Route::get('/admin/pengaduan/filter', 'pengaduanAdminController@pengaduanFilterIndex')->name('pengaduan.filter');
	Route::get('/admin/pengaduan/cari/', 'pengaduanAdminController@pengaduanCari')->name('pengaduan.cari');
	Route::get('/admin/pengaduan/hapus/{id}', 'pengaduanAdminController@pengaduanHapus');
	Route::get('/admin/pengaduan/ajax/{id}', 'pengaduanAdminController@pengaduanAjax');
	Route::post('/admin/pengaduan/konfirmasi', 'pengaduanAdminController@pengaduanKonfirmasi')->name('pengaduan.konfirmasi');
	Route::post('/admin/pengaduan/selesai', 'pengaduanAdminController@pengaduanSelesai')->name('pengaduan.selesai');

	Route::get('/admin/laporan', 'laporanController@laporanIndex');
	Route::get('/admin/laporan/export/', 'laporanController@laporanExport');
});
