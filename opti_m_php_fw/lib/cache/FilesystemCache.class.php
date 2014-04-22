<?php

/**
 * FilesystemCache class. A class for using temporary files for caching.
 *
 * @package    develop
 * @subpackage cache_subsystem
 * @author     Dominik Wlazlowski <dominik-w@dominik-w.pl> 2010
 * @version    1.0
 */
class FilesystemCache extends Cache
{
  /**
   * A constructor.
   */
  public function __construct()
  {
    $this->tmp_dir = "/var/cache/" .  md5(__FILE__);

    if (!is_dir($this->tmp_dir))
    {
      mkdir($this->tmp_dir);
    }

    $this->tmp_dir .= DIRECTORY_SEPARATOR;
  }
  
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
    $fp = $this->getFilesystemKey($key);
    
    // expiration write, add an exclusive lock to overwrite
    $expires = str_pad((int) $expires, 10, '0', STR_PAD_LEFT);
    $state = (bool) file_put_contents(
            $fp,
            $expires,
            FILE_EX
    );

    if ($state)
    {
      // append the serialized value to the file
      return (bool) file_put_contents(
              $fp,
              serialize($val),
              FILE_EX | FILE_APPEND
      );
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
    $fp = $this->getFilesystemKey($key);
    
    if (file_exists($fp) && $file = fopen($fp, 'r'))
    {
      $expires = (int) fread($file, 10);
      // if the expiration time exceeds the current time, return the cache
      if (!$expires || $expires > time())
      {
        $realsize = filesize($fp) - 10;
        $cache = '';
        
        while ($chunk = fread($file, $realsize))
        {
          $cache .= $chunk;
        }
        fclose($fp);

        return unserialize($cache);
      }
      else
      {
        // close and delete the expired cache
        fclose($fp);
        $this->deleteCache($key);
      }
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
    $fp = $this->getFilesystemKey($key);
    if (file_exists($fp))
    {
      return unlink($fp);
    }
    
    return true;
  }

  /**
   * Isolated method for keep the cache key generator in one place.
   * 
   * @param string $key
   * @return string
   */
  protected function getFilesystemKey($key)
  {
    return $this->tmp_dir . md5($key);
  }

}
