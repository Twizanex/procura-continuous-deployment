<?php

?>
//<script>
function prpDeleteModuleAction(module_name, action_name){
	if(module_name && action_name && confirm(elgg.echo("prp:js:module_actions:delete:confirm"))){
		document.location.href = elgg.security.addToken("<?php 
                echo $vars['url']; 
                ?>action/prp/module_actions/delete?action_name=" + action_name
                        + "&module_name=" + module_name);
	}
}
