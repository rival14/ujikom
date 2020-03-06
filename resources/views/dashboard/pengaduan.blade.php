@extends('layout.admin')
@section('title')
@section('content')

<!-- Hapus & Edit -->
<script type="text/javascript">

	function hapus(id) {
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
		    window.location.href = "{{ url('/dashboard/pengaduan/hapus') }}/"+id;
		  }
		})
	}

	function detail(id) {
		$.ajax({
			url: "{{ url('/dashboard/pengaduan/ajax/') }}/"+id,
			type: "GET",
			success: function (data) {
				document.getElementById('dnama').innerHTML = data.nama;
				document.getElementById('dtgl').innerHTML = data.tgl_pengaduan;
				document.getElementById('djudul').innerHTML = data.judul;
				document.getElementById('disi').innerHTML = data.isi_laporan;
				document.getElementById('foto').src = "{{ asset('storage/gambar') }}/"+data.foto;
				if (data.status === '0') {
					document.getElementById('dstatus').innerHTML = 'BELUM DIKONFIRMASI';
				}else if(data.status === 'proses') {
					document.getElementById('dstatus').innerHTML = 'SEDANG DI PROSES';
				}else{
					document.getElementById('dstatus').innerHTML = 'SELESAI';
				}
				$('#modalDetail').modal('show');
			}
		});

		$('#modalInfo').modal('show');
	}

	function selesai(id) {
		$.ajax({
			url: "{{ url('/dashboard/pengaduan/ajaxselesai/') }}/"+id,
			type: "GET",
			success: function (data) {
				document.getElementById('stgl').innerHTML = data.tgl_pengaduan;
				document.getElementById('sjudul').innerHTML = data.judul;
				document.getElementById('stanggapan').innerHTML = data.tanggapan;
				document.getElementById('spetugas').innerHTML = data.nama_petugas;
				document.getElementById('stgl_selesai').innerHTML = data.tgl_tanggapan;
				if (data.status === '0') {
					document.getElementById('sstatus').innerHTML = 'BELUM DIKONFIRMASI';
				}else if(data.status === 'proses') {
					document.getElementById('sstatus').innerHTML = 'SEDANG DI PROSES';
				}else{
					document.getElementById('sstatus').innerHTML = 'SELESAI';
				}

				$('#modalSelesai').modal('show');
			}
		});

		$('#modalInfo').modal('show');
	}

	function TambahGambar(input) {
		if (input.files && input.files[0]) {
		var reader = new FileReader();
		 
		reader.onload = function (e) { 
			document.getElementById("preview_gambar").style.visibility = "visible";
		$('#preview_gambar')
		.attr('src', e.target.result).width(150);
		};
			 
		reader.readAsDataURL(input.files[0]);
		}
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
	    Data Pengaduan
	  </div>
	  <div class="card-body">
	  	<button class="btn btn-primary ml-auto" data-toggle="modal" data-target="#modalTambah"><i class="fa fa-plus-square"></i>&nbsp;Tambah Pengaduan</button>
	  	<form class="form-inline float-right mb-2" action="{{ route('pengaduanPengguna.cari') }}" method="GET">
	      <input class="form-control mr-sm-2" type="search" placeholder="Cari Data Pengaduan" name="cari">
	      <button class="btn btn-outline-success my-2 my-sm-0" type="submit">Cari <i class="fa fa-search"></i></button>
	    </form>
	    <table class="table mt-2 table-responsive">
		  <thead style="background-color: black;" class="text-light">
		    <tr class="text-center">
		      <th scope="col" width="2%">#</th>
		      <th scope="col">Tanggal</th>
		      <th scope="col">Judul Pengaduan</th>
		      <th scope="col">Status</th>
		      <th scope="col">Aksi</th>
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
		      <td class="mx-auto">
		      	<button class="btn btn-info col-md-5 text-center" onclick="detail({{ $pengaduan->id_pengaduan }});" data-toggle="tooltip" data-placement="top" title="Detail Pengaduan">
		      		<i class="fa fa-search"></i></i>
		      	</button>
		      	<button class="btn btn-warning col-md-5 mx-auto" onclick="hapus({{ $pengaduan->id_pengaduan }})" data-toggle="tooltip" data-placement="top" title="Hapus Pengaduan">
		      		<i class="fa fa-trash-o"></i>
		      	</button>
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
      <div class="modal-header bg-dark text-white">
        <h5 class="modal-title"><i class="fa fa-plus"></i>&nbsp;Tambah Pengaduan</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close" style="color: white;">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <form method="POST" action="{{ route('pengaduan.tambah') }}" enctype="multipart/form-data">
        	@csrf
		  <div class="form-group">
		    <label>Judul</label>
		    <input type="text" class="form-control" placeholder="Judul" name="judul">
		  </div>
		  <div class="form-group">
		    <label>Isi Laporan</label>
		    <textarea class="form-control" rows="3" name="isi_laporan"></textarea>
		  </div>
		  <div class="form-group">
		  	<label class="d-block">Foto :</label>
		    <img id="preview_gambar" src="#" alt="Foto" class="py-2" width="150" height="150" style="visibility: hidden;">
		    <input type="file" class="form-control-file" accept="image/*" onchange="TambahGambar(this);" name="foto">
		  </div>
        <button type="submit" class="btn btn-primary mb-2 float-right">Simpan Data</button>
		</form>
      </div>
    </div>
  </div>
</div>
<!-- End Modal Tambah -->

<!-- Modal Detail -->
<div class="modal fade" tabindex="-1" role="dialog" aria-hidden="true" id="modalDetail">
  <div class="modal-dialog modal-dialog-centered" role="document">
    <div class="modal-content">
      <div class="modal-header bg-dark text-white">
        <h5 class="modal-title">Edit Pengguna</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close" style="color: white;">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
		<table class="table table-striped table-bordered table-hover table-responsive">
		  <tbody>
		  	<tr class="table-success">
		      <td width="125">Nama Pelapor</td>
		      <td width="2%">:</td>
		      <td id="dnama"></td>
		    </tr>
		    <tr class="table-info">
		      <td width="125">Tanggal</td>
		      <td width="2%">:</td>
		      <td id="dtgl"></td>
		    </tr>
		    <tr class="table-success">
		      <td width="125">Judul</th>
		      <td width="2%">:</td>
		      <td id="djudul"></td>
		    </tr>
		    <tr class="table-info">
		      <td width="125">Keterangan</th>
		      <td width="2%">: </td>
		      <td id="disi"></td>
		    </tr>
		    <tr class="table-success">
		      <td width="125">Foto</th>
		      <td width="2%">:</td>
		      <td><img id="foto" src="#" alt="Foto" width="150" height="150"></td>
		    </tr>
		    <tr class="table-info">
		      <td width="125">Status</th>
		      <td width="2%">:</td>
		      <td><span id="dstatus" class="badge badge-success"></span></td>
		    </tr>
		  </tbody>
		</table>
      </div>
    </div>
  </div>
</div>
<!-- End Modal Detail -->

<!-- Modal Selesai -->
<div class="modal fade" tabindex="-1" role="dialog" aria-hidden="true" id="modalSelesai">
  <div class="modal-dialog modal-dialog-centered" role="document">
    <div class="modal-content">
      <div class="modal-header bg-dark text-white">
        <h5 class="modal-title">Data Pengaduan Terselesaikan</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close" style="color: white;">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
		<table class="table table-striped table-bordered table-hover">
		  <tbody>
		    <tr class="table-success">
		      <td width="140">Judul</th>
		      <td width="2%">:</td>
		      <td id="sjudul"></td>
		    </tr>
		    <tr class="table-info">
		      <td width="140">Tanggal Laporan</td>
		      <td width="2%">:</td>
		      <td id="stgl"></td>
		    </tr>
		    <tr class="table-info">
		      <td width="140">Tanggapan</th>
		      <td width="2%">: </td>
		      <td id="stanggapan"></td>
		    </tr>
		    <tr class="table-success">
		      <td width="140">Nama Petugas</th>
		      <td width="2%">:</td>
		      <td id="spetugas"></td>
		    </tr>
		    <tr class="table-info">
		      <td width="140">Tanggal Selesai</th>
		      <td width="2%">:</td>
		      <td id="stgl_selesai"></td>
		    </tr>
		    <tr class="table-info">
		      <td width="140">Status</th>
		      <td width="2%">:</td>
		      <td><span id="sstatus" class="badge badge-success"></td>
		    </tr>
		  </tbody>
		</table>
      </div>
    </div>
  </div>
</div>
<!-- End Modal Selesai -->
@endsection