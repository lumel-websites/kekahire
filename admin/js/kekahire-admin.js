(function( $ ) {
	'use strict';

	/**
	 * All of the code for your admin-facing JavaScript source
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

	 	var selectConfig = {
	 		placeholder:"Select an option", 
	 		width:"320px", 
	 		allowClear:true, 
	 		minimumResultsForSearch:10,
	 		language: {
				noResults: function (params) {
					return "Configure Kekahire Subdomain.";
				}
			}
	 	};

	 	$('#kekahire-department-selector').select2( selectConfig );
	 	$('#kekahire-location-selector').select2( selectConfig );
		$('#kekahire-state-selector').select2( selectConfig );
		$('#kekahire-city-selector').select2( selectConfig );

	 	var buildShortcode = function(ee){
			
			var title 		= $('#kekahire-title').val();
			var listing     = $('#kekahire-listing-selector').val();
	 		var departments = $('#kekahire-department-selector').val();
	 		var country 	= $('#kekahire-location-selector').val();
	 		var state		= $('#kekahire-state-selector').val();
	 		var city		= $('#kekahire-city-selector').val();
			var zerolisting	= $('#kekahire-jobs-zero-listing').val();
			var hidecount	= $('#kekahire-jobs-hide-count').val();
			var defaultdepartment	= $('#kekahire-default-department-selector').val();
			var defaultlocation	= $('#kekahire-default-location-selector').val();
			var itemsinrow	= $('#kekahire-itemsinrow-selector').val();
			var exclude		= $('#kekahire-jobs-exclude').val();
			
			if(listing == "smart") {
				departments = null;
				country = null;
				state = null;
				city = null;
				itemsinrow = null;
				
				$('.kekahire-admin-simple-listing-row').hide();
				$('.kekahire-admin-smart-listing-row').show();
				$('.kekahire-admin-grid-listing-row').hide();
			}
			else if(listing == "grid") {
				departments = null;
				country = null;
				state = null;
				city = null;
				
				$('.kekahire-admin-simple-listing-row').hide();
				$('.kekahire-admin-smart-listing-row').show();
				$('.kekahire-admin-grid-listing-row').show();
			}
			else {
				$('#kekahire-jobs-zero-listing').prop('checked', false);
				$('#kekahire-jobs-hide-count').prop('checked', false);
				
				defaultdepartment = null;
				defaultlocation = null;
				
				$('.kekahire-admin-simple-listing-row').show();
				$('.kekahire-admin-smart-listing-row').hide();
				$('.kekahire-admin-grid-listing-row').hide();
			}

	 		var shortcode = '[kekajobs';
			
	 		if( departments == null ) {
	 			departments = "";
	 		} else {
		 		departments = departments.join();
	 		}
			
			if( country == null ) {
	 			country = "";
	 		}
			
			if( state == null ) {
	 			state = "";
	 		} else {
		 		state = state.join();
	 		}
			
			if( city == null ) {
	 			city = "";
	 		} else {
		 		city = city.join();
	 		}
			
			if( defaultdepartment == null ) {
	 			defaultdepartment = "";
	 		}
			
			if( defaultlocation == null ) {
	 			defaultlocation = "";
	 		}
			
			if( itemsinrow == null ) {
	 			itemsinrow = "";
	 		}

	 		if( title !== '' ){
	 			shortcode += ' title="' + title + '"';
	 		}
			
			if( listing !== '' ){
	 			shortcode += ' listing="' + listing + '"';
	 		}

	 		if( departments !== '' ){
	 			shortcode += ' departments="' + departments + '"';
	 		}

	 		if( country !== '' ){
	 			shortcode += ' country="' + country + '"';	
	 		}

	 		if( state !== '' ){
	 			shortcode += ' state="' + state + '"';	
	 		}

	 		if( city !== '' ){
	 			shortcode += ' city="' + city + '"';	
	 		}
			
			if(($('#kekahire-jobs-zero-listing')).is(":checked")){
	 			shortcode += ' zerolisting="' + zerolisting + '"';	
	 		}
			
			if(($('#kekahire-jobs-hide-count')).is(":checked")){
	 			shortcode += ' hidecount="' + hidecount + '"';	
	 		}
			
			if( defaultdepartment !== '' ){
	 			shortcode += ' defaultdepartment="' + defaultdepartment + '"';	
	 		}
			
			if( defaultlocation !== '' ){
	 			shortcode += ' defaultlocation="' + defaultlocation + '"';	
	 		}
			
			if( itemsinrow !== '' ){
	 			shortcode += ' itemsinrow="' + itemsinrow + '"';	
	 		}
			
			if( exclude !== '' ){
	 			shortcode += ' excludejobs="' + exclude + '"';	
	 		}

	 		shortcode += ']';

	 		$('#kekahire-shortcode').html( shortcode );
	 	}

	 	$('#kekahire-title').keyup( buildShortcode );
		$('#kekahire-listing-selector').change( buildShortcode );
	 	$('#kekahire-department-selector').change( buildShortcode );
	 	$('#kekahire-location-selector').change( buildShortcode );
	 	$('#kekahire-state-selector').change( buildShortcode );
	 	$('#kekahire-city-selector').change( buildShortcode );
		$('#kekahire-jobs-zero-listing').change( buildShortcode );
		$('#kekahire-jobs-hide-count').change( buildShortcode );
		$('#kekahire-default-department-selector').change( buildShortcode );
		$('#kekahire-default-location-selector').change( buildShortcode );
		$('#kekahire-itemsinrow-selector').change( buildShortcode );
		$('#kekahire-jobs-exclude').keyup( buildShortcode );
		
		$("#kekahire-state-selector").on("change",function(){ 
			$("#kekahire-city-selector").html("");
			$("#kekahire-city-selector").prop('disabled', true);
			
			var state = $(this).val();
			var str = '&state=' + state + '&action=kekahire_load_state_city_ajax';
			$.ajax({
				type: "POST",
				dataType: "html",
				url: KH_OBJECT.ajaxurl,
				data: str,
				success: (data) => {
					var $data = $(data);
					if($data.length){
						$("#kekahire-city-selector").append($data);
						
						$("#kekahire-city-selector").prop('disabled', false);
					}
				}

			});
			return false;
		});
		
		//State/City Fetch
		$("#kekahire-location-selector").on("change",function(){
			$("#kekahire-state-selector").html("");
			$("#kekahire-city-selector").html("");
			
			$("#kekahire-state-selector").prop('disabled', true);
			$("#kekahire-city-selector").prop('disabled', true);
			
			var country = $(this).val();
			var str = '&country=' + country + '&action=kekahire_load_state_city_ajax';
			$.ajax({
				type: "POST",
				dataType: "html",
				url: KH_OBJECT.ajaxurl,
				data: str,
				success: (data) => {
					var $data = $(data);
					if($data.length){
						$("#kekahire-state-selector").append($data);
						
						$("#kekahire-state-selector").prop('disabled', false);
					}
				}

			});
			return false;
		});
		
		//Initialize Color Picker
		$('.kekahire-my-color-field').wpColorPicker();

	 });

})( jQuery );

