<?php

/**
 * Security.class.php
 * A class with security tools.
 *
 * @author  Dominik Wlazlowski <dominik-w@dominik-w.pl> 2010
 * @version 0.3.2
 */
class Security
{
  /**
   * Password encryption
   * 
   * @param string $password
   * @return string
   */
  public static function passwordEncrypt($password)
  {
    $salt = Config::getInstance()->getVal('security', 'salt');
    $sec_pass = md5($password . $salt);
    
    return $sec_pass;
  }

  /**
   * Mail hash encryption
   *
   * @param string $email
   * @return string
   */
  public static function mailHashEncrypt($email)
  {
    $salt = Config::getInstance()->getVal('security', 'salt_re');
    $hash = md5($salt . $email);
    
    return $hash;
  }
  
  /**
   * Simple hash code generator
   * 
   * @param integer $length
   * @return string 
   */
  public static function getHashCode($length = 12)
  {
    return substr(md5(rand()) , 0, $length);
  }
  
}
