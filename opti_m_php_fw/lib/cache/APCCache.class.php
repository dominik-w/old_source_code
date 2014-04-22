<?php

/**
 * APCCache class. A class for APC extension.
 *
 * @package    develop
 * @subpackage cache_subsystem
 * @author     Dominik Wlazlowski <dominik-w@dominik-w.pl> 2010
 * @version    1.0
 */
class APCCache extends Cache
{
  /**
   * Set cache method implementation.
   * 
   * @param string $key
   * @param mixed $val
   * @param integer $expires
   * 
   * @return boolean
   */
  public function setCache($key, $val = null, $expires = null)
  {
    // APC takes a time to live flag rather than a timestamp for expiration
    if (isset($expires))
    {
      $expires = $expires - time();
    }
    
    return apc_store($key, $val, $expires);
  }

  /**
   * Get cache method implementation.
   * 
   * @param string $key
   * @return string
   */
  public function getCache($key)
  {
    return apc_fetch($key);
  }

  /**
   * Delete cache method implementation.
   * 
   * @param string $key
   * @return boolean
   */
  public function deleteCache($key)
  {
    return apc_delete($key);
  }

}
