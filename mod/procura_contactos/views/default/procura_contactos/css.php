<?php

/*
 * procura_contactos CSS 
 */
?>

.procura-lista-usuarios{    
   float:left;
   width:100%;
   overflow:hidden;
   position:relative;
}
.procura-lista-usuarios ul {
   clear:left;
   float:left;
   margin:0;
   padding:0;
   left:50%;   
   //min-height:30em;
}
.procura-lista-usuarios ul li {
   display:block;
   float:left;
   list-style:none;
   margin:0;
   padding:0;
   right:50%;
}
.procura-lista-usuarios ul li a {
   display:block;
   margin: 0 auto;
   padding:3px 10px;   
   text-decoration:none;
   line-height:1.3em;
}

/*********  FICHA DE DETALLE DE CONTACTOS  ************/     
  .procura-contacto{               
    height: 9em;
    width : 9em;
    -webkit-border-radius: 1em;
    -moz-border-radius: 1em;
    border-radius: 1em;
    margin-bottom: 2em; 
    margin-left: 2em; 
}

.procura-contacto-izq{
    float:left;
    clear:left;
    margin-left:5%;
    margin-bottom: 2%; 
}

.procura-contacto-der{
    float:right;
    clear:right;
    margin-right:5%;
    margin-bottom: 2%;
}

.procura-contacto-inner-left{
    float: left;
    //height: 100%;
    width: 30%;
}

.procura-contacto-inner-right{
    float: right;
    //height: 100%;
    width: 70%;    
}

.procura-contacto-inner-right lu li{
    display: inline;
}

#procura-contacto-menu{
    display: inline;
    backgroundcolor: green;
}

.linea{
    display: inline;
}
/**
    Items de menú como botones grandes con imágenes
 */
.procura-menu-item{
    margin-left: auto; 
    margin-right: auto;
    margin-top: 1%;
    margin-bottom: 1%;

    width: 6em;
    height: 6em;
}
 .procura-menu-item-izq{
    float:left;
    clear:left;
    margin-left:25%;
    margin-bottom: 2%;   
 }
.procura-menu-item-der{
    float:right;
    clear:right;
    margin-right:25%;
    margin-bottom: 2%;
 }

 /**
    Tipografías
 */
 
 .procura-etiquetas{
    font-size: 1.5em; 
    line-height: 2em; 
    padding-bottom:5px;    
    display: inline;
 }
 
 .procura-etiquetas-desc{
    font-size: 1.5em; 
    line-height: 2em; 
    padding-bottom:5px;    
    display: inline;
 }