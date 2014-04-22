<?php

/**
 * ShmopCache class. A class for the shared memory operations extension for PHP.
 * Serialization and expiration of data implemented.
 *
 * @package    develop
 * @subpackage cache_subsystem
 * @author     Dominik Wlazlowski <dominik-w@dominik-w.pl> 2010
 * @version    1.0
 */
class ShmopCache extends Cache
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
    // remove block if already exists
    $this->deleteCache($key);
    // create new block
    $shmop_key = $this->shmopKey($key);
    // new serialized value
    $shmop_val = serialize($val);
    // + 10 for expiration
    $shmop_size = strlen($shmop_val) + 10;

    if ($block = shmop_open($shmop_key, 'n', 0600, $shmop_size))
    {
      $expires = str_pad((int) $expires, 10, '0', STR_PAD_LEFT);
      $written = shmop_write($block, $expires, 0) && shmop_write($block, $shmop_val, 10);
      shmop_close($block);

      return $written;
    }
    
    return false;
  }

  /**
   * Get cache method implementation.
   * 
   * @param string $key
   * @return mixed
   */
  public function getCache($key)
  {
    $shmop_key = $this->shmopKey($key);
    
    if ($block = shmop_open($shmop_key, 'a'))
    {
      $expires = (int) shmop_read($block, 0, 10);
      $cache = false;

      // if the expiration time exceeds the current time, return the cache
      if (!$expires || $expires > time())
      {
        $realsize = shmop_size($block) - 10;
        $cache = unserialize(
                shmop_read(
                        $block,
                        10,
                        $realsize
                )
        );
      }
      else
      {
        // close and delete the expired cache
        shmop_delete($block);
      }
      
      shmop_close($block);

      return $cache;
    }
    
    return false;
  }

  /**
   * Delete cache method implementation.
   * 
   * @param string $key
   * @return boolean
   */
  public function deleteCache($key)
  {
    $shmop_key = $this->shmopKey($key);

    if ($block = shmop_open($shmop_key, 'w'))
    {
      $deleted = shmop_delete($block);
      shmop_close($block);

      return $deleted;
    }
    else
    {
      return true;
    }
  }

  /**
   * Isolated method for keeping the cache key generator in one place.
   *
   * @param string $key
   * @return integer
   */
  protected function shmopKey($key)
  {
    return crc32($key);
  }

}
