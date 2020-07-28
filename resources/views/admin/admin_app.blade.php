<!DOCTYPE html>
<!--[if IE 9]>         <html class="ie9 no-focus"> <![endif]-->
<!--[if gt IE 9]><!--><html dir="ltr" lang="en"> <!--<![endif]-->
    <head>
        <meta charset="utf-8">
		<meta http-equiv="X-UA-Compatible" content="IE=edge">
		<!-- Tell the browser to be responsive to screen width -->
		<meta name="viewport" content="width=device-width, initial-scale=1">
		<meta name="description" content="">
		<meta name="author" content="">
		<!-- Favicon icon -->
        <title>Gohope Admin</title> 
		
        <!-- Stylesheets -->
        <link rel="icon" href="{{URL::asset('public/site_assets/images')}}/"  >
        <!-- Page JS Plugins CSS -->
        <link rel="stylesheet" href="{{ URL::asset('public/admin_assets/js/plugins/datatables/jquery.dataTables.min.css') }}"> 
        <link rel="stylesheet" href="{{ URL::asset('public/admin_assets/js/plugins/bootstrap-datepicker/bootstrap-datepicker.min.css') }}">
        <link rel="stylesheet" href="{{ URL::asset('public/admin_assets/js/plugins/sweet-alert/sweetalert2.min.css') }}"> 
		<link href="https://cdnjs.cloudflare.com/ajax/libs/jqueryui/1.12.1/jquery-ui.min.css" rel="stylesheet">
		<link href="{{ URL::asset('public/admin_assets/js/plugins/chartist/chartist.min.css') }}" rel="stylesheet">
		<link rel="stylesheet" href="{{ URL::asset('public/admin_assets/js/plugins/summernote/summernote-bs4.css') }}">  
		<!-- Custom CSS -->
		<link href="{{ URL::asset('public/admin_assets/css/style.min.css') }}" rel="stylesheet">
		
		<!-- Core Jquery -->
		<script src="{{ URL::asset('public/admin_assets/js/jquery.min.js') }}"></script>
				<script src="{{ URL::asset('/vendor/unisharp/laravel-ckeditor/ckeditor.js')}}"></script>

		<script src="{{ URL::asset('public/admin_assets/js/custom_admin.js') }}"></script>
		
		<!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
		<!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
		<!--[if lt IE 9]>
		<script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
		<script src="https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>
		<![endif]-->
		
    </head>
    <body>
		<!-- ============================================================== -->
		<!-- Preloader - style you can find in spinners.css -->
		<!-- ============================================================== -->
		<div class="preloader">
			<div class="lds-ripple">
				<div class="lds-pos"></div>
				<div class="lds-pos"></div>
			</div>
		</div>
		<!-- ============================================================== -->
		<!-- Main wrapper - style you can find in pages.scss -->
		<!-- ============================================================== -->
		<div id="main-wrapper" data-layout="vertical" data-navbarbg="skin5" data-sidebartype="full" data-sidebar-position="absolute" data-header-position="absolute" data-boxed-layout="full">
            <!-- Header -->
			@include("admin.topbar")
            <!-- END Header -->

            <!-- Sidebar -->
            @include("admin.sidebar")
            <!-- END Sidebar -->

            
            <!-- ============================================================== -->
			<!-- Page wrapper  -->
			<!-- ============================================================== -->
			<div class="page-wrapper">
               
               @yield("content")
				
				<!-- ============================================================== -->
				<!-- footer -->
				<!-- ============================================================== -->
                    <footer class="footer text-center">
            <a class="font-w600" href="{{ URL::asset('/') }}" target="_blank">Gohope</a> &copy; <span class="js-year-copy"></span>. All rights are reserved
                    </footer>
				<!-- ============================================================== -->
				<!-- End footer -->
				<!-- ============================================================== -->
            </div>
            <!-- END Main Container -->
        </div>
        <!-- END Page Container -->

        <!-- Apps Modal -->
        <!-- Opens from the button in the header -->
        <div class="modal fade" id="apps-modal" tabindex="-1" role="dialog" aria-hidden="true">
            <div class="modal-sm modal-dialog modal-dialog-top">
                <div class="modal-content">
                    <!-- Apps Block -->
                    <div class="block block-themed block-transparent">
                        <div class="block-header bg-primary-dark">
                            <ul class="block-options">
                                <li>
                                    <button data-dismiss="modal" type="button"><i class="si si-close"></i></button>
                                </li>
                            </ul>
                            <h3 class="block-title">Apps</h3>
                        </div>
                        <div class="block-content">
                            <div class="row text-center">
                                <div class="col-xs-6">
                                    <a class="block block-rounded" href="{{ URL::to('admin/dashboard') }}">
                                        <div class="block-content text-white bg-default">
                                            <i class="si si-speedometer fa-2x"></i>
                                            <div class="font-w600 push-15-t push-15">Backend</div>
                                        </div>
                                    </a>
                                </div>
                                <div class="col-xs-6">
                                    <a class="block block-rounded" href="{{ URL::to('/') }}" target="_blank">
                                        <div class="block-content text-white bg-modern">
                                            <i class="si si-rocket fa-2x"></i>
                                            <div class="font-w600 push-15-t push-15">Frontend</div>
                                        </div>
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- END Apps Block -->
                </div>
            </div>
        </div>
        <!-- END Apps Modal -->

        <!-- ============================================================== -->
		<!-- All Jquery -->
		<!-- ============================================================== -->
		
		<!-- Bootstrap tether Core JavaScript -->
		<script src="{{ URL::asset('public/admin_assets/js/plugins/popper.js/umd/popper.min.js') }}"></script>
		<script src="{{ URL::asset('public/admin_assets/js/plugins/bootstrap/js/bootstrap.min.js') }}"></script>
		
        	
        <!-- Jquery UI -->
        <script src="{{ URL::asset('public/admin_assets/js/plugins/bootstrap-datepicker/moment.js') }}"></script>
        <script src="{{ URL::asset('public/admin_assets/js/plugins/bootstrap-datepicker/bootstrap-datepicker.min.js') }}"></script>
		
		<!-- Tables -->
        <script src="{{ URL::asset('public/admin_assets/js/plugins/datatables/jquery.dataTables.min.js') }}"></script>
		
		<!-- Summernote texteditor -->
		<script src="{{ URL::asset('public/admin_assets/js/plugins/summernote/summernote-bs4.min.js') }}"></script>
		
		<!--Wave Effects -->
		<script src="{{ URL::asset('public/admin_assets/js/waves.js') }}"></script>
		<script src="{{ URL::asset('public/admin_assets/js/jquery.PrintArea.js') }}"></script>
		
		<!--Slim sidebar Scroll -->
		<script src="{{ URL::asset('public/admin_assets/js/plugins/perfect-scrollbar/perfect-scrollbar.jquery.min.js') }}"></script>
		
		<!--Menu sidebar -->
		<script src="{{ URL::asset('public/admin_assets/js/sidebarmenu.js') }}"></script>
		
		<!--Custom Alerts -->
		<script src="{{ URL::asset('public/admin_assets/js/plugins/sweet-alert/sweetalert2.all.min.js') }}"></script>
		
		<!--Custom JavaScript -->
		<script src="{{ URL::asset('public/admin_assets/js/custom.js') }}"></script>
		<script src="https://ajax.googleapis.com/ajax/libs/jqueryui/1.10.3/jquery-ui.min.js"></script>

    
    </body>
</html>