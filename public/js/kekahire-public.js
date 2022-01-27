(function( $ ) {
	'use strict';

	/**
	 * All of the code for your public-facing JavaScript source
	 * should reside in this file.
	 *
	 * Note: It has been assumed you will write jQuery code here, so the
	 * $ function reference has been prepared for usage within the scope
	 * of this function.
	 *
	 * This enables you to define handlers, for when the DOM is ready:
	 *
	 * $(function() {
	 *
	 * });
	 *
	 * When the window is loaded:
	 *
	 * $( window ).load(function() {
	 *
	 * });
	 *
	 * ...and/or other possibilities.
	 *
	 * Ideally, it is not considered best practise to attach more than a
	 * single DOM-ready or window-load handler for a particular page.
	 * Although scripts in the WordPress core, Plugins and Themes may be
	 * practising this, we should strive to set a better example in our own work.
	 */
	 
	$(document).ready(function(e){
		var loadlistingdepartment = function(ee){
			var departmentId = $(this).attr("data-departmentId");
			var city = $(".kekahire-location-selector select").val();
			if(departmentId=="" && city=="") {
				$(".kekahire-listing").show();
			}
			else {
				$(".kekahire-listing").hide();
				
				$(".kekahire-listing").each(function() {
					if(departmentId=="") {
						if($(this).attr("data-city")==city) { $(this).show(); }
					} 
					else if (city=="") {
						if($(this).attr("data-departmentId")==departmentId) { $(this).show(); }
					}
					else {
						if($(this).attr("data-departmentId")==departmentId && $(this).attr("data-city")==city) { $(this).show(); }
					}
				});
			}
			
			$(".kekahire-sidebar-wrapper li").removeClass("selected");
			$(this).addClass("selected");
		}
		var loadlistinglocation = function(ee){
			var departmentId = $(".kekahire-sidebar-wrapper li.selected").attr("data-departmentId");
			var city = $(this).val();
			
			if(departmentId=="" && city=="") {
				$(".kekahire-listing").show();
			}
			else {
				$(".kekahire-listing").hide();
				
				$(".kekahire-listing").each(function() {
					if(departmentId=="") {
						if($(this).attr("data-city")==city) { $(this).show(); }
					} 
					else if (city=="") {
						if($(this).attr("data-departmentId")==departmentId) { $(this).show(); }
					}
					else {
						if($(this).attr("data-departmentId")==departmentId && $(this).attr("data-city")==city) { $(this).show(); }
					}
				});
			}
		}
		
		$('.kekahire-sidebar-wrapper li').click( loadlistingdepartment );
		$('.kekahire-location-selector select').change( loadlistinglocation );
		
		var defaultselected = function(ee){
			var departmentId = $('.kekahire-sidebar-wrapper li.selected').attr("data-departmentId");
			var city = $(".kekahire-location-selector select").val();
			if(departmentId=="" && city=="") {
				$(".kekahire-listing").show();
			}
			else {
				$(".kekahire-listing").hide();
				
				$(".kekahire-listing").each(function() {
					if(departmentId=="") {
						if($(this).attr("data-city")==city) { $(this).show(); }
					} 
					else if (city=="") {
						if($(this).attr("data-departmentId")==departmentId) { $(this).show(); }
					}
					else {
						if($(this).attr("data-departmentId")==departmentId && $(this).attr("data-city")==city) { $(this).show(); }
					}
				});
			}
		}
		defaultselected();
	});

})( jQuery );
