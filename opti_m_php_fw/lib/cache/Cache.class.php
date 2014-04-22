<?php

/**
 * Cache class.
 *
 * @package    develop
 * @subpackage cache_subsystem
 * @author     Dominik Wlazlowski <dominik-w@dominik-w.pl> 2010
 * @version    1.0
 */
abstract class Cache {
  abstract public function setCache($key, $val = null, $expires = null);
  abstract public function getCache($key);
  abstract public function deleteCache($key);
}
