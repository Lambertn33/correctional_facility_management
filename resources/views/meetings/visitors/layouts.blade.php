<!DOCTYPE html>
<html lang="en" class="color-header headercolor2">


<!-- Mirrored from codervent.com/rukada/demo/horizontal/errors-coming-soon.html by HTTrack Website Copier/3.x [XR&CO'2014], Tue, 27 Sep 2022 13:55:23 GMT -->
<head>
	<!-- Required meta tags -->
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<!--favicon-->
	<link rel="icon" href="assets/images/favicon-32x32.png" type="image/png" />
	<!-- loader-->
	<link href="/assets/css/pace.min.css" rel="stylesheet" />
	<script src="/assets/js/pace.min.js"></script>
	<!-- Bootstrap CSS -->
	<link href="/assets/css/bootstrap.min.css" rel="stylesheet">
	<link href="/assets/css/bootstrap-extended.css" rel="stylesheet">
	<link href="https://fonts.googleapis.com/css2?family=Roboto:wght@400;500&amp;display=swap" rel="stylesheet">
	<link href="/assets/css/app.css" rel="stylesheet">
	<link href="/assets/css/icons.css" rel="stylesheet">
	<title>Prisons</title>
</head>

<style>
	.btn-text {
		font-size: 1rem;
	}
</style>

<body class="bg-forgot">
	<!-- wrapper -->
	<div class="wrapper">
		<nav class="navbar navbar-expand-lg navbar-light bg-white rounded fixed-top rounded-0 shadow-sm">
			<div class="container-fluid">
				<a class="navbar-brand" href="#">
					<img src="/assets/images/logo-e-huza.png" width="80" alt="">
				</a>
				<button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent1" aria-controls="navbarSupportedContent1" aria-expanded="false" aria-label="Toggle navigation"> <span class="navbar-toggler-icon"></span>
				</button>
				<div class="collapse navbar-collapse" id="navbarSupportedContent1">
					<ul class="navbar-nav ms-auto mb-2 mb-lg-0">
						<li class="nav-item dropdown">
							<select class="form-select" name="languageChange" id="languageChange" required>
								<option selected disabled value="">Select Language</option>
								<option value="en" {{ session()->get('locale') == 'en' ? 'selected' : '' }}>English</option>
								<option value="fr" {{ session()->get('locale') == 'fr' ? 'selected' : '' }}>Francais</option>
								<option value="rw" {{ session()->get('locale') == 'rw' ? 'selected' : '' }}>Kinyarwanda</option>
							</select>
							@csrf
						  </li>
						<li class="nav-item"> <a class="nav-link active" aria-current="page" href="{{route('getHomePage')}}"><i class='bx bx-home-alt me-1'></i>{{__('Home')}}</a>
						</li>
						<li class="nav-item"> <a class="nav-link active" aria-current="page" href="{{route('getAppointmentsPage')}}"><i class='bx bx-home-alt me-1'></i>{{__('Appointments')}}</a>
						</li>
						<li class="nav-item"> <a class="nav-link active" aria-current="page" href="{{route('getLoginPage')}}"><i class='bx bx-log-in me-1'></i>{{__('Login')}}</a>
						</li>
					</ul>
				</div>
			</div>
		</nav>
		<div class="error-404 d-flex align-items-center justify-content-center">
			<div class="container">
				<div class="card py-5">
					<div class="row g-0">
						<div class="col col-xl-6 offset-xl-3">
                            @yield('content')
						</div>
					</div>
				</div>
					<!--end row-->
			</div>
		</div>
		<div class="bg-white p-3 fixed-bottom border-top shadow">
			<div class="d-flex align-items-center justify-content-between flex-wrap">
				<p class="mb-0">Copyright © <script>document.write(new Date().getFullYear())</script>. All right reserved.</p>
			</div>
		</div>
	</div>
	<!-- end wrapper -->
	<!-- Bootstrap JS -->
	<script src="/assets/js/bootstrap.bundle.min.js"></script>
</body>


<!-- Mirrored from codervent.com/rukada/demo/horizontal/errors-coming-soon.html by HTTrack Website Copier/3.x [XR&CO'2014], Tue, 27 Sep 2022 13:55:23 GMT -->
</html>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
<script>
    $(document).ready(function() {
		$("#languageChange").change(function(){
			var url = "{{ route('changeLanguage') }}"; 
			var token = $("input[name=_token]").val();
			var lang = $(this).val();

			$.ajax({
				url,
				type: 'POST',
				data: {
					_token: token,
					lang: lang
				},
				success: function(res) {
					window.location.reload();
				}
			})
        });
    });
</script>