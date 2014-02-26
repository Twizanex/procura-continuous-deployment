<?php
/**
 * Paquete Notificaciones
 * 
 * @package procura_notifications
 */
?>

.notifications_table{
    width: 100%;
}

.notifications_table thead{
/*
    background-color: #91B109;
    border-bottom: 0.5em solid #91B109;
    border-top: 0.5em solid #91B109;
    color: white;
    */
    font-size: 1.2em;
    font-weight: bold;
}

.notifications_table thead td{
    text-align: center;
}

.notifications_table tbody td{
    padding-top: 1.5em;
    padding-bottom: 0.5em;
}

/*
.notifications_table tbody tr:hover{
    background-color: #E0F991;
}*/


.text_notification_unread{
    /*color:blue;*/
    font-weight: bold;
}

.div_notification_unread{
    /*background-color: grey;*/
}

.text_notification_read{
    /*color:green;*/
    font-weight: normal;
}

.white_a{
    color: white;
}

.div_notification_read{
    background-color: white;
}

.td_notification_delete{
    margin-top: -1em;
    float: left;
}

.td_notification_form, .td_notification_date, .td_notification_priority, .td_notification_from{
    text-align: center;
    padding-left: 0.7em;
    padding-right: 0.7em;
}

.td_notification_priority_img{
    width: 2em;
    height: 2em;
}