<?php

/**
 * Alzheimer Procura buttons
 * sdrortega 22/01/2013
 */
?>
/* **************************
	BUTTONS
************************** */

/* Base */
.procura-button{
	font-size: 0.875em;
	font-weight: bold;
        font-family: "Arial RoundedMT";
        
        -webkit-border-radius: 10px;
	-moz-border-radius: 10px;
	border-radius: 10px;
        border-style: solid;
        border-width: 5px;
        
        width: auto;
	padding: 5px 5px;
	cursor: pointer;	
        
        -webkit-box-shadow: 0px 1px 0px rgba(0, 0, 0, 0.40);
	-moz-box-shadow: 0px 1px 0px rgba(0, 0, 0, 0.40);
	box-shadow: 0px 1px 0px rgba(0, 0, 0, 0.40);
}

.procura-button-salir {
        border-color: #DDFC91;
        background-color: #A9C65D;
        color: white;
        margin-bottom: 5px;
}

.procura-button-salir:hover {
        border-color: #DDFC91;
        background-color: #A9C65D;
        color: white;
        margin-bottom: 5px;
        outline: #7B9133 dotted;
}

.procura-button-volver {
        border-color: #E0F991;
        background-color: #7B9133;
        color: white;
}


.procura-button-menu-item{
        width: 5.5em;
        height: 4.375em;        
        margin-bottom: 2%;       
        color: black;
        border-style: double solid solid double;
        border-color: #ACC55B;
}

<?php
/**
 * CSS buttons
 *
 * @package Elgg.Core
 * @subpackage UI
 */
?>
/* **************************
	BUTTONS
************************** */

/* Base */
/*Modificado para Procura = procura-button*/
.elgg-button {
	font-size: 0.875em;
	font-weight: bold;
        font-family: "Arial RoundedMT";
        
        -webkit-border-radius: 10px;
	-moz-border-radius: 10px;
	border-radius: 10px;
        /*border-style: solid solid solid solid;*/
        border-width: 5px;
        
        width: auto;
	padding: 5px 5px;
	cursor: pointer;
}
a.elgg-button {
	padding: 3px 6px;
}

/* Submit: This button should convey, "you're about to take some definitive action" */
/*SDR 23/01/2013
  Botones de envío de información en forms (login...)
*/
.elgg-button-submit {
	color: white;
	text-decoration: none;
	border-color: #E0F991;
        border-style: solid solid solid solid;
	background-color: #91B109 ;
        
}

.elgg-button-submit:hover {
	border-color: #7B9133;
        border-style: solid solid solid solid;
	text-decoration: none;
	color: white;
	background: #7B9133;
}

.elgg-button-submit.elgg-state-disabled {
	background: #999;
	border-color: #999;
        border-style: solid solid solid solid;
	cursor: default;
}

/* Cancel: This button should convey a negative but easily reversible action (e.g., turning off a plugin) */
/*SDR 23/01/2013*/
.elgg-button-cancel {
	color: #333;
	background: #CE4507;
	border: 1px solid #CE4507;
}
.elgg-button-cancel:hover {
	color: #444;
	background-color: #999;
	background-position: left 10px;
	text-decoration: none;
}

/* Action: This button should convey a normal, inconsequential action, such as clicking a link */
/* SDR 23/01/2013 Igual a button-submit*/
.elgg-button-action {
	color: white;
	text-decoration: none;
	border: 3px solid #E0F991;
	background: #91B109;
}

.elgg-button-action:hover,
.elgg-button-action:focus {
	background: #ccc ;
	color: #111;
	text-decoration: none;
	border: 3px solid #999;
}

/* Delete: This button should convey "be careful before you click me" */
.elgg-button-delete {
	color: #bbb;
	text-decoration: none;
	border: 1px solid #333;
	background: #555 ;	
}
.elgg-button-delete:hover {
	color: #999;
	background-color: #333;
	background-position: left 10px;
	text-decoration: none;
}

.elgg-button-dropdown {
	padding:3px 6px;
	text-decoration:none;
	display:block;
	font-weight:bold;
	position:relative;
	margin-left:0;
	color: white;
	border:1px solid #71B9F7;
	
	-webkit-border-radius:4px;
	-moz-border-radius:4px;
	border-radius:4px;
	
	-webkit-box-shadow: 0 0 0;
	-moz-box-shadow: 0 0 0;
	box-shadow: 0 0 0;
	
	background-position:-150px -51px;
	background-repeat:no-repeat;*/
}

.elgg-button-dropdown:after {
	content: " \25BC ";
	font-size:smaller;
}

.elgg-button-dropdown:hover {
	background-color:#71B9F7;
	text-decoration:none;
}

.elgg-button-dropdown.elgg-state-active {
	background: #ccc;
	outline: none;
	color: #333;
	border:1px solid #ccc;
	
	-webkit-border-radius:4px 4px 0 0;
	-moz-border-radius:4px 4px 0 0;
	border-radius:4px 4px 0 0;
}
