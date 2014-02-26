<?php

?>
//<script>
function treatmentsDeleteTreatmentPrescription(treatment_prescription_guid){
	if(treatment_prescription_guid && confirm(elgg.echo("treatments:js:treatment_prescriptions:delete:confirm"))){
		document.location.href = elgg.security.addToken("<?php 
                echo $vars['url']; 
                ?>action/treatments/treatment_prescription/delete?treatment_prescription_guid=" + treatment_prescription_guid);
	}
}
function treatmentsArchiveTreatment(treatment_prescription_guid){
	if(treatment_prescription_guid && confirm(elgg.echo("treatments:js:treatment_prescriptions:archive:confirm"))){
		document.location.href = elgg.security.addToken("<?php 
                echo $vars['url']; 
                ?>action/treatments/treatment_prescription/archive?treatment_prescription_guid=" + treatment_prescription_guid);
	}
}
function treatmentsRestoreTreatment(treatment_prescription_guid){
	if(treatment_prescription_guid && confirm(elgg.echo("treatments:js:treatment_prescriptions:restore:confirm"))){
		document.location.href = elgg.security.addToken("<?php 
                echo $vars['url']; 
                ?>action/treatments/treatment_prescription/restore?treatment_prescription_guid=" + treatment_prescription_guid);
	}
}
