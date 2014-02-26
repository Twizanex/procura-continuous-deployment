<?php
?>
//<script>
//elgg.provide('elgg.custom_index');
elgg.provide ('procura.notifications');
    
procura.notifications.sendForm = function(id_formulario){
        //alert ("Se va a enviar el formulario " + id_formulario);
        document.getElementById(id_formulario).submit();
    };
    

