<?php

/**
 * DB.class.php
 * Database connection implemented as a singleton.
 *
 * @author  Dominik Wlazlowski <dominik-w@dominik-w.pl> 2010 - 2012
 * @version 1.1
 */
class DB
{
  // object instance
  private static $instance = null;

  /**
   * The constructor with private access for prevent creating of a new instance
   * using new operator
   *
   * @return void
   */
  private function __construct()
  {
  }

  /**
   * Returns DB instance if exists or creates initial connection
   *
   * @return DB
   */
  public static function getInstance()
  {
    if (is_null(self::$instance))
    {
      $cfg = Config::getInstance();

      $db_type = $cfg->getVal('database', 'db_type');
      $db_name = $cfg->getVal('database', 'db_name');
      $db_host = $cfg->getVal('database', 'db_hostname');
      $db_user = $cfg->getVal('database', 'db_username');
      $db_pass = $cfg->getVal('database', 'db_password');
      $db_port = $cfg->getVal('database', 'db_port');
      
      try
      {
        self::$instance = new PDO("{$db_type}:host={$db_host};dbname={$db_name}", $db_user, $db_pass);
        self::$instance->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
      }
      catch (PDOException $e)
      {
        echo "Some problem with Server or Database occured. Please try again later.";
        exit;
      }
    }
    
    return self::$instance;
  }
  
  /**
   * Don't clone a singleton
   */
  private function __clone() {}

}
