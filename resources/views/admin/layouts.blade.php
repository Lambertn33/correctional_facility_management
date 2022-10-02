<!doctype html>
<html lang="en" class="color-header headercolor2">


<!-- Mirrored from codervent.com/rukada/demo/horizontal/dashboard-eCommerce.html by HTTrack Website Copier/3.x [XR&CO'2014], Tue, 27 Sep 2022 13:49:26 GMT -->
<head>
	<!-- Required meta tags -->
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<!--favicon-->
	<link rel="icon" href="assets/images/favicon-32x32.png" type="image/png" />
	<!--plugins-->
	<link href="/assets/plugins/simplebar/css/simplebar.css" rel="stylesheet" />
	<link href="/assets/plugins/perfect-scrollbar/css/perfect-scrollbar.css" rel="stylesheet" />
	
	<link href="/assets/plugins/datatable/css/dataTables.bootstrap5.min.css" rel="stylesheet" />
	<!-- loader-->
	<link href="/assets/css/pace.min.css" rel="stylesheet" />
	<script src="/assets/js/pace.min.js"></script>
	<!-- Bootstrap CSS -->
	<link href="/assets/css/bootstrap.min.css" rel="stylesheet">
	<link href="/assets/css/bootstrap-extended.css" rel="stylesheet">
	<link href="https://fonts.googleapis.com/css2?family=Roboto:wght@400;500&amp;display=swap" rel="stylesheet">
	<link href="/assets/css/app.css" rel="stylesheet">
	<link href="/assets/css/icons.css" rel="stylesheet">
	<!-- Theme Style CSS -->
	<link rel="stylesheet" href="/assets/css/dark-theme.css" />
	<link rel="stylesheet" href="/assets/css/semi-dark.css" />
	<link rel="stylesheet" href="/assets/css/header-colors.css" />
	<title>PRISONS MANAGEMENT</title>
</head>

<body>
	<!--wrapper-->
	<div class="wrapper">
		<!--start header wrapper-->	
	  <div class="header-wrapper">
		<!--start header -->
		<header>
			<div class="topbar d-flex align-items-center">
				<nav class="navbar navbar-expand">
					<div class="topbar-logo-header">
						<div class="">
							
						</div>
						<div class="">
							<h4 class="logo-text">{{$currentPrison->name}}</h4>
						</div>
					</div>
					<div class="mobile-toggle-menu"><i class='bx bx-menu'></i></div>
					<div class="top-menu ms-auto">
						<ul class="navbar-nav align-items-center">
							
						</ul>
					</div>
					<div class="user-box dropdown">
						<a class="d-flex align-items-center nav-link dropdown-toggle dropdown-toggle-nocaret" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
							<div class="user-info ps-3">
								<p class="user-name mb-0">{{$authenticatedUser->names}}</p>
							</div>
						</a>
						<ul class="dropdown-menu dropdown-menu-end">
							<li><a class="dropdown-item" href="javascript:;"><i class="bx bx-user"></i><span>Profile</span></a>
							</li>
							<li>
								<div class="dropdown-divider mb-0"></div>
							</li>
							<li><a class="dropdown-item" href="#" onclick="document.getElementById('logoutForm').submit();"><i class='bx bx-log-out-circle'></i><span>Logout</span></a>
                                <form action="{{route('logout')}}" method="POST" id="logoutForm" style="display: none">
                                    @csrf
                                </form>
							</li>
						</ul>
					</div>
				</nav>
			</div>
		</header>
		<!--end header -->
		<!--navigation-->
		<div class="nav-container primary-menu">
			<div class="mobile-topbar-header">
				<div>
					<img src="assets/images/logo-icon.png" class="logo-icon" alt="logo icon">
				</div>
				<div>
					<h4 class="logo-text">Rukada</h4>
				</div>
				<div class="toggle-icon ms-auto"><i class='bx bx-arrow-to-left'></i>
				</div>
			</div>
			<nav class="navbar navbar-expand-xl w-100">
				<ul class="navbar-nav justify-content-start flex-grow-1 gap-1">
                    <li class="nav-item">
						<a  class="nav-link" href="#">
							<div class="parent-icon"><i class='bx bx-home-circle'></i>
							</div>
							<div class="menu-title">Dashboard</div>
						</a>
					 </li>
                    <li class="nav-item dropdown">
                        <a href="javascript:;" class="nav-link dropdown-toggle dropdown-toggle-nocaret" data-bs-toggle="dropdown">
                            <div class="parent-icon"><i class='bx bx-user'></i>
                            </div>
                            <div class="menu-title">Inmates</div>
                        </a>
                        <ul class="dropdown-menu">
                            <li> <a class="dropdown-item" href="#"><i class="bx bx-right-arrow-alt"></i>Inmates List</a>
                            </li>
                            <li> <a class="dropdown-item" href="#"><i class="bx bx-right-arrow-alt"></i>Add New</a>
                            </li>
                        </ul>
                    </li>
                    <li class="nav-item dropdown">
                        <a href="javascript:;" class="nav-link dropdown-toggle dropdown-toggle-nocaret" data-bs-toggle="dropdown">
                            <div class="parent-icon"><i class='bx bx-folder'></i>
                            </div>
                            <div class="menu-title">Appointments</div>
                        </a>
                        <ul class="dropdown-menu">
                            <li> <a class="dropdown-item" href="#"><i class="bx bx-right-arrow-alt"></i>Approved Appointments</a>
                            </li>
                            <li> <a class="dropdown-item" href="#"><i class="bx bx-right-arrow-alt"></i>Pending Appointments</a>
                            </li>
                            <li> <a class="dropdown-item" href="#"><i class="bx bx-right-arrow-alt"></i>Rejected Appointments</a>
                            </li>
                        </ul>
                    </li>
                </ul>
			</nav>
		</div>
		<!--end navigation-->
	   </div>
	   <!--end header wrapper-->
		<!--start page wrapper -->
            @yield('content')
		<!--end page wrapper -->
		<!--start overlay-->
		<div class="overlay toggle-icon"></div>
		<!--end overlay-->
		<!--Start Back To Top Button--> <a href="javaScript:;" class="back-to-top"><i class='bx bxs-up-arrow-alt'></i></a>
		<!--End Back To Top Button-->
		<footer class="page-footer">
			<p class="mb-0">Copyright © <script>document.write(new Date().getFullYear())</script>. All right reserved.</p>
		</footer>
	</div>
	<!--end wrapper-->
	<!--start switcher-->
	<!--end switcher-->
	<!-- Bootstrap JS -->
	<script src="/assets/js/bootstrap.bundle.min.js"></script>
	<!--plugins-->
	<script src="/assets/js/jquery.min.js"></script>
	<script src="/assets/plugins/simplebar/js/simplebar.min.js"></script>
	
	<script src="/assets/plugins/perfect-scrollbar/js/perfect-scrollbar.js"></script>
	<script src="/assets/plugins/apexcharts-bundle/js/apexcharts.min.js"></script>
	<script src="/assets/plugins/chartjs/chart.min.js"></script>
	<script src="/assets/plugins/peity/jquery.peity.min.js"></script>
	<script src="/assets/plugins/datatable/js/jquery.dataTables.min.js"></script>
	<script src="/assets/plugins/datatable/js/dataTables.bootstrap5.min.js"></script>
	<script src="/assets/js/dashboard-eCommerce.js"></script>
	<!--app JS-->
	<script src="/assets/js/app.js"></script>
	<script>
		new PerfectScrollbar('.product-list');
		new PerfectScrollbar('.customers-list');
	</script>
</body>


<!-- Mirrored from codervent.com/rukada/demo/horizontal/dashboard-eCommerce.html by HTTrack Website Copier/3.x [XR&CO'2014], Tue, 27 Sep 2022 13:50:18 GMT -->
</html>