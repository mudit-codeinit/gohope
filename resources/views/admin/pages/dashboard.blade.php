@extends("admin.admin_app")
@section("content")
<!-- ============================================================== -->
<!-- Bread crumb and right sidebar toggle -->
<!-- ============================================================== -->

<div class="page-breadcrumb">
	<div class="row align-items-center">
		<div class="col-5">
			<h4 class="page-title">Dashboard</h4>
			<div class="d-flex align-items-center">
				<nav aria-label="breadcrumb">
					<ol class="breadcrumb">
						<li class="breadcrumb-item"><a href="#">Home</a></li>
						<li class="breadcrumb-item active" aria-current="page">Library</li>
					</ol>
				</nav>
			</div>
		</div>
		<div class="col-7">
			<div class="text-right upgrade-button">
				<!--a href="{{ URL::to('/') }}" class="btn btn-primary text-white">View Frontend</a-->
			</div>
		</div>
	</div>
</div>
<!-- ============================================================== -->
<!-- End Bread crumb and right sidebar toggle -->
<!-- ============================================================== -->
<!-- ============================================================== -->
<!-- Container fluid  -->
<!-- ============================================================== -->
<div class="container-fluid">
	<!-- ============================================================== -->
	<!-- Sales chart -->
	<!-- ============================================================== -->
	
	<div class="row">
		<div class="col-lg-3 col-md-6 col-12">
			<div class="card bg-primary text-white">
				<div class="card-body">
					<div class="d-flex no-block align-items-center">
						<a href="JavaScript: void(0);"><i class="display-6 mdi mdi-account-multiple-outline text-white"></i></a>
						<div class="ml-3 mt-2">
							<h4 class="font-medium mb-0">Users</h4>
							<h5>{{$users}}</h5>
						</div>
					</div>
				</div>
			</div>
		</div>
		
	</div>
	
	<!-- ============================================================== -->
	<!-- Sales chart -->
	<!-- ============================================================== -->
	<!-- ============================================================== -->
	<!-- Table -->
	<!-- ============================================================== -->
	<!-- ============================================================== -->
	<!-- Table -->
	<!-- ============================================================== -->
	
</div>
<!-- ============================================================== -->
<!-- End Container fluid  -->
<!-- ============================================================== -->

@endsection