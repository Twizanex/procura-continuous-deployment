<?php
/**
 * Elgg saludo browser download action.
 *
 * @package Elggsaludo
 */

// @todo this is here for backwards compatibility (first version of embed plugin?)
$download_page_handler = elgg_get_plugins_path() . 'saludo/download.php';

include $download_page_handler;
