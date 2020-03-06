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
		.tulisan {
			font-family: 'Barlow';
		}
		.atas {
			background: rgb(91,113,135);
background: radial-gradient(circle, rgba(91,113,135,1) 0%, rgba(69,51,98,1) 100%);	
		}
	</style>

	<title>PENGADUAN MASYARAKAT @yield('title')</title>
</head>



<body class="atas">

	<nav class="navbar navbar-expand-lg navbar-dark bg-dark tulisan py-3">
		<a href="" class="navbar-brand">PENGADUAN MASYARAKAT</a>
		<button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbar">
			<span class="navbar-toggler-icon"></span>
		</button>
		<div class="container">
			<div class="collapse navbar-collapse" id="navbar">
				<ul class="navbar-nav ml-auto">
					<li class="navbar-item">
						<a href="{{ url('/') }}" class="nav-link tulisan-med">BERANDA &nbsp;<i class="fa fa-dashboard"></i></a>
					</li>
					<li class="navbar-item">
						<a href="{{ url('/pengaduan') }}" class="nav-link">PENGADUAN &nbsp;<i class="fa fa-user"></i></a>
					</li>
					<li class="navbar-item">
						<a href="{{ url('login') }}" class="nav-link">LOGIN &nbsp;<i class="fa fa-sign-in"></i></a>
					</li>
				</ul>
			</div>
		</div>
		
	</nav>

	@yield('content')

	<footer class="p-4 bg-dark text-light mt-n4 bg-light d-block">
		Ujikom 2020 &copy; Mohammad Rival Wijokumoro	
	</footer>

	<script type="text/javascript" src="{{ asset('js/jquery.js') }}"></script>
    <script type="text/javascript" src="{{ asset('js/popper.min.js') }}"></script>
    <script type="text/javascript" src="{{ asset('js/bootstrap.min.js') }}"></script>

    <!-- Notifikasi -->
@if ($pesan = Session::get('sukses'))
<script type="text/javascript">
	function sukses() {
		Swal.fire({
			icon: 'success',
			title: 'Sukses!',
			text: '{{ $pesan }}',
			timer: 1300, 
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
</body>
</html>