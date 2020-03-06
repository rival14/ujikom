@extends('layout.admin')
@section('title')
@section('content')

<!-- Hapus & Edit -->
<script type="text/javascript">
	function detail(id) {
		$.ajax({
			url: "{{ url('/admin/pengaduan/ajax/') }}/"+id,
			type: "GET",
			success: function (data) {
				$('#nik').val(data.nik);
				document.getElementById('dnama').innerHTML = data.nama;
				document.getElementById('dtgl').innerHTML = data.tgl_pengaduan;
				document.getElementById('djudul').innerHTML = data.judul;
				document.getElementById('disi').innerHTML = data.isi_laporan;
				document.getElementById('foto').src = "{{ asset('storage/gambar') }}/"+data.foto;
				document.getElementById('bukafoto').href = "{{ asset('storage/gambar') }}/"+data.foto;
				if (data.status === '0') {
					document.getElementById('dstatus').innerHTML = 'BELUM DIKONFIRMASI';
					document.getElementById('dstatus').classList.replace('badge-success', 'badge-warning')
				}else if(data.status === 'proses') {
					document.getElementById('dstatus').innerHTML = 'SEDANG DALAM PROSES';
					document.getElementById('dstatus').classList.replace('badge-success', 'badge-info');
					document.getElementById('konfirmasi').style.visibility = 'hidden';
				}else{
					document.getElementById('dstatus').innerHTML = 'SELESAI';
					document.getElementById('konfirmasi').style.visibility = 'hidden';
				}
				$('#modalDetail').modal('show');
			}
		});
	}

	function detail_pengaduan(id) {
		$.ajax({
			url: "{{ url('/admin/pengaduan/ajax/') }}/"+id,
			type: "GET",
			success: function (data) {
				$('#nik').val(data.nik);
				document.getElementById('dnama').innerHTML = data.nama;
				document.getElementById('dtgl').innerHTML = data.tgl_pengaduan;
				document.getElementById('djudul').innerHTML = data.judul;
				document.getElementById('disi').innerHTML = data.isi_laporan;
				document.getElementById('foto').src = "{{ asset('storage/gambar') }}/"+data.foto;
				document.getElementById('bukafoto').href = "{{ asset('storage/gambar') }}/"+data.foto;
				if (data.status === '0') {
					document.getElementById('dstatus').innerHTML = 'BELUM DIKONFIRMASI';
					document.getElementById('dstatus').classList.replace('badge-success', 'badge-warning');
					document.getElementById('konfirmasi').style.visibility = 'hidden';
				}else if(data.status === 'proses') {
					document.getElementById('dstatus').innerHTML = 'SEDANG DALAM PROSES';
					document.getElementById('dstatus').classList.replace('badge-success', 'badge-info');
					document.getElementById('konfirmasi').style.visibility = 'hidden';
				}else{
					document.getElementById('dstatus').innerHTML = 'SELESAI';
					document.getElementById('konfirmasi').style.visibility = 'hidden';
				}
				$('#modalDetail').modal('show');
			}
		});
	}

	function detail_proses(id) {
		$.ajax({
			url: "{{ url('/admin/pengaduan/ajax/') }}/"+id,
			type: "GET",
			success: function (data) {
				$('#pidpengaduan').val(data.id_pengaduan);
				document.getElementById('dpnama').innerHTML = data.nama;
				document.getElementById('dptgl').innerHTML = data.tgl_pengaduan;
				document.getElementById('dpjudul').innerHTML = data.judul;
				document.getElementById('dpisi').innerHTML = data.isi_laporan;
				document.getElementById('pfoto').src = "{{ asset('storage/gambar') }}/"+data.foto;
				document.getElementById('pbukafoto').href = "{{ asset('storage/gambar') }}/"+data.foto;
				if (data.status === '0') {
					document.getElementById('dpstatus').innerHTML = 'BELUM DIKONFIRMASI';
					document.getElementById('dpstatus').classList.replace('badge-success', 'badge-warning');
				}else if(data.status === 'proses') {
					document.getElementById('dpstatus').innerHTML = 'SEDANG DALAM PROSES';
					document.getElementById('dpstatus').classList.replace('badge-success', 'badge-info');
					document.getElementById('proses').style.visibility = 'hidden';
				}else{
					document.getElementById('dpstatus').innerHTML = 'SELESAI';
					document.getElementById('proses').style.visibility = 'hidden';
				}
				$('#modalDetailSelesai').modal('show');
			}
		});
	}

	function selesai(id) {
		$.ajax({
			url: "{{ url('/admin/pengaduan/ajax/') }}/"+id,
			type: "GET",
			success: function (data) {
				$('#id_pengaduan').val(data.id_pengaduan);
			}

		});

		$('#modalSelesai').modal('show');
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

@if (Session::get('status') == 'admin')
<div class="container mt-4">
	<div class="card">
	  <div class="card-header text-light" style="background-color: black;">
	    Data Pengaduan
	  </div>
	  <div class="card-body">
	  	<form class="form-inline float-right mb-2" action="{{ route('pengaduan.cari') }}" method="GET">
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
		      	<button class="btn btn-info col-md-12 text-center" onclick="detail({{ $pengaduan->id_pengaduan }});" data-toggle="tooltip" data-placement="top" title="Detail Pengaduan">Detail
		      		<i class="fa fa-search"></i>
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



@elseif (Session::get('status') == 'petugas')



	<div class="container mt-4">
		<div class="card">
		  <div class="card-header text-light" style="background-color: black;">
		    Data Pengaduan
		  </div>
		  <div class="card-body">
		  	<form class="form-inline float-right mb-2" action="{{ route('pengaduan.cari') }}" method="GET">
		      <input class="form-control mr-sm-2" type="search" placeholder="Cari Data Pengaduan" name="cari">
		      <button class="btn btn-outline-success my-2 my-sm-0" type="submit">Cari <i class="fa fa-search"></i></button>
		      <hr>
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
			  	@foreach($petugas as $pengaduan)
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
			      	@if ($pengaduan->status === '0')
			      	<button class="btn btn-info col-md-5 text-center" onclick="detail_proses({{ $pengaduan->id_pengaduan }});" data-toggle="tooltip" data-placement="top" title="Detail Pengaduan">Detail
			      		<i class="fa fa-search"></i>
			      	</button>
			      	@else
			      	<button class="btn btn-info col-md-5 text-center" onclick="detail_pengaduan({{ $pengaduan->id_pengaduan }});" data-toggle="tooltip" data-placement="top" title="Detail Pengaduan">Detail
			      		<i class="fa fa-search"></i>
			      	</button>
			      	<button class="btn btn-success col-md-5 text-center" onclick="selesai({{ $pengaduan->id_pengaduan }});" data-toggle="tooltip" data-placement="top" title="Selesaikan Pengaduan">Selesai
			      		<i class="fa fa-edit"></i>
			      	</button>
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
@endif

<!-- Modal Detail -->
<div class="modal fade" tabindex="-1" role="dialog" aria-hidden="true" id="modalDetail">
  <div class="modal-dialog modal-dialog-centered" role="document">
    <div class="modal-content">
      <div class="modal-header bg-dark text-white">
        <h5 class="modal-title">Data Pengaduan</h5>
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
		      <td><a href="" target="_blank" id="bukafoto"><img id="foto" src="#" alt="Foto" width="150" height="150"></a></td>
		    </tr>
		    <tr class="table-info">
		      <td width="125">Status</th>
		      <td width="2%">:</td>
		      <td><span id="dstatus" class="badge badge-success"></span></td>
		    </tr>
		  </tbody>
		</table>
      </div>
		<div class="modal-footer d-block">
	        <button type="button" class="btn btn-secondary float-left" data-dismiss="modal"><i class="fa fa-long-arrow-left"></i>&nbsp; Kembali</button>
	        <form method="POST" action="{{ route('pengaduan.konfirmasi') }}">
	        	@csrf
			    <input type="hidden" name="nik" id="nik">
	        <button type="submit" class="btn btn-success float-right" id="konfirmasi">Selesai &nbsp;<i class="fa fa-save"></i></button>
			</form>
	    </div>
    </div>
  </div>
</div>
<!-- End Modal Detail -->

<!-- Modal Detail Proses -->
<div class="modal fade" tabindex="-1" role="dialog" aria-hidden="true" id="modalDetailSelesai">
  <div class="modal-dialog modal-dialog-centered" role="document">
    <div class="modal-content">
      <div class="modal-header bg-dark text-white">
        <h5 class="modal-title">Data Pengaduan</h5>
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
		      <td id="dpnama"></td>
		    </tr>
		    <tr class="table-info">
		      <td width="125">Tanggal</td>
		      <td width="2%">:</td>
		      <td id="dptgl"></td>
		    </tr>
		    <tr class="table-success">
		      <td width="125">Judul</th>
		      <td width="2%">:</td>
		      <td id="dpjudul"></td>
		    </tr>
		    <tr class="table-info">
		      <td width="125">Keterangan</th>
		      <td width="2%">: </td>
		      <td id="dpisi"></td>
		    </tr>
		    <tr class="table-success">
		      <td width="125">Foto</th>
		      <td width="2%">:</td>
		      <td><a href="" target="_blank" id="pbukafoto"><img id="pfoto" src="#" alt="Foto" width="150" height="150"></a></td>
		    </tr>
		    <tr class="table-info">
		      <td width="125">Status</th>
		      <td width="2%">:</td>
		      <td><span id="dpstatus" class="badge badge-success"></span></td>
		    </tr>
		  </tbody>
		</table>
      </div>
		<div class="modal-footer d-block">
	        <button type="button" class="btn btn-secondary float-left" data-dismiss="modal"><i class="fa fa-long-arrow-left"></i>&nbsp; Kembali</button>
	        <form method="POST" action="{{ route('pengaduan.konfirmasi') }}">
	        	@csrf
			    <input type="hidden" name="id_pengaduan" id="pidpengaduan">
	        <button type="submit" class="btn btn-success float-right" id="proses">Proses &nbsp;<i class="fa fa-save"></i></button>
			</form>
	    </div>
    </div>
  </div>
</div>
<!-- End Modal Detail Proses -->

<!-- Modal Selesai -->
<div class="modal fade" tabindex="-1" role="dialog" aria-hidden="true" id="modalSelesai">
  <div class="modal-dialog modal-dialog-centered" role="document">
    <div class="modal-content">
      <div class="modal-header bg-dark text-white">
        <h5 class="modal-title"><i class="fa fa-plus"></i>&nbsp;Beri Tanggapan</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close" style="color: white;">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <form method="POST" action="{{ route('pengaduan.selesai') }}">
        	@csrf
		    <input type="hidden" class="form-control" name="id_pengaduan" id="id_pengaduan">
		  <div class="form-group">
		    <label>Tanggapan</label>
		    <textarea class="form-control" rows="3" name="tanggapan"></textarea>
		  </div>
        <button type="submit" class="btn btn-primary mb-2 float-right">Selesaikan</button>
		</form>
      </div>
    </div>
  </div>
</div>
<!-- End Modal Selesai -->
@endsection