<?php

/**
 * Kernel.class.php
 * Application kernel.
 *
 * @author  Dominik Wlazlowski <dominik-w@dominik-w.pl> 2010
 * @version 1.0
 */
class Kernel
{
  private $registry; // registry object
  private $controllerPath; // controller file path

  // controller engine properties
  public $filePath;
  public $controller;
  public $action;

  /**
   *
   * @param CoreRegistry $registry
   * @return void
   */
  public function __construct($registry)
  {
    $this->registry = $registry;
  }

  /**
   * Set controller directory path
   * 
   * @param string $path
   * @return void
   */
  public function setPath($path)
  {
    // $path must be a drectory path
    if (!is_dir($path))
    {
      throw new Exception('Invalid controller path: `' . $path . '`');
    }

    // set the path
    $this->controllerPath = $path;
  }
  
  /**
   * Set the current controller
   *
   * @return void
   */
  private function setController()
  {
    if (Config::getInstance()->getVal('application', 'url_separator'))
    {
      $separator = Config::getInstance()->getVal('application', 'url_separator');
    }
    else
    {
      $separator = '/';
    }

    // get the route from request
    $route = (empty($_GET['route'])) ? '' : $_GET['route'];

    if (!empty($route))
    {
      $slices = @explode($separator, $route);
      $this->controller = $slices[0];

      if (isset($slices[1]))
      {
        $this->action = $slices[1];
      }
    }
    else
    {
      // set default route if empty
      $route = 'index';
    }

    // set default controller if empty
    if (empty($this->controller))
    {
      $this->controller = 'index';
    }

    // action
    if (empty($this->action))
    {
      $this->action = 'index';
    }

    // set the file path
    $this->filePath = $this->controllerPath . '/' . $this->controller . '.php';
  }
  
  /**
   * Controller loader
   *
   * @return void
   */
  public function load()
  {
    $this->setController();

    // error 404 handler
    if (!is_readable($this->filePath))
    {
      $this->filePath = $this->controllerPath . '/error404.php';
      $this->controller = 'error404';
    }

    // controller inclusion
    include_once $this->filePath;

    // create a new controller class instance
    $class = $this->controller . 'Controller';
    $controllerObj = new $class($this->registry);

    // check if the action is callable
    if (is_callable(array($controllerObj, $this->action)))
    {
      $action = $this->action;
    }
    else
    {
      $action = 'index';
    }

    // action start
    $controllerObj->$action();
  }

}
