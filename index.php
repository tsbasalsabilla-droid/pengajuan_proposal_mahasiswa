<?php
/*
 *---------------------------------------------------------------
 * APPLICATION FOLDER NAME
 *---------------------------------------------------------------
 *
 * If you want this front controller to use a different "application"
 * folder then the default one you can set its name here. The folder
 * can also be renamed or relocated anywhere on your server. If you
 * do, use an absolute or full URL that points to the location.
 *
 * If you only want to change the default "application" folder name
 * you can ignore the rest of the file, except for the last line.
 */
$application_folder = 'application';

/*
 *---------------------------------------------------------------
 * SYSTEM FOLDER NAME
 *---------------------------------------------------------------
 *
 * These variables will be used in the init() method below to
 * determine some default paths. Because of the nature of this file,
 * these variables can not be modified from the config file.
 */
$system_path = 'system';

/*
 *---------------------------------------------------------------
 * APPLICATION ENVIRONMENT
 *---------------------------------------------------------------
 *
 * You can load different configurations depending on your
 * current environment. Setting the environment also influences
 * things like logging and error reporting.
 *
 * NOTE: If you change these, also change the error_reporting() code below
 */
define('ENVIRONMENT', isset($_SERVER['CI_ENV']) ? $_SERVER['CI_ENV'] : 'development');

/*
 *---------------------------------------------------------------
 * ERROR REPORTING
 *---------------------------------------------------------------
 *
 * Different environments will require different levels of error reporting.
 * By default development will show errors but testing and live will hide them.
 */
switch (ENVIRONMENT)
{
	case 'development':
		error_reporting(E_ALL & ~E_NOTICE & ~E_DEPRECATED & ~E_STRICT);
		ini_set('display_errors', 1);
	break;

	case 'testing':
	case 'production':
		ini_set('display_errors', 0);
		if (version_compare(PHP_VERSION, '5.3', '>='))
		{
			error_reporting(E_ALL & ~E_DEPRECATED & ~E_STRICT);
		}
		else
		{
			error_reporting(E_ALL & ~E_STRICT);
		}
	break;

	default:
		header('HTTP/1.1 503 Service Unavailable.', TRUE, 503);
		echo 'The application environment is not set correctly.';
		exit(1); // EXIT_ERROR
}

/*
 *---------------------------------------------------------------
 * SYSTEM DIRECTORY NAME
 *---------------------------------------------------------------
 *
 * This variable must contain the name of your "system" directory.
 * Set the path if it is not in the same directory as this file.
 */
if (($system_path = rtrim($system_path, '/\\')) === '')
{
	$system_path = 'system';
}

/*
 *---------------------------------------------------------------
 * APPLICATION DIRECTORY NAME
 *---------------------------------------------------------------
 *
 * If you want this front controller to use a different "application"
 * directory then the default one you can set its name here. The folder
 * can also be renamed or relocated anywhere on your server. If you
 * do, use a full URL, including leading slash.
 *
 * NO TRAILING SLASH!
 */
if (($application_folder = rtrim($application_folder, '/\\')) === '')
{
	$application_folder = 'application';
}

/*
 *---------------------------------------------------------------
 * RESOLVE CUSTOM CONFIG VALUES
 *---------------------------------------------------------------
 *
 * The config file may contain custom values that need to be resolved
 * at runtime. These values are stored in the $assign_to_config array.
 */
$assign_to_config = array();

/*
 *---------------------------------------------------------------
 * SET THE SERVER PATH
 *---------------------------------------------------------------
 *
 * Let's attempt to determine the full-server path to the "system"
 * folder, in order to resolve a few of the issues we might run into.
 */
if (defined('STDIN'))
{
	chdir(dirname(__FILE__));
}

$directory = getcwd();
if ($directory === FALSE)
{
	echo 'Could not get current working directory.';
	exit(1); // EXIT_ERROR
}

/*
 *---------------------------------------------------------------
 * DEFINE PATH CONSTANTS
 *---------------------------------------------------------------
 *
 * We need to define the PATH constants because they are used in a
 * number of locations throughout the framework.
 */
define('SELF', pathinfo(__FILE__, PATHINFO_BASENAME));
define('FCPATH', dirname(__FILE__).'/');
define('BASEPATH', $directory.'/'.$system_path.'/');
define('APPPATH', $directory.'/'.$application_folder.'/');
define('VIEWPATH', APPPATH.'views/');

/*
 *---------------------------------------------------------------
 * LOAD THE BOOTSTRAP FILE
 *---------------------------------------------------------------
 *
 * And away we go...
 */
require_once BASEPATH.'core/CodeIgniter.php';
