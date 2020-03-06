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
			html: '{{ $pesan }}',
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

<div class="container mx-auto bg-white rounded position-relative d-flex mt-5 warna">
	<h2 class="mx-auto text-center my-auto tulisan" style="text-shadow: 4px 2px 4px rgba(91,113,135,1);">WEBSITE PELAPORAN<br>DAN PENGADUAN</h2>
	<form class="mx-auto col-md-6 my-5" action="{{ route('login.admin') }}" method="POST">
		@csrf
		<h3 class="text-center mb-5 tulisan" style="text-shadow: 4px 2px 4px rgba(91,113,135,1);">LOGIN SEBAGAI<br> ADMIN</h3>
	  <div class="form-group">
	    <input type="text" class="form-control" placeholder="Username" name="username">
	  </div>
	  <div class="form-group">
	    <input type="Password" class="form-control" placeholder="Password" name="pwd">
	  </div>
	  <button type="submit" class="btn btn-primary float-right col-md-4">Submit</button>
	</form>

</div>

@endsection