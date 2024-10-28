(function( $ ) {
	'use strict';
	 
	$(document).ready(function(e){
		
		var selectConfig = { 
	 		width:"320px",
			height:"60px",
	 		minimumResultsForSearch:10
	 	};

		$('#kekahire-location-selector-select').select2( selectConfig );
		$('#kekahire-department-selector-select').select2( selectConfig );
		
		var loadlisting = function(){
			
			var departmentId = $(".kekahire-data-fetch").attr("data-department");
			var city         = $(".kekahire-data-fetch").attr("data-location");

			if( departmentId == "" && city == "" ) {
				$(".kekahire-listing").show();
			} else {
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
		
		loadlisting();
		
		$('.kekahire-sidebar-wrapper li').click( function() { 
			$(".kekahire-data-fetch").attr("data-department",$(this).attr("data-value"));
			loadlisting();
			
			$(".kekahire-sidebar-wrapper li").removeClass("selected");
			$(this).addClass("selected");
		});
		
		$('.kekahire-department-selector select').change( function() { 
			$(".kekahire-data-fetch").attr("data-department",$(this).val());
			loadlisting();
		});
		
		$('.kekahire-location-selector select').change( function() { 
			$(".kekahire-data-fetch").attr("data-location",$(this).val());
			loadlisting();
		});
		
	});

})( jQuery );
