@extends('layout.admin')
@section('title')
@section('content')

<script type="text/javascript">
	function fotoProfile(input) {
		if (input.files && input.files[0]) {
		var reader = new FileReader();
		 
		reader.onload = function (e) { 
			document.getElementById("fotoprofile").style.visibility = "visible";
		$('#fotoprofile')
		.attr('src', e.target.result);
		};
			 
		reader.readAsDataURL(input.files[0]);
		}
	}
</script>

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
	<div class="card mb-5">
	  <div class="card-header text-light" style="background-color: black;">
	    Profile
	  </div>
	  <div class="card-body">
	  	<h3 class="text-center">Profile</h3>
	  	<form action="{{ route('admin.profile') }}" method="POST" class="col-md-10 mx-auto" enctype="multipart/form-data">
	  		@csrf
	  		<input type="hidden" class="form-control" value="{{ $data->id_petugas }}" name="id_petugas">
		  <div class="form-group">
		    <label>Nama</label>
		    <input type="text" class="form-control" value="{{ $data->nama_petugas }}" name="nama">
		  </div>
		  <div class="form-group">
		    <label>Username</label>
		    <input type="text" class="form-control" value="{{ $data->username }}" name="username">
		  </div>
		  <div class="form-group">
		    <label>Telepon</label>
		    <input type="text" class="form-control" value="{{ $data->telp }}" name="telp">
		  </div>
			<label>Upload Foto</label>	
			<div class="input-group mb-3">
			  <div class="custom-file">
			    <input type="file" class="custom-file-input" accept="image/*" onchange="fotoProfile(this);" name="foto">
			    <label class="custom-file-label">Pilih Foto</label>
			  </div>
			</div>
			<label>Foto</label>	
			<div class="card mb-3" style="width: 18rem;">
			  <img src="{{ asset('storage/petugas/profile') }}/{{ $data->foto_petugas }}" class="card-img-top rounded" alt="Preview" id="fotoprofile">
			</div>
		  <button type="submit" class="btn btn-primary">Simpan Profile</button>
		</form>
	  </div>
	</div>
</div>

@endsection