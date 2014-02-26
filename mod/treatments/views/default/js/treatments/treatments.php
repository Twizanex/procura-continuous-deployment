<?php

?>
//<script>
function treatmentsDeleteTreatment(treatment_guid){
	if(treatment_guid && confirm(elgg.echo("treatments:js:treatments:delete:confirm"))){
		document.location.href = elgg.security.addToken("<?php 
                echo $vars['url']; 
                ?>action/treatments/treatment/delete?treatment_guid=" + treatment_guid);
	}
}
function treatmentsArchiveTreatment(treatment_guid){
	if(treatment_guid && confirm(elgg.echo("treatments:js:treatments:archive:confirm"))){
		document.location.href = elgg.security.addToken("<?php 
                echo $vars['url']; 
                ?>action/treatments/treatment/archive?treatment_guid=" + treatment_guid);
	}
}
function treatmentsRestoreTreatment(treatment_guid){
	if(treatment_guid && confirm(elgg.echo("treatments:js:treatments:restore:confirm"))){
		document.location.href = elgg.security.addToken("<?php 
                echo $vars['url']; 
                ?>action/treatments/treatment/restore?treatment_guid=" + treatment_guid);
	}
}
