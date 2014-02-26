<?php
/**
 * Elgg Messages CSS
 * 
 * @package ElggMessages
 */
?>

.messages-container {
	min-height: 200px;
}
.message.unread a {
	color: #d40005;
}
.messages-buttonbank {
	text-align: right;
}
.messages-buttonbank input {
	margin-left: 10px;
}

/*** message metadata ***/
.messages-owner {
	float: left;
	width: 20%;
	margin-right: 2%;
}
.messages-subject {
	float: left;
	width: 55%;
	margin-right: 2%;
}
.messages-timestamp {
	float: left;
	width: 14%;
	margin-right: 2%;
}
.messages-delete {
	float: left;
	width: 5%;
}

<?php
/** Cabeceras de la Bandeja de entrada*/
// El owner debería ser un poco más grande, ya que incluye la imagen y el check (ponía 20% y ponemos 25%)
?>
.messages-owner-cab {
	float: left;
	width: 25%;
	margin-right: 0.1%;  

}
.messages-subject-cab {
	float: left;
	width: 55%;
	margin-right: 0.1%;        
}
.messages-timestamp-cab {
	float: left;
	width: 14%;
	margin-right: 0.1%;        
}
/*** topbar icon ***/
/** @sdrortega: Se aumenta el tamaño del icono para mayor visibilidad **/
.messages-new {
	color: white;
	background-color: red;
	
	-webkit-border-radius: 10px; 
	-moz-border-radius: 10px;
	border-radius: 10px;
	
	-webkit-box-shadow: -2px 2px 4px rgba(0, 0, 0, 0.50);
	-moz-box-shadow: -2px 2px 4px rgba(0, 0, 0, 0.50);
	box-shadow: -2px 2px 4px rgba(0, 0, 0, 0.50);
	
	position: absolute;
	text-align: center;
	top: 0px;
	left: 26px;
	min-width: 20px;
	height: 20px;
	font-size: 14px;
	font-weight: bold;
}
