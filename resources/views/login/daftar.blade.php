@extends('layout.index')
@section('title')
@section('content')

<style type="text/css">
	.warna {
		background: rgb(238,174,202);
		background: radial-gradient(circle, rgba(238,174,202,1) 0%, rgba(148,187,233,1) 100%);	
	}
	footer {
		visibility: hidden;
	}
</style>

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

<div class="container mx-auto bg-white my-3 rounded position-relative d-flex mb-5 warna">
	<h2 class="mx-auto text-center my-auto tulisan" style="text-shadow: 4px 2px 4px rgba(91,113,135,1);">WEBSITE PELAPORAN<br>DAN PENGADUAN</h2>
	<form class="mx-auto col-md-6 my-5" action="{{ route('daftar') }}" method="POST">
		@csrf
		<h3 class="text-center tulisan" style="text-shadow: 4px 2px 4px rgba(91,113,135,1);">DAFTAR SEBAGAI<br> PELAPOR</h3>
	  <div class="form-group">
	    <input type="text" class="form-control" placeholder="Nomor Induk Kependudukan" name="nik">
	  </div>
	  <div class="form-group">
	    <input type="text" class="form-control" placeholder="Nama Anda" name="nama">
	  </div>
	  <div class="form-group">
	  	<div class="form-group">
	    <input type="text" class="form-control" placeholder="Username" name="username">
	  </div>
	  <div class="form-group">
	    <input type="Password" class="form-control" placeholder="Password" name="pwd">
	  </div>
	    <input type="text" class="form-control" placeholder="Nomor Telepon" name="telp">
	  </div>
	  <button type="submit" class="btn btn-primary float-right col-md-4">Submit</button>
	  <a href="{{ url('login') }}">Login &#8594;</a>
	</form>

</div>

@endsection