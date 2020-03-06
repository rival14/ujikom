@extends('layout.admin')
@section('title')
@section('content')

<div class="container mt-3 mx-auto">
	<h2>Dashboard admin</h2>
	@if ($pesan = Session::get('sukses'))
	<div class="alert alert-success" role="alert">
	  <marquee>{{ $pesan }}</marquee>
	</div>
	@endif
	<div class="card-deck">
		<div class="card text-white bg-warning mb-3 col-md-4">
		  <div class="card-header">Pengaduan Belum Terkonfirmasi</div>
		  <div class="card-body">
		    <h2 class="float-left">{{ $belumkonfirmasi }}</h2>
		    <h2 class="float-right">Data</h2>
		    <hr style="clear: both;">
		  </div>
		</div>
		<div class="card text-white bg-primary mb-3 col-md-4">
		  <div class="card-header">Pengaduan Telah Terkonfirmasi</div>
		  <div class="card-body">
		    <h2 class="float-left">{{ $sudahkonfirmasi }}</h2>
		    <h2 class="float-right">Data</h2>
		    <hr style="clear: both;">
		  </div>
		</div>
		<div class="card text-white bg-success mb-3 col-md-4">
		  <div class="card-header">Pengaduan Telah Selesai</div>
		  <div class="card-body">
		    <h2 class="float-left">{{ $ok }}</h2>
		    <h2 class="float-right">Data</h2>
		    <hr style="clear: both;">
		  </div>
		</div>
	</div>
</div>

@endsection