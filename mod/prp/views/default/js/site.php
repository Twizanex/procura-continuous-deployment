<?php
?>
// PRP More Info tooltips
//<script>
$(document).ready(function(){
	$("span.custom_fields_more_info").live('mouseover', function(e) {
			var tooltip = $("#text_" + $(this).attr('id'));
			$("body").append("<p id='custom_fields_more_info_tooltip'>"+ $(tooltip).html() + "</p>");
		
			if (e.pageX < 900) {
				$("#custom_fields_more_info_tooltip")
					.css("top",(e.pageY + 10) + "px")
					.css("left",(e.pageX + 10) + "px")
					.fadeIn("medium");	
			}	
			else {
				$("#custom_fields_more_info_tooltip")
					.css("top",(e.pageY + 10) + "px")
					.css("left",(e.pageX - 260) + "px")
					.fadeIn("medium");		
			}			
		}).live('mouseout', function() {
			$("#custom_fields_more_info_tooltip").remove();
		}
	);	
	
	
        // veremos si esto funciona para mostrar popups
        $(".prp-popup").fancybox();
        
//	hash = window.location.hash;
//	if(hash && $("#profile_manager_profile_edit_tabs " + hash).length > 0){
	
//		$("#profile_manager_profile_edit_tabs " + hash + " a").click();
//	} else {
//		$("#profile_manager_profile_edit_tabs a:first").click();
//	}
});
