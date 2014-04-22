<?php

/**
 * Memcache class. A class for memcache extension.
 *
 * @package    develop
 * @subpackage cache_subsystem
 * @author     Dominik Wlazlowski <dominik-w@dominik-w.pl> 2010
 * @version    1.0
 */
class memcacheCache extends Cache
{
  protected $memcache; // instance
  
  /**
   * A constructor.
   */
  public function __construct()
  {
    // define one server: localhost
    $this->memcache = new Memcache();
    $this->memcache->pconnect('127.0.0.1', 11211);
  }

  /**
   * Set cache method implementation.
   * 
   * @param string $key
   * @param mixed  $val
   * @param integer $expires
   * 
   * @return boolean
   */
  public function setCache($key, $val = null, $expires = null)
  {
    return $this->memcache->set($key, $val, null, $expires);
  }

  /**
   * Get cache method implementation.
   * 
   * @param string $key
   * @return string
   */
  public function getCache($key)
  {
    return $this->memcache->get($key);
  }

  /**
   * Delete cache method implementation.
   * 
   * @param string $key
   * @return boolean
   */
  public function deleteCache($key)
  {
    return $this->memcache->delete($key);
  }
  
}
