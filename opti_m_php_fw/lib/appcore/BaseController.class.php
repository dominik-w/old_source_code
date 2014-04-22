<?php

/**
 * BaseController.class.php
 * Abstract class for controller implementation.
 *
 * @author  Dominik Wlazlowski <dominik-w@dominik-w.pl> 2010
 * @version 1.0
 */
abstract class BaseController
{
  protected $registry; // registry object

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
   * Define index action. All controllers must contain that method implemented.
   */
  abstract function index();

}
