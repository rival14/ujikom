<!-- 
1. Admin -> session status admin
2. Petugas -> session status petugas
3. User -> sessin NIK
-->

<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

	<link rel="stylesheet" href="{{ asset('css/bootstrap.min.css') }}" integrity="sha384-Vkoo8x4CGsO3+Hhxv8T/Q5PaXtkKtu6ug5TOeNV6gBiFeWPGFN9MuhOf23Q9Ifjh" crossorigin="anonymous">
	<link href="https://fonts.googleapis.com/css?family=Barlow:400,500,600,700&display=swap" rel="stylesheet">  
	<link rel="stylesheet" type="text/css" href="{{ asset('fontawesome/fontawesome/css/font-awesome.css') }}">

	<script type="text/javascript" src="{{ asset('js/sweetalert.js') }}"></script>

	<style type="text/css">
		body {
			font-family: 'Barlow';
		}
	</style>

	<title>PENGADUAN MASYARAKAT @yield('title')</title>
</head>
<body>

	<nav class="navbar navbar-expand-lg navbar-dark bg-dark tulisan py-3">
		<a href="" class="navbar-brand">PELAPORAN MASYARAKAT</a>
		<button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbar">
			<span class="navbar-toggler-icon"></span>
		</button>
		<div class="container mr-5">
			<div class="collapse navbar-collapse" id="navbar">
				@if (Session::get('status') == 'admin')
				<ul class="navbar-nav ml-auto">
					<li class="navbar-item">
						<a href="{{ url('/admin') }}" class="nav-link tulisan">Beranda</a>
					</li>
					<li class="nav-item dropdown">
				        <a class="nav-link dropdown-toggle" href="#" id="navbarDropdownMenuLink" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
				          Data Pengguna
				        </a>
				        <div class="dropdown-menu" aria-labelledby="navbarDropdownMenuLink">
				          <a class="dropdown-item" href="{{ url('admin/petugas') }}">Petugas</a>
				          <a class="dropdown-item" href="{{ url('admin/pengguna') }}">Pengguna</a>
				        </div>
			      	</li>
					<li class="navbar-item">
						<a href="{{ url('admin/pengaduan') }}" class="nav-link">Pengaduan</a>
					</li>
					<li class="navbar-item">
						<a href="{{ url('admin/laporan') }}" class="nav-link">Laporan</a>
					</li>
					<li class="nav-item dropdown">
				      	<a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
				        	Pengaturan
				        	<img src="{{ asset('storage/petugas/profile') }}/{{ Session::get('foto') }}" width="30" height="30" class="rounded-circle ml-2 border border-primary" alt=" ">
				      	</a>
				      	<div class="dropdown-menu" aria-labelledby="navbarDropdown">
				        	<a class="dropdown-item" href="{{ url('/admin/profile') }}">Profile</a>
				        	<a class="dropdown-item" href="{{ url('/admin/password') }}">Ganti Password</a>
				        	<div class="dropdown-divider"></div>
				        	<a class="dropdown-item" href="{{ url('logout') }}">Keluar</a>
				      	</div>
				    </li>
				</ul>
				@elseif (Session::get('status') == 'petugas')
				<ul class="navbar-nav ml-auto">
					<li class="navbar-item">
						<a href="{{ url('/admin') }}" class="nav-link tulisan">Beranda</a>
					</li>
					<li class="nav-item dropdown">
				          <a class="nav-link" href="{{ url('admin/pengguna') }}">Pengguna</a>
			      	</li>
					<li class="navbar-item">
						<a href="{{ url('admin/pengaduan') }}" class="nav-link">Pengaduan</a>
					</li>
					<li class="nav-item dropdown">
				      	<a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
				        	Pengaturan
				        	<img src="{{ asset('storage/petugas/profile') }}/{{ Session::get('foto') }}" width="30" height="30" class="rounded-circle ml-2 border border-primary" alt=" ">
				      	</a>
				      	<div class="dropdown-menu" aria-labelledby="navbarDropdown">
				        	<a class="dropdown-item" href="{{ url('/admin/profile') }}">Profile</a>
				        	<a class="dropdown-item" href="{{ url('/admin/password') }}">Ganti Password</a>
				        	<div class="dropdown-divider"></div>
				        	<a class="dropdown-item" href="{{ url('logout') }}">Keluar</a>
				      	</div>
				    </li>
				</ul>
				@elseif (Session::get('nik'))
				<ul class="navbar-nav ml-auto">
					<li class="navbar-item">
						<a href="{{ url('/dashboard') }}" class="nav-link tulisan">Beranda</a>
					</li>
					<li class="navbar-item">
						<a href="{{ url('/dashboard/pengaduan') }}" class="nav-link">Pengaduan</a>
					</li>
					<li class="nav-item dropdown">
				      	<a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
				        	Pengaturan
				        	<img src="{{ asset('storage/masyarakat/profile') }}/{{ Session::get('foto') }}" width="30" height="30" class="rounded-circle ml-2 border border-primary" alt=" ">
				      	</a>
				      	<div class="dropdown-menu" aria-labelledby="navbarDropdown">
				        	<a class="dropdown-item" href="{{ url('/dashboard/profile') }}">Profile</a>
				        	<a class="dropdown-item" href="{{ url('/dashboard/password') }}">Ganti Password</a>
				        	<div class="dropdown-divider"></div>
				        	<a class="dropdown-item" href="{{ url('logout') }}">Keluar</a>
				      	</div>
				    </li>
				</ul>
				@endif
			</div>
		</div>
		
	</nav>

	@yield('content')

	<script type="text/javascript" src="{{ asset('js/jquery.js') }}"></script>
    <script type="text/javascript" src="{{ asset('js/popper.min.js') }}"></script>
    <script type="text/javascript" src="{{ asset('js/bootstrap.min.js') }}"></script>

    <script type="text/javascript">
    	$(function () {
  $('[data-toggle="tooltip"]').tooltip();
});
    </script>
</body>
</html>