<?php

// Set the environment to 'development' for local testing
define('ENVIRONMENT', 'development');

if (defined('ENVIRONMENT')) {
    switch (ENVIRONMENT) {
        case 'development':
            error_reporting(E_ALL);
            ini_set('display_errors', 1);
            break;

        case 'testing':
        case 'production':
            ini_set('display_errors', 0);
            if (version_compare(PHP_VERSION, '5.3', '>=')) {
                error_reporting(E_ALL & ~E_DEPRECATED & ~E_STRICT);
            } else {
                error_reporting(E_ALL & ~E_NOTICE);
            }
            break;

        default:
            exit('The application environment is not set correctly.');
    }
}

/*
 *---------------------------------------------------------------
 * SYSTEM FOLDER NAME
 *---------------------------------------------------------------
 */
$system_path = '../system';

/*
 *---------------------------------------------------------------
 * APPLICATION FOLDER NAME
 *---------------------------------------------------------------
 */
$application_folder = '../application';

/*
 *---------------------------------------------------------------
 * VIEW FOLDER NAME
 *---------------------------------------------------------------
 */
$view_folder = '';

/*
 * -------------------------------------------------------------------
 *  CUSTOM CONFIG VALUES
 * -------------------------------------------------------------------
 */
$assign_to_config['base_url'] = 'http://hvarexcursions.local/';

/*
 *---------------------------------------------------------------
 * END OF USER CONFIGURABLE SETTINGS
 *---------------------------------------------------------------
 */

/*
 * ------------------------------------------------------
 *  Resolve the system path for increased reliability
 * ------------------------------------------------------
 */

// Set the current directory correctly for CLI requests
if (defined('STDIN')) {
    chdir(dirname(__FILE__));
}

if (realpath($system_path) !== FALSE) {
    $system_path = realpath($system_path) . '/';
}

// Ensure there's a trailing slash
$system_path = rtrim($system_path, '/') . '/';

// Is the system path correct?
if (!is_dir($system_path)) {
    exit("Your system folder path does not appear to be set correctly. Please open the following file and correct this: " . pathinfo(__FILE__, PATHINFO_BASENAME));
}

/*
 * -------------------------------------------------------------------
 *  Now that we know the path, set the main path constants
 * -------------------------------------------------------------------
 */
// The name of THIS file
define('SELF', pathinfo(__FILE__, PATHINFO_BASENAME));

// Path to the system folder
define('BASEPATH', str_replace('\\', '/', $system_path));

// Path to the front controller (this file)
define('FCPATH', str_replace(SELF, '', __FILE__));

// Name of the "system folder"
define('SYSDIR', trim(strrchr(trim(BASEPATH, '/'), '/'), '/'));

// The path to the "application" folder
if (is_dir($application_folder)) {
    define('APPPATH', $application_folder . '/');
} else {
    if (!is_dir(BASEPATH . $application_folder . '/')) {
        exit("Your application folder path does not appear to be set correctly. Please open the following file and correct this: " . SELF);
    }

    define('APPPATH', BASEPATH . $application_folder . '/');
}

// The path to the "views" folder
if (!is_dir($view_folder)) {
    if (!empty($view_folder) && is_dir(APPPATH . $view_folder . '/')) {
        $view_folder = APPPATH . $view_folder;
    } elseif (!is_dir(APPPATH . 'views/')) {
        exit('Your view folder path does not appear to be set correctly. Please open the following file and correct this: ' . SELF);
    } else {
        $view_folder = APPPATH . 'views';
    }
}

define('VIEWPATH', rtrim($view_folder, '/') . '/');

/*
 * --------------------------------------------------------------------
 * LOAD THE BOOTSTRAP FILE
 * --------------------------------------------------------------------
 *
 * And away we go...
 *
 */
require_once BASEPATH . 'core/CodeIgniter.php';

/* End of file index.php */
/* Location: ./index.php */
