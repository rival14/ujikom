@extends('layout.admin')
@section('title')
@section('content')

<!-- Notifikasi -->
@if ($pesan = Session::get('sukses'))
<script type="text/javascript">
	function sukses() {
		Swal.fire({
			icon: 'success',
			title: 'Sukses!',
			text: '{{ $pesan }}',
			timer: 1300
		});
	}
	sukses();
</script>
@endif

@if ($errors->any())
    <script type="text/javascript">
    	function notif() {
    		Swal.fire({
			  icon: 'error',
			  title: 'Oops...',
			  html: '@foreach ($errors->all() as $error)<p>{{ $error }}</p>@endforeach'
			});
    	}
    	notif();
    </script>
@endif
<!-- End Notifikasi -->

<div class="container mt-4">
	<div class="card">
	  <div class="card-header text-light" style="background-color: black;">
	    Data Pengaduan
	  </div>
	  <div class="card-body">
	    <a href="{{ url('/admin/laporan/export') }}" class="btn btn-success float-right mb-2">Export Excel &nbsp;<i class="fa fa-file-excel-o"></i></a>
	    <table class="table mt-2 table-responsive">
		  <thead style="background-color: black;" class="text-light">
		    <tr class="text-center">
		      <th scope="col" width="2%">#</th>
		      <th scope="col">Tanggal</th>
		      <th scope="col">Judul Pengaduan</th>
		      <th scope="col">Status</th>
		    </tr>
		  </thead>
		  <tbody>
		  	@php 
		  		$a = 1;
		  	@endphp
		  	@foreach($data as $pengaduan)
		    <tr class="text-center">
		      <th scope="row">{{ $a }}</th>
		      <td>{{ $pengaduan->tgl_pengaduan }}</td>
		      <td>{{ $pengaduan->judul }}</td>
		      <td>
		      	@if ($pengaduan->status === '0')
		      		<span class="badge badge-warning">BELUM DIKONFIRMASI</span>
		      	@elseif ($pengaduan->status === 'proses')
		      		<span class="badge badge-info">SEDANG DALAM PROSES</span>
		      	@elseif ($pengaduan->status === 'selesai')
		      		<span class="badge badge-success">TELAH SELESAI</span>
		      	@endif
		      </td>
		    </tr>
		    @php
		    $a++;
		    @endphp
		    @endforeach
		  </tbody>
		</table>
	  </div>
	</div>
</div>

@endsection