<?php

?>
//<script>
function prpDeleteRelationName(relationName){
	if(relationName && confirm(elgg.echo("prp:js:relations:names:delete:confirm"))){
		document.location.href = elgg.security.addToken("<?php 
                echo $vars['url']; 
                ?>action/prp/relations/names/delete?relation_name=" + relationName);
	}
}
function prpDeleteRelation(subject, object, name){
	if(subject && object && name && confirm(elgg.echo("prp:js:relations:delete:confirm"))){
		document.location.href = elgg.security.addToken("<?php 
                echo $vars['url']; 
                ?>action/prp/relations/delete?subject_user_guid=" + subject
                        + "&object_user_guid=" + object
                        + "&relation_name=" + name);
	}
}
function prpDeleteAllRelations(subject){
	if(subject && confirm(elgg.echo("prp:js:relations:delete_all:confirm"))){
		document.location.href = elgg.security.addToken("<?php 
                echo $vars['url']; 
                ?>action/prp/relations/delete_all?subject_user_guid=" + subject);
	}
}
