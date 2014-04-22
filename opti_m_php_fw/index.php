<?php

/**
 * Opti_M Framework. A fast MVC framework dedicated for mobile web sites and services.
 *
 * @author Dominik Wlazlowski <dominik-w@dominik-w.pl> 2010
 * @version 0.9.5
 */

session_start();

define('DEBUG_MODE', true); // define global debug mode; switching production and development env
define('DB_PREFIX', 'om_'); // define prefix for DB tables

/**
 * Set global error reporting level
 */
if (DEBUG_MODE)
{
  $t_start = microtime(true);
  error_reporting(E_ALL | E_STRICT);
}
else
{
  error_reporting(0);
}

/**
 * Set applicaton path
 */
$app_path = realpath(dirname(__FILE__));
define('_APP_PATH', $app_path);

define('_APP_WEB_PATH', '/');

/**
 * Bootstrap
 */
include 'bootstrap/run.php';

/**
 * Load the kernel
 */
$registry->kernel = new Kernel($registry);

/**
 * Set the controller path; change this path if you want to provide e.g.
 * separated controllers for mobile version
 */
$registry->kernel->setPath(_APP_PATH . '/controller');

// handle mobile device detection
if (!isset($_SESSION['mobile_mode']))
{
  if (Config::getInstance()->getVal('application', 'mobile_auto_detect'))
  {
    // $isMobile = Mobile::isMobileDevice(); // old way
    $detect = new Mobile_Detect();
    
    $isMobile = $detect->isMobile();
    // if ($detect->isTablet())
    if ($isMobile)
    {
      $_SESSION['mobile_mode'] = true;
    }
    else
    {
      $_SESSION['mobile_mode'] = false;
    }
  }
}

/**
 * Call view layer for assemble and display of the view
 */
$registry->view = new View($registry);

/**
 * Controller loading
 */
$registry->kernel->load();

if (DEBUG_MODE)
{
  $t_end = microtime(true);
  echo Tools::debug('Time: ' . round($t_end - $t_start, 6)); // log the duration
}
