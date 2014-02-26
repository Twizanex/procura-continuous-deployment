<?php

?>
//<script>
function treatmentsDeleteTreatmentExecution(treatment_execution_guid){
	if(treatment_guid && confirm(elgg.echo("treatments:js:treatment_executions:delete:confirm"))){
		document.location.href = elgg.security.addToken("<?php 
                echo $vars['url']; 
                ?>action/treatments/treatment_execution/delete?treatment_execution_guid=" + treatment_execution_guid);
	}
}
function treatmentsArchiveTreatmentExecution(treatment_execution_guid){
	if(treatment_guid && confirm(elgg.echo("treatments:js:treatment_executions:archive:confirm"))){
		document.location.href = elgg.security.addToken("<?php 
                echo $vars['url']; 
                ?>action/treatments/treatment_execution/archive?treatment_execution_guid=" + treatment_execution_guid);
	}
}
function treatmentsRestoreTreatmentExecution(treatment_execution_guid){
	if(treatment_guid && confirm(elgg.echo("treatments:js:treatment_executions:restore:confirm"))){
		document.location.href = elgg.security.addToken("<?php 
                echo $vars['url']; 
                ?>action/treatments/treatment_execution/restore?treatment_execution_guid=" + treatment_execution_guid);
	}
}
