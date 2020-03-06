@extends('layout.admin')
@section('title')
@section('content')

<!-- Hapus & Edit -->
<script type="text/javascript">
	function hapus(nik) {
		Swal.fire({
		  title: 'Anda yakin ingin menghapus?',
		  text: "Anda tidak dapat mengembalikannya.",
		  icon: 'warning',
		  showCancelButton: true,
		  confirmButtonColor: '#3085d6',
		  cancelButtonColor: '#d33',
		  confirmButtonText: 'Ya, Hapus!'
		}).then((result) => {
		  if (result.value) {
		    window.location.href = "{{ url('/admin/pengguna/hapus') }}/"+nik;
		  }
		})
	}

	function edit(nik) {
		$.ajax({
			url: "{{ url('/admin/pengguna/ajax/') }}/"+nik,
			type: "GET",
			success: function (data) {
				$('#nik').val(data.nik);
				$('#nama').val(data.nama);
				$('#username').val(data.username);
				$('#pwd').val(data.password);
				$('#telp').val(data.telp);

				$('#modalEdit').modal('show');
			}
		});
	}
</script>
<!-- Hapus & Edit End -->

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
	    Data Pengguna
	  </div>
	  <div class="card-body">
	  	<button class="btn btn-primary ml-auto" data-toggle="modal" data-target="#modalTambah">+ Tambah Pengguna</button>
	  	<form class="form-inline float-right mb-2" action="{{ route('pengguna.cari') }}" method="GET">
	      <input class="form-control mr-sm-2" type="search" placeholder="Cari Data Pengguna" name="cari">
	      <button class="btn btn-outline-success my-2 my-sm-0" type="submit">Cari</button>
	    </form>
	    <table class="table mt-2 table-responsive">
		  <thead style="background-color: black;" class="text-light">
		    <tr class="text-center">
		      <th scope="col" width="2%">#</th>
		      <th scope="col">NIK</th>
		      <th scope="col">Nama</th>
		      <th scope="col">Username</th>
		      <th scope="col">Telepon</th>
		      <th scope="col">Aksi</th>
		    </tr>
		  </thead>
		  <tbody>
		  	@php 
		  		$a = 1;
		  	@endphp
		  	@foreach($data as $pengguna)
		    <tr class="text-center">
		      <th scope="row">{{ $a }}</th>
		      <td>
		      @php 
		      	$sensor = mb_substr($pengguna->nik, 4, 8); 
		      	$sensor2 = explode($sensor,$pengguna->nik);
		      	$hasil=$sensor2[0]."********".$sensor2[1];
		      	echo $hasil;
		      @endphp
		  	  </td>
		      <td>{{ $pengguna->nama }}</td>
		      <td>{{ $pengguna->username }}</td>
		      <td>{{ $pengguna->telp }}</td>
		      <td class="mx-auto">
		      	<button class="btn btn-warning col-md-5" onclick="edit({{ $pengguna->nik }})" data-toggle="tooltip" data-placement="top" title="Edit Pengguna">Edit &nbsp;<i class="fa fa-edit"></i></button>  
		      	<button class="btn btn-danger col-md-5" onclick="hapus({{ $pengguna->nik }})" data-toggle="tooltip" data-placement="top" title="Hapus Pengguna">Hapus &nbsp;<i class="fa fa-trash"></i></button>
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


<!-- Modal Tambah -->
<div class="modal fade" tabindex="-1" role="dialog" aria-hidden="true" id="modalTambah">
  <div class="modal-dialog modal-dialog-centered" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title">+Tambah Pengguna</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <form method="POST" action="{{ route('pengguna.tambah') }}">
        	@csrf
          <div class="form-group">
		    <label>NIK</label>
		    <input type="text" class="form-control" placeholder="Nomor Induk Kependudukan" name="nik">
		  </div>
		  <div class="form-group">
		    <label>Nama Pengguna</label>
		    <input type="text" class="form-control" placeholder="Nama Pengguna" name="nama">
		  </div>
		  <div class="form-group">
		    <label>Username</label>
		    <input type="text" class="form-control" placeholder="Username" name="username">
		  </div>
		  <div class="form-group">
		    <label>Password</label>
		    <input type="password" class="form-control" placeholder="Password" name="pwd">
		  </div>
		  <div class="form-group">
		    <label>Nomor Telepon</label>
		    <input type="text" maxlength="13" class="form-control" placeholder="Nomor Telepon" name="telp">
		  </div>
        <button type="submit" class="btn btn-primary mb-2 float-right">Simpan Data</button>
		</form>
      </div>
    </div>
  </div>
</div>
<!-- End Modal Tambah -->

<!-- Modal Edit -->
<div class="modal fade" tabindex="-1" role="dialog" aria-hidden="true" id="modalEdit">
  <div class="modal-dialog modal-dialog-centered" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title">Edit Pengguna</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <form method="POST" action="{{ route('pengguna.ubah') }}">
        	@csrf
		  <div class="form-group">
		    <label>NIK</label>
		    <input type="text" class="form-control" placeholder="Nomor Induk Kependudukan" name="nik" id="nik">
		  </div>
		  <div class="form-group">
		    <label>Nama Pengguna</label>
		    <input type="text" class="form-control" placeholder="Nama Pengguna" name="nama" id="nama">
		  </div>
		  <div class="form-group">
		    <label>Username</label>
		    <input type="text" class="form-control" placeholder="Username" name="username" id="username">
		  </div>
		  <div class="form-group">
		    <label>Password</label>
		    <input type="password" class="form-control" placeholder="Password" name="pwd" id="pwd">
		  </div>
		  <div class="form-group">
		    <label>Nomor Telepon</label>
		    <input type="text" maxlength="13" class="form-control" placeholder="Nomor Telepon" name="telp" id="telp">
		  </div>
      <button type="submit" class="btn btn-info mb-2 float-right">Ubah Data</button>
      <button type="button" class="btn btn-danger mb-2 mx-2 float-right" data-dismiss="modal">Tutup</button>
		</form>
      </div>
    </div>
  </div>
</div>
<!-- End Modal Edit -->
@endsection