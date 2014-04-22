<?php

/**
 * CoreRegistry.class.php
 * Implementation of a registry. The main purpose is passing variables to core classes.
 *
 * @author  Dominik Wlazlowski <dominik-w@dominik-w.pl> 2010
 * @version 1.0
 */
class CoreRegistry
{
  private $storage = array(); // variables storage

  /**
   * Variable setter
   *
   * @param string $index
   * @param mixed $value
   *
   * @return void
   */
  public function __set($index, $value)
  {
    $this->storage[$index] = $value;
  }

  /**
   * Variable getter
   *
   * @param string $index
   * @return mixed
   */
  public function __get($index)
  {
    return $this->storage[$index];
  }

}
