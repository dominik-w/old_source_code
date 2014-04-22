<?php

/**
 * Config.class.php
 * Configuration class implemented as a singleton.
 *
 * @author  Dominik Wlazlowski <dominik-w@dominik-w.pl> 2010
 * @version 1.0
 */
class Config
{
  // define configuration file
  private static $configFile = '/bootstrap/config.ini';

  // object instance
  private static $instance = null;

  // config values
  public $cfg = array();
  
  /**
   * The constructor with private access for prevent creating of a new instance
   * using new operator
   *
   * @return void
   */
  private function __construct()
  {
    $this->cfg = parse_ini_file(_APP_PATH . self::$configFile, true);
  }
  
  /**
   * Returns Config instance if exists or creates new
   * 
   * @return Config
   */
  public static function getInstance()
  {
    if (is_null(self::$instance))
    {
      self::$instance = new Config();
    }
    
    return self::$instance;
  }
  
  /**
   * Gets a config value by key
   *
   * @param string $block
   * @param string $key
   *
   * @return string
   */
  public function getVal($block, $key)
  {
    return $this->cfg[$block][$key];
  }

  /**
   * Don't clone a singleton
   */
  private function __clone() {}

}
