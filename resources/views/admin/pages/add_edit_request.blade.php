@extends("admin.admin_app")

@section("content")
<div class="page-breadcrumb">
	<div class="row align-items-center">
		<div class="col-5">
			<h4 class="page-title">{{ isset($id) ? 'Edit Request ' : 'Add  Request' }}</h4>
			<div class="d-flex align-items-center">
				<nav aria-label="breadcrumb">
					<ol class="breadcrumb">
						<li class="breadcrumb-item"><a href="">Request</a></li>
						<li class="breadcrumb-item active" aria-current="page">{{ isset($id) ? 'Edit Request ' : 'Add Request' }}</li>
					</ol>
				</nav>
			</div>
		</div>
		<div class="col-7">
			<div class="text-right upgrade-btn">
				<a href="{{URL::to('admin/requests')}}" class="btn btn-primary text-white">View All Requests</a>
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
				{!! Form::open(array('url' => array('admin/requests/addrequest'),'class'=>'','name'=>'Request_form','id'=>'Request_form','role'=>'form','enctype' => 'multipart/form-data')) !!} 
					<input type="hidden" name="id" value="{{isset($id) ? $id : ''}}">
									
					<div class="form-group row">
						<label for="" class="col-sm-3 control-label">Name</label>
						<div class="col-lg-4 col-md-6 col-sm-9">
							<input type="text" name="name" value="{{isset($request->name) ? $request->name : ''}}" class="form-control">
						</div>
					</div>
					
					<div class="form-group row">
						<label for="" class="col-sm-3 control-label">Description</label>
						<div class="col-lg-4 col-md-6 col-sm-9">
						<textarea name="description" value="{{isset($request->description) ? $request->description : ''}}" class="form-control">{{isset($request->description) ? $request->description : ''}}
						</textarea>
						</div>
					</div>     
					<div class="form-group row">
						<label for="" class="col-sm-3 control-label">No of Bags</label>
						<div class="col-lg-4 col-md-6 col-sm-9">
							<input type="number" name="bags" value="{{isset($request->bags) ? $request->bags : ''}}" class="form-control">
						</div>
					</div> 
					<div class="form-group row">
						<label for="" class="col-sm-3 control-label">No of Male</label>
						<div class="col-lg-4 col-md-6 col-sm-9">
							<input type="number" name="male" value="{{isset($request->male) ? $request->male : ''}}" class="form-control">
						</div>
					</div> 
					<div class="form-group row">
						<label for="" class="col-sm-3 control-label">No of Female</label>
						<div class="col-lg-4 col-md-6 col-sm-9">
							<input type="number" name="female" value="{{isset($request->female) ? $request->female : ''}}" class="form-control">
						</div>
					</div> 
					<div class="form-group row">
						<label for="" class="col-sm-3 control-label">No of Kids</label>
						<div class="col-lg-4 col-md-6 col-sm-9">
							<input type="number" name="kids" value="{{isset($request->kids) ? $request->kids : ''}}" class="form-control">
						</div>
					</div>
					<div class="form-group row">
						<label for="" class="col-sm-3 control-label">No of Pets</label>
						<div class="col-lg-4 col-md-6 col-sm-9">
							<input type="number" name="pets" value="{{isset($request->pets) ? $request->pets : ''}}" class="form-control">
						</div>
					</div> 
					<div class="form-group row">
						<label for="" class="col-sm-3 control-label">Street Address</label>
						<div class="col-lg-4 col-md-6 col-sm-9">
							<input type="text" name="street_address" value="{{isset($request->street_address) ? $request->street_address : ''}}" class="form-control">
						</div>
					</div> 
					<div class="form-group row">
						<label for="" class="col-sm-3 control-label">City</label>
						<div class="col-lg-4 col-md-6 col-sm-9">
							<input type="text" name="city" value="{{isset($request->city) ? $request->city : ''}}" class="form-control">
						</div>
					</div> 
					<div class="form-group row">
						<label for="" class="col-sm-3 control-label">Other Notes</label>
						<div class="col-lg-4 col-md-6 col-sm-9">
							<input type="text" name="other_notes" value="{{isset($request->other_notes) ? $request->other_notes : ''}}" class="form-control">
						</div>
					</div> 
					<div class="form-group row">
						<label for="" class="col-sm-3 control-label">Request Image</label>
						<div class="col-lg-4 col-md-6 col-sm-9">
							@if(isset($request->photo))
							<img src="{{URL::asset('public/admin_assets/img/')}}/{{isset($request->photo) ? $request->photo : ''}}" height="300px" width="350px">
							@endif
							<input type="file" name="image"  class="form-control" value="{{isset($request->photo) ? $request->photo : ''}}">
							
						</div>
					</div>  
					
									
					<div class="form-group row">
							<div class="col-md-offset-3 col-sm-9 ">
							<input type="hidden" name="all_imgs" value="" class="all_imgs"> 
							<div class="imgss" style="display:none"></div>
							@if(isset($id))
								<button type="button" class="btn sbmt_btn btn-primary">Update Request</button>
							@else
								<button type="button" class="btn sbmt_btn btn-primary">Add Request</button>
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