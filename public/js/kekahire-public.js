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
	 
	$(window).load(function(e){
		
		var selectConfig = { 
	 		width:"320px",
			height:"60px",
	 		minimumResultsForSearch:10
	 	};

		$('#kekahire-location-selector-select').select2( selectConfig );
		$('#kekahire-department-selector-select').select2( selectConfig );
		
		var loadlisting = function(){
			
			var departmentId = $(".kekahire-data-fetch").attr("data-departmentId");
			var city         = $(".kekahire-data-fetch").attr("data-location");
			var excludejobs  = $(".kekahire-data-fetch").attr("data-excludejobs");
			var liststyle    = $(".kekahire-data-fetch").attr("data-liststyle");
			var items        = $(".kekahire-data-fetch").attr("data-items");
			var columnspage      = $(".kekahire-data-fetch").attr("data-columnspage");
			var page         = $(".kekahire-data-fetch").attr("data-page");
			
			var str = '&departmentId=' + departmentId + '&city=' + city + '&excludejobs=' + excludejobs + '&liststyle=' + liststyle + '&items=' + items + '&columnspage=' + columnspage + '&page=' + page + '&action=kekahire_load_listings';
			$.ajax({
				type: "POST",
				dataType: "html",
				url: KH_OBJECT.ajaxurl,
				data: str,
				success: (data) => {
					var $data = $(data);
					if($data.length){
						$(".kekahire-pagination.active").remove();
						$(".kekahire-listing-wrapper").append($data);
						$(".kekahire-data-fetch").attr("data-page",parseInt(page) + parseInt(1));
					}
					else {
						$(".kekahire-listing-wrapper").html("No Jobs");
					}
				}

			});
			return false;


			
		}
		
		loadlisting();
		
		$('.kekahire-sidebar-wrapper li').click( function() { 
			$(".kekahire-data-fetch").attr("data-departmentId",$(this).attr("data-value"));
			$(".kekahire-data-fetch").attr("data-page",parseInt(1));
			$(".kekahire-listing-wrapper").html("");
			loadlisting();
			
			$(".kekahire-sidebar-wrapper li").removeClass("selected");
			$(this).addClass("selected");
		});
		
		$('.kekahire-department-selector select').change( function() { 
			$(".kekahire-data-fetch").attr("data-departmentId",$(this).val());
			$(".kekahire-data-fetch").attr("data-page",parseInt(1));
			$(".kekahire-listing-wrapper").html("");
			loadlisting();
		});
		
		$('.kekahire-location-selector select').change( function() { 
			$(".kekahire-data-fetch").attr("data-location",$(this).val());
			$(".kekahire-data-fetch").attr("data-page",parseInt(1));
			$(".kekahire-listing-wrapper").html("");
			loadlisting();
		});
		
		$('body').on('click', '.kekahire-pagination span', function() { 
			$(".kekahire-pagination span").html("Loading");
			$(".kekahire-pagination").addClass("active");
			loadlisting();
		});
		
	});

})( jQuery );
