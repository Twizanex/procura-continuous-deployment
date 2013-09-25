<?php

/*
 * Funciones para el correcto funcionamiento del JavaScript del módulo Custom Index de Procur@
 */
?>
//<script>
elgg.provide('elgg.custom_index');

var tiempo = 30000; //30 segundos
var t_salto = 5000; //cada 5 segundos
    
elgg.custom_index.restaurarTiempo = function(){
        tiempo = 30000;
    };
        
elgg.custom_index.ocultarMenu = function(){
        document.getElementById('procura-content-weather').style.display = "block";
        document.getElementById('procura-index').style.display = "none";
    };
    
elgg.custom_index.restaurarMenu = function(){
        document.getElementById('procura-content-weather').style.display = "none";
        document.getElementById('procura-index').style.display = "block";
    };
    
elgg.custom_index.iniciarTiempo = function(){
        document.getElementById('procura-index').style.display="block";
        setInterval (elgg.custom_index.count_down, t_salto);
    };   
    
elgg.custom_index.count_down = function(){
        if (document.getElementById('procura-index').style.display=="block"){
            tiempo -= t_salto;
            if (tiempo < 0){
                elgg.custom_index.ocultarMenu();
                elgg.custom_index.restaurarTiempo(); //se recupera el valor de tiempo inicial
            }
        }
    };

elgg.register_hook_handler('init', 'system', elgg.custom_index.iniciarTiempo);