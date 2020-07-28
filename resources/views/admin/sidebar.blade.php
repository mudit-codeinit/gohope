<!-- ============================================================== -->
<!-- Left Sidebar - style you can find in sidebar.scss  -->
<!-- ============================================================== -->

<aside class="left-sidebar" data-sidebarbg="skin6">
	<!-- Sidebar scroll-->
	<div class="scroll-sidebar">
		<!-- Sidebar navigation-->
		<nav class="sidebar-nav">
			<ul id="sidebarnav">
				<!-- User Profile-->
				<li>
					<!-- User Profile-->
					<div class="user-profile  no-block dropdown m-t-20">
						<div class="user-pic">
							@if(Auth::user()->fileUpload1)
								<img src="{{URL::to(Auth::user()->fileUpload1)}}" class="rounded-circle" width="40" alt="Avatar">
							@else								
								<img src="{{ URL::asset('public/admin_assets/img/logo.png') }}" alt="Avatar" class=""  width=""/>
							@endif
						</div>
						<div class="user-content hide-menu m-l-10">
							<a href="javascript:void(0)" class="" id="Userdd" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
								<h5 class="m-b-0 user-name font-medium">{{ Auth::user()->first_name }} <i class="fa fa-angle-down"></i></h5>
								<span class="op-5 user-email">{{ Auth::user()->email }}</span>
							</a>
							<div class="dropdown-menu dropdown-menu-right" aria-labelledby="Userdd">
								<!--a class="dropdown-item" href="{{ URL::to('admin/profile') }}"><i class="ti-user m-r-5 m-l-5"></i> My Profile</a>
								<a class="dropdown-item" href="{{ URL::to('admin/settings') }}"><i class="ti-settings m-r-5 m-l-5"></i> Settings</a-->
								<a class="dropdown-item" href="{{ URL::to('admin/logout') }}"><i class="fas fa-sign-out-alt m-r-5 m-l-5"></i> Logout</a>
							</div>
						</div>
					</div>
					<!-- End User Profile-->
				</li>
				
<!--				<li class="p-15 m-t-10">
					<a href="{{ URL::to('admin/subadmins') }}" class="btn btn-block create-btn text-white no-block d-flex align-items-center">
						<i class="fa fa-plus-square"></i> 
						<span class="hide-menu m-l-5">Create New Subadmin</span> 
					</a>
				</li>-->
				
				
				<!-- User Profile-->
				<li class="sidebar-item"> 
					<a class="sidebar-link waves-effect waves-dark sidebar-link {{classActivePath('dashboard')}}" href="{{ URL::to('admin/dashboard') }}" aria-expanded="false">
						<i class="mdi mdi-view-dashboard"></i>
						<span class="hide-menu">Dashboard</span>
					</a>
				</li>
                <li class="sidebar-item">
                                <a class="sidebar-link has-arrow waves-effect waves-dark {{classActivePath('addnewrequest')}}" href="javascript:void(0);">
                                        <i class="mdi mdi-briefcase-upload"></i>	
                                        <span class="hide-menu">Requests</span>
                                </a>
                                    <ul aria-expanded="false" class="collapse  second-level">
                                    <li class="sidebar-item">
                                            <a class="sidebar-link" href="{{ URL::to('admin/requests') }}" >
                                                    <i class="mdi mdi-adjust"></i>
                                                    <span class="hide-menu">All Requests</span>
                                            </a>							
                                    </li>
                                    <li class="sidebar-item">
                                            <a class="sidebar-link" href="{{ URL::to('admin/requests/addnewrequest') }}" >
                                                    <i class="mdi mdi-adjust"></i>
                                                    <span class="hide-menu">Add Request</span>
                                            </a>							
                                    </li>

                                    </ul>
				</li>    
				<li class="sidebar-item">
                                <a class="sidebar-link has-arrow waves-effect waves-dark {{classActivePath('addnewuser')}}" href="javascript:void(0);">
                                        <i class="fa fa-user"></i>	
                                        <span class="hide-menu">Users</span>
                                </a>
                                    <ul aria-expanded="false" class="collapse  second-level">
                                    <li class="sidebar-item">
                                            <a class="sidebar-link" href="{{ URL::to('admin/users') }}" >
                                                    <i class="mdi mdi-adjust"></i>
                                                    <span class="hide-menu">All Users</span>
                                            </a>							
                                    </li>
                                    <li class="sidebar-item">
                                            <a class="sidebar-link" href="{{ URL::to('admin/users/addnewuser') }}" >
                                                    <i class="mdi mdi-adjust"></i>
                                                    <span class="hide-menu">Add User</span>
                                            </a>							
                                    </li>

                                    </ul>
				</li>
			
				
				<li class="text-center p-40 upgrade-btn">
					<a href="{{ URL::to('admin/logout') }}" class="btn btn-block btn-danger text-white">Logout</a>
				</li>
			</ul>
			
		</nav>
		<!-- End Sidebar navigation -->
	</div>
	<!-- End Sidebar scroll-->
</aside>
<!-- ============================================================== -->
<!-- End Left Sidebar - style you can find in sidebar.scss  -->
<!-- ============================================================== -->