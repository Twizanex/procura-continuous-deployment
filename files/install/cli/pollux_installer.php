<?php
/**
* Travis CI CLI installer script. It's designed for core automatic tests only.
*
* @access private
* @package Elgg
* @subpackage Test
*/

$enabled = getenv('TRAVIS') != '';//are we on Travis?

if (!$enabled) {
		  echo "This script should be run only in Travis CI test environment.\n";
		  exit(1);
}

if (PHP_SAPI !== 'cli') {
		  echo "You must use the command line to run this script.\n";
		  exit(2);
}

require_once(dirname(dirname(__FILE__)) . "/ElggInstaller.php");

$installer = new ElggInstaller();

$params = array(
	// database parameters
	'dbuser' => 'elgg_test',
	'dbpassword' => 'elgg_test',
	'dbname' => 'elgg_test',

	// site settings
	'sitename' => 'Procura Travis Site',
	'siteemail' => 'no_reply@travis.procura.org',
	//'wwwroot' => 'http://travis.procura.org/',
	'wwwroot' => 'http://localelgg/',
	//'dataroot' => getenv('HOME') . '/elgg_data/',
	'dataroot' => '/tmp/elgg_data/',
	//'dataroot' => getenv('HOME') . '/elgg_data/',
	'language' => 'es',

	// admin account
	'displayname' => 'Administrador',
	'email' => 'admin@travis.procura.org',
	'username' => 'admin',
	'password' => 'procurapwd',
);

// install and create the .htaccess file
$installer->batchInstall($params, TRUE);

// at this point installation has completed (otherwise an exception halted execution).
echo "Procur@ CLI install successful. wwwroot: " . elgg_get_config('wwwroot') . "\n";
