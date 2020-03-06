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
	    Ubah Password
	  </div>
	  <div class="card-body">
	  	<h3 class="text-center">Ubah Password<br><i class="fa fa-lock fa-3x"></i></h3>
	  	<form action="{{ route('admin.profile') }}" method="POST" class="col-md-10 mx-auto" enctype="multipart/form-data">
	  		@csrf
	  		<input type="hidden" class="form-control" name="id_petugas">
		  <div class="form-group">
		    <label>Password Lama</label>
		    <input type="password" class="form-control" name="pwdlama">
		  </div>
		  <div class="form-group">
		    <label>Password Baru</label>
		    <input type="password" class="form-control" name="pwdbaru">
		  </div>
		  <div class="form-group">
		    <label>Konfirmasi Password Baru</label>
		    <input type="password" class="form-control" name="pwdkonfirmasi">
		  </div>
		  <button type="submit" class="btn btn-primary">Simpan Password</button>
		</form>
	  </div>
	</div>
</div>

@endsection