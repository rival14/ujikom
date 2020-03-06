@extends('layout.index')
@section('title')
@section('content')

<div class="container my-4 text-center">
	<div class="alert alert-info">
		<p>SILAHKAN LOGIN/DAFTAR TERLEBIH DAHULU UNTUK MELAKUKAN PENGADUAN</p>
		<a href="{{ url('/login') }}" class="btn btn-primary mx-auto col-sm-1 my-1">MASUK</a>
		<a href="{{ url('/daftar') }}" class="btn btn-success mx-auto col-sm-1 my-1">DAFTAR</a>
	</div>

	<div class="card mb-5">
	  <div class="card-header text-light bg-dark">
	  	Pengaduan
	  </div>
	  <div class="card-body">
	  	<h3 class="text-center">DAFTAR PENGADUAN<br>MASYARAKAT</h3>
	  	<hr>
	  	<form class="form-inline float-right mb-2" action="{{ route('pengaduanindex.cari') }}" method="GET">
	      <input class="form-control mr-sm-2" type="search" placeholder="Cari Data Pengaduan" name="cari">
	      <button class="btn btn-outline-success my-2 my-sm-0" type="submit">Cari <i class="fa fa-search"></i></button>
	      <hr>
	    </form>
	    <table class="table mt-2 mb-5 table-responsive">
		  <thead class="text-light bg-dark">
		    <tr class="text-center">
		      <th scope="col" width="2%">#</th>
		      <th scope="col">Pengaduan</th>
		      <th scope="col">Tanggal Laporan</th>
		      <th scope="col">Status</th>
		    </tr>
		  </thead>
		  <tbody>
		  	@php 
		  		$a = 1;
		  	@endphp
		  	@foreach($data as $pengaduan)
		    <tr class="text-center">
		      <td scope="row">{{ $a }}</td>
		      <td>{{ $pengaduan->judul }}</td>
		      <td>{{ $pengaduan->tgl_pengaduan }}</td>
		      <td>
		      	@if ($pengaduan->status === '0')
		      		<span class="badge badge-warning">TERDAFTAR</span>
		      	@elseif ($pengaduan->status === 'proses')
		      		<span class="badge badge-info">PROSES</span>
		      	@elseif ($pengaduan->status === 'selesai')
		      		<span class="badge badge-success">SELESAI</span>
		      	@endif
		      </td>
		    </tr>
		    @php
		    $a++;
		    @endphp
		    @endforeach
		  </tbody>
		</table>
		  <div class="float-right">{{ $data->links() }}</div>
	  </div>
	</div>
</div>	

@endsection		