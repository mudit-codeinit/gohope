@extends("admin.admin_app")

@section("content")
<div class="page-breadcrumb">
	<div class="row align-items-center">
		<div class="col-5">
			<h4 class="page-title">{{ isset($id) ? 'Edit User ' : 'Add  User' }}</h4>
			<div class="d-flex align-items-center">
				<nav aria-label="breadcrumb">
					<ol class="breadcrumb">
						<li class="breadcrumb-item"><a href="">User</a></li>
						<li class="breadcrumb-item active" aria-current="page">{{ isset($id) ? 'Edit User ' : 'Add User' }}</li>
					</ol>
				</nav>
			</div>
		</div>
		<div class="col-7">
			<div class="text-right upgrade-btn">
				<a href="{{URL::to('admin/users')}}" class="btn btn-primary text-white">View All Users</a>
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
        <div class="col-12">
  
			<!-- Page Content -->
			<div class="card">
				<div class="card-body"> 
					@if (count($errors) > 0)					
					<div class="alert alert-danger">
						<button type="button" class="close" data-dismiss="alert" aria-label="Close"> <span aria-hidden="true">×</span> </button>
						<h4 class="text-danger"><i class="fa fa-exclamation-triangle"></i> Error!</h4>
						<ul class="mb-0 px-0 list-style-none">
							@foreach ($errors->all() as $error)
								<li><i class="fa fa-chevron-right"></i> {{ $error }}</li>
							@endforeach
						</ul>
					</div>
					@endif
					@if(Session::has('flash_message'))
						<div class="alert alert-success">
							<button type="button" class="close" data-dismiss="alert" aria-label="Close"> <span aria-hidden="true">×</span> </button>
							<h4 class="text-success mb-0"><i class="fa fa-check-circle"></i> {{ Session::get('flash_message') }} </h4>
						</div>
					@endif
				{!! Form::open(array('url' => array('admin/users/adduser'),'class'=>'','name'=>'Request_form','id'=>'Request_form','role'=>'form','enctype' => 'multipart/form-data')) !!} 
					<input type="hidden" name="id" value="{{isset($id) ? $id : ''}}">
									
					<div class="form-group row">
						<label for="" class="col-sm-3 control-label">Name</label>
						<div class="col-lg-4 col-md-6 col-sm-9">
							<input type="text" name="full_name" value="{{isset($user->first_name) ? $user->first_name : ''}} {{isset($user->last_name) ? $user->last_name : ''}}" class="form-control">
						</div>
					</div>				
					<div class="form-group row">
						<label for="" class="col-sm-3 control-label">Email</label>
						<div class="col-lg-4 col-md-6 col-sm-9">
							<input type="email" name="email" value="{{isset($user->email) ? $user->email : ''}}" class="form-control">
						</div>
					</div>			
					<div class="form-group row">
						<label for="" class="col-sm-3 control-label">Mobile</label>
						<div class="col-lg-4 col-md-6 col-sm-9">
							<input type="text" name="mobile" value="{{isset($user->mobile) ? $user->mobile : ''}}" class="form-control">
						</div>
					</div>	
					
					<div class="form-group row"> 
						<label for="" class="col-sm-3 control-label">Password</label>
						<div class="col-lg-4 col-md-6 col-sm-9">
							<input type="text" name="password" value="{{isset($user->show_pass) ? $user->show_pass : ''}}" class="form-control">
						</div>
					</div>
					<div class="form-group row">
						<label for="" class="col-sm-3 control-label">Role</label>
						<div class="col-lg-4 col-md-6 col-sm-9">
						<select name="role" class="form-control">
						@foreach($roles as $role)
						<?php if($role->id != 1){?>
							<option value="{{$role->id}}" <?php if(isset($user)){if($role->id == $user->userrole){ echo "selected";}}?> >{{ucfirst($role->name)}}</option>
						<?php } ?>
						@endforeach
						</select>
						</div>
					</div>
							
					
									
					<div class="form-group row">
							<div class="col-md-offset-3 col-sm-9 ">
							<input type="hidden" name="all_imgs" value="" class="all_imgs"> 
							<div class="imgss" style="display:none"></div>
							@if(isset($id))
								<button type="button" class="btn sbmt_btn btn-primary">Update User</button>
							@else
								<button type="button" class="btn sbmt_btn btn-primary">Add User</button>
							@endif
							</div>
					</div>
					
					{!! Form::close() !!} 
				</div>
			</div>
		</div>
	</div>
</div>
                <!-- END Page Content -->      

<script>
function _(el) {
  return document.getElementById(el);
}

function uploadFile() {
  var file = _("file1").files;
//console.log(file);
  // alert(file.name+" | "+file.size+" | "+file.type);
  var formdata = new FormData();
  jQuery.each(jQuery('#file1')[0].files, function(i, file) {
    formdata.append('file-'+i, file);
	console.log(file);

   });
  var ajax = new XMLHttpRequest();
  ajax.upload.addEventListener("progress", progressHandler, false);
  ajax.addEventListener("load", completeHandler, false);
  ajax.addEventListener("error", errorHandler, false);
  ajax.addEventListener("abort", abortHandler, false);
 ajax.open("POST", "http://3.6.109.8/doctel/file_upload_parser.php"); // http://www.developphp.com/video/JavaScript/File-Upload-Progress-Bar-Meter-Tutorial-Ajax-PHP
  //use file_upload_parser.php from above url
  
  ajax.send(formdata);
}

function progressHandler(event) {
  _("loaded_n_total").innerHTML = "Uploaded " + event.loaded + " bytes of " + event.total;
  var percent = (event.loaded / event.total) * 100;
  _("progressBar").value = Math.round(percent);
  _("status").innerHTML = Math.round(percent) + "% uploaded... please wait";
}

function completeHandler(event) {
  _("status").innerHTML = event.target.responseText+ ' Uploaded successfully <br/>';
	var names = event.target.responseText;
	var nameArr = names.split(',');
	nameArr.forEach(function(value){
		if(value){
		var image_list = _("image-list").innerHTML;
		var new_img = '<div class="p_imgs"><div class="remove_img">X</div><img src="{{URL::asset('public/site_assets/images/')}}/'+value+'" height="150px" width="150px" class="port_imgs" data-image = "'+value+'"></div>';
		_("image-list").innerHTML = image_list+new_img;
		}
	});
	
  _("progressBar").value = 0; //wil clear progress bar after successful upload
}

function errorHandler(event) {
  _("status").innerHTML = "Upload Failed";
}

function abortHandler(event) {
  _("status").innerHTML = "Upload Aborted";
}
$(document).ready(function(){
	$('.remove_img').click(function(){
		$(this).parents('.p_imgs').remove();
	});
	var dropIndex;
		$("#image-list").sortable({
				update: function(event, ui) { 
					dropIndex = ui.item.index();
			}
		});

		$('#submit').click(function (e) {
			var imageIdsArray = [];
			$('#image-list div img').each(function (index) {
				if(index <= dropIndex) {
					var id = $(this).attr('id');
					var split_id = id.split("_");
					imageIdsArray.push(split_id[1]);
				}
			});

			$.ajax({
				url: 'reorderUpdate.php',
				type: 'post',
				data: {imageIds: imageIdsArray},
				success: function (response) {
				   $("#txtresponse").css('display', 'inline-block'); 
				   $("#txtresponse").text(response);
				}
			});
			e.preventDefault();
		});
		$('.sbmt_btn').click(function(){
			var all_imgs = '';
			$('.port_imgs').each(function(i){
				all_imgs = $(this).attr('data-image')+',';
				$('.imgss').append(all_imgs);
			});
			$('.all_imgs').val($('.imgss').html());
			$( "#Request_form" ).submit();
			
		});
	
});


        
</script>				
@endsection