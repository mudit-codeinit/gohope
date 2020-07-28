$(function() {
    "use strict";

    $(".preloader").fadeOut();
    // this is for close icon when navigation open in mobile view
    $(".nav-toggler").on('click', function() {
        $("#main-wrapper").toggleClass("show-sidebar");
        $(".nav-toggler i").toggleClass("ti-menu");
    });
    

    // ============================================================== 
    // Resize all elements
    // ============================================================== 
    $("body, .page-wrapper").trigger("resize");
    $(".page-wrapper").delay(20).show();
    
	
    //****************************
    /* This is for the mini-sidebar if width is less then 1170*/
    //**************************** 
    var setsidebartype = function() {
        var width = (window.innerWidth > 0) ? window.innerWidth : this.screen.width;
        if (width < 1170) {
            $("#main-wrapper").attr("data-sidebartype", "mini-sidebar");
        } else {
            $("#main-wrapper").attr("data-sidebartype", "full");
        }
    };
    $(window).ready(setsidebartype);
    $(window).on("resize", setsidebartype);
	
	//==============================================================
    // Bootstrap core addons*/
    //==============================================================
	$('[data-toggle="tooltip"]').tooltip(); 
	$('[data-toggle="popover"]').popover();
	$(".custom-file-input").on("change", function() {
		var e = $(this).val();
		$(this).next(".custom-file-label").html(e);
		if($(this).parents('.input-group').has('.input-group-prepend').length) {
			readURL(this);		
		}
	});
	function readURL(input) {		
		if (input.files && input.files[0]) {			
			var reader = new FileReader();

			reader.onload = function(e) {
			  $(input).parents('.input-group').children('.input-group-prepend').children('img').attr('src', e.target.result);
			}

			reader.readAsDataURL(input.files[0]);
		}
	}
	//==============================================================
    // Sidebar scroll Trigger */
    //==============================================================
	$(".scroll-sidebar").perfectScrollbar({});
	//==============================================================
    // Print invoices */
    //==============================================================
	$("#print").click(function() {
		var mode = 'iframe'; //popup
		var close = mode == "popup";
		var options = {
			mode: mode,
			popClose: close
		};
		$("div.printableArea").printArea(options);
	});
	//==============================================================
    // Datepicker Trigger */
    //==============================================================
	$( ".date-picker" ).datepicker({
		autoclose: true,
        todayHighlight: true
	});
	jQuery('#date-range').datepicker({
        toggleActive: true
    });
	
	//==============================================================
    // Data Tables Trigger */
    //==============================================================
	$('.datatable_custom').each(function(){
		var table               = $(this);
		var orderby             = $(this).data('order-col-by');
		var orderin             = $(this).data('order-col-in').toString();
		var sortdis             = $(this).data('disable-sort');
		$(table).DataTable({
			"order": [
				[orderby, orderin]
			],
			columnDefs: [{
				targets: [sortdis],
				orderable: false
			}
			]
		});
	});
	//==============================================================
    // Custom Texteditor Summernote */
    //==============================================================
	$('.js-summernote').each(function(){
		var editor               = $(this);
		var placeholder          = $(this).data('placeholder');
		var height               = $(this).data('height');
		$(editor).summernote({
			placeholder: placeholder,
			tabsize: 2,
			height: height
		});
	});
});

//==============================================================
// Custom Alert Function and Trigger */
//==============================================================
function confirm_alert(event) {
	var t                 = $(this);
	var title             = t.data('title');
	var alert_text        = t.data('text');
	var btn_text          = t.data('confirm-btn-text');
	var final_link        = t.attr('href');
	event.preventDefault();
	Swal.fire({
		title: title,
		text: alert_text,
		type: "warning",
		showCancelButton: true,
		confirmButtonColor: "#DD6B55",
		confirmButtonText: btn_text
	}).then((result) => {
		if (result.value) {
			window.location.href = final_link;
		}
	})
}
