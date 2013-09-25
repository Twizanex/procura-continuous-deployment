<?php

/* Procura Alzheimer Theme
 * 
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */
?>
/******* PROCURA LAYOUT *******/
.procura-header-left{
    float:left;
    width:75%;
}

.procura-header-right{
    float:right;
    width:25%;
}

/*********  FICHA DE DETALLE DE CONTACTOS  ************/
.procura-contacto{
    border: groove;
    border-color: #000000;
    height: 33%;
    -webkit-border-radius: 1em;
    -moz-border-radius: 1em;
    border-radius: 1em;
    margin-top: 1em;
}

.procura-contacto-inner-left{
    float: left;
    height: 100%;
    width: 20%;
}

.procura-contacto-inner-right{
    float: right;
    height: 100%;
    width: 70%;
}

.procura-contacto-inner-right lu li{
    display: inline;
}

#procura-contacto-menu{
    display: inline;
}

/************* SEPARADOR DE BLOQUES ***************/
.procura-separador{
    clear:both;
}

/************* DESCRICPION DEL SITIO *************/
.procura-descripcion{
    float:left;    
    color:#EE0000;
}
/* ***************************************
	PAGE LAYOUT
*************************************** */
/***** DEFAULT LAYOUT ******/
<?php // the width is on the page rather than topbar to handle small viewports ?>
.elgg-page-default {
	/*min-width: 998px;*/
        min-width:62.375em;
}
.elgg-page-default .elgg-page-header > .elgg-inner {
	width: 100%;
	margin: 0 auto;
	/*height: 90px;*/
        height: 5.625em;
}
.elgg-page-default .elgg-page-body > .elgg-inner {
	width: 100%;
	margin: 0 auto;
}
.elgg-page-default .elgg-page-footer > .elgg-inner {
	width: 100%;
	margin: 0 auto;
	/*padding: 5px 0;
	border-top: 1px solid #DEDEDE;*/
        padding: 0.3125em 0;
        border-top: 0.0625em solid #91B109;
}

/***** TOPBAR ******/
.elgg-page-topbar {
	background: #333333 url(<?php echo elgg_get_site_url(); ?>_graphics/toptoolbar_background.gif) repeat-x top left;
	border-bottom: 1px solid #000000;
	position: relative;
	height: 24px;
	z-index: 9000;
}
.elgg-page-topbar > .elgg-inner {
	padding: 0 10px;
}

/***** PAGE MESSAGES ******/
.elgg-system-messages {
	position: fixed;
	top: 24px;
	right: 20px;
	max-width: 500px;
	z-index: 2000;
}
.elgg-system-messages li {
	margin-top: 10px;
}
.elgg-system-messages li p {
	margin: 0;
}

/***** PAGE HEADER ******/
.elgg-page-header {
	position: relative;
	background: none ;
}
.elgg-page-header > .elgg-inner {
	position: relative;
}

/***** PAGE BODY LAYOUT ******/
.elgg-layout {
	min-height: 360px;
}
.elgg-layout-one-sidebar {
	background: transparent url(<?php echo elgg_get_site_url(); ?>_graphics/sidebar_background.gif) repeat-y right top;
}
.elgg-layout-two-sidebar {
	background: transparent url(<?php echo elgg_get_site_url(); ?>_graphics/two_sidebar_background.gif) repeat-y right top;
}
.elgg-layout-error {
	margin-top: 20px;
}
.elgg-sidebar {
	position: relative;
	padding: 20px 10px;
	float: right;
	width: 210px;
	margin: 0 0 0 10px;
}
.elgg-sidebar-alt {
	position: relative;
	padding: 20px 10px;
	float: left;
	width: 160px;
	margin: 0 10px 0 0;
}
.elgg-main {
	position: relative;
	min-height: 360px;
	padding: 10px;
}
.elgg-main > .elgg-head {
	padding-bottom: 3px;
	border-bottom: 1px solid #CCCCCC;
	margin-bottom: 10px;
}

/***** PAGE FOOTER ******/
.elgg-page-footer {
	position: relative;
}
.elgg-page-footer {
	color: #999;
}
.elgg-page-footer a:hover {
	color: #666;
}