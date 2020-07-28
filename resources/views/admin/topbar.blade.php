<!-- ============================================================== -->
<!-- Topbar header - style you can find in pages.scss -->
<!-- ============================================================== -->
<header class="topbar" data-navbarbg="skin5">
	<nav class="navbar top-navbar navbar-expand-md navbar-dark">
		<div class="navbar-header" data-logobg="skin5">
			<!-- ============================================================== -->
			<!-- Logo -->
			<!-- ============================================================== -->
			<a class="navbar-brand" href="index.html">
				<!-- Logo text -->
				<span class="logo-text">
					 Gohope
				</span>
			</a>
			<!-- ============================================================== -->
			<!-- End Logo -->
			<!-- ============================================================== -->
			<!-- This is for the sidebar toggle which is visible on mobile only -->
			<a class="nav-toggler waves-effect waves-light d-block d-md-none" href="javascript:void(0)"><i class="ti-menu ti-close"></i></a>
		</div>
		<!-- ============================================================== -->
		<!-- End Logo -->
		<!-- ============================================================== -->
		<div class="navbar-collapse collapse" id="navbarSupportedContent" data-navbarbg="skin5">
			<!-- ============================================================== -->
			<!-- toggle and nav items -->
			<!-- ============================================================== -->
			
			<!-- ============================================================== -->
			<!-- Right side toggle and nav items -->
			<!-- ============================================================== -->
			<ul class="navbar-nav float-right ml-auto">
				<!-- ============================================================== -->
				<!-- User profile and search -->
				<!-- ============================================================== -->
				<li class="nav-item dropdown">
					<a class="nav-link dropdown-toggle text-muted waves-effect waves-dark pro-pic" href="javascript:;" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
						@if(Auth::user()->fileUpload1)                                 
						<img src="{{URL::to(Auth::user()->fileUpload1)}}" class="rounded-circle" width="31" alt="Avatar">						
						@else							
						<img src="{{ URL::asset('public/admin_assets/img/logo.png') }}" alt="Avatar" class="rounded-circle"  width="60"/>						
						@endif						
					</a>
					<div class="dropdown-menu dropdown-menu-right user-dd animated">
						<!--a class="dropdown-item" href="{{ URL::to('admin/profile') }}"><i class="ti-user m-r-5 m-l-5"></i> My Profile</a>
						<a class="dropdown-item" href="{{ URL::to('admin/settings') }}"><i class="ti-settings m-r-5 m-l-5"></i> Settings</a-->
						<a class="dropdown-item" href="{{ URL::to('admin/logout') }}"><i class="fas fa-sign-out-alt m-r-5 m-l-5"></i> Logout</a>
					</div>
				</li>
				<!-- ============================================================== -->
				<!-- User profile and search -->
				<!-- ============================================================== -->
			</ul>
		</div>
	</nav>
</header>
<!-- ============================================================== -->
<!-- End Topbar header -->
<!-- ============================================================== -->