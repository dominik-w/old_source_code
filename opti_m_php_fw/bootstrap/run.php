<?php

/**
 * Application bootstrapping code.
 *
 * @author Dominik Wlazlowski <dominik-w@dominik-w.pl> 2010
 * @version 1.0
 */

/**
 * Autoload gear
 * 
 * @param string $class_name
 */
function __autoload($class_name)
{
  $filename = $class_name . '.class.php';

  // application's key classes
  $file_app = _APP_PATH . '/lib/appcore/' . $filename;

  // additional libraries
  $file_main = _APP_PATH . '/lib/' . $filename;

  // model classes
  $file_model = _APP_PATH . '/lib/model/' . $filename;
  
  // $file_vendor = _APP_PATH . '/lib/vendor/' . $filename;
  
  if (file_exists($file_app))
  {
    include_once($file_app);
  }
  else if (file_exists($file_main))
  {
    include_once($file_main);
  }
  else if (file_exists($file_model))
  {
    include_once($file_model);
  }
  else
  {
    return false;
  }
}

/**
 * Create registry instance
 */
$registry = new CoreRegistry();

/**
 * Get database handler if needed
 */
// $registry->db = DB::getInstance();
