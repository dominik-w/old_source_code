<?php

/**
 * View.class.php
 * View layer.
 *
 * @author  Dominik Wlazlowski <dominik-w@dominik-w.pl> 2010
 * @version 1.0
 */
class View
{
  private $registry; // registry object
  private $variables = array(); // variables for template

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
   * Variable setter
   *
   * @param string $index
   * @param mixed $value
   *
   * @return void
   */
  public function __set($index, $value)
  {
    $this->variables[$index] = $value;
  }

  /**
   * Assemble the ready to display, standard version of a template.
   * 
   * @param string $name
   * @param string $page_title
   * 
   * @return mixed
   */
  public function assemble($name, $page_title = '')
  {
    if (strlen($page_title) == 0)
    {
      $page_title = Config::getInstance()->getVal('application', 'app_name');
    }
    
    $std_elements_path = _APP_PATH . '/view';

    /* inclusion of standard page components */
    # include_once($std_elements_path . '/header.php'); // for static Title

    // for dynamic Title
    $head = self::getIncludeContents($std_elements_path . '/header.php');
    echo $head = str_replace('{$title}', $page_title, $head); // output here

    // if we want menu defined in separated file
    /*
    $menu_file = $std_elements_path . '/menu.php';
    if (file_exists($menu_file) && filesize($menu_file) > 0)
    {
      include($menu_file);
    }*/
    
    $path = $std_elements_path . '/templates/' . $name . '.php';

    if (!file_exists($path))
    {
      throw new Exception('Template file not found in ' . $path);
      return false;
    }
    
    // variables loader
    foreach ($this->variables as $key => $value)
    {
      // build a variable using PHP dynamic variables mechanism
      // http://php.net/manual/en/language.variables.variable.php
      $$key = $value;
    }

    // include the template
    include_once($path);

    // inclusion of standard page components: footer
    include_once($std_elements_path . '/footer.php');
  }

  /**
   * Assemble the ready to display, mobile version of a template.
   *
   * @param string $name
   * @param string $page_title
   * 
   * @return mixed
   */
  public function assembleMobile($name, $page_title = '')
  {
    if (strlen($page_title) == 0)
    {
      $page_title = Config::getInstance()->getVal('application', 'app_name');
    }

    $mobile_elements_path = _APP_PATH . '/view';
    
    /* inclusion of standard page components */
    # include_once($mobile_elements_path . '/header_mobile.php'); // for static Title

    // for dynamic Title
    $head = self::getIncludeContents($mobile_elements_path . '/header_mobile.php');
    echo $head = str_replace('{$title}', $page_title, $head); // output here

    // if we want menu defined in separated file
    /*
    $menu_file = $mobile_elements_path . '/menu_mobile.php';
    if (file_exists($menu_file) && filesize($menu_file) > 0)
    {
      include($menu_file);
    }*/

    $path = $mobile_elements_path . '/templates/mobile/' . $name . '.php';

    if (!file_exists($path))
    {
      throw new Exception('Template file not found in ' . $path);
      return false;
    }

    // variables loader
    foreach ($this->variables as $key => $value)
    {
      // build a variable using PHP dynamic variables mechanism
      // http://php.net/manual/en/language.variables.variable.php
      $$key = $value;
    }

    // include the template
    include_once($path);

    // inclusion of standard page components: footer
    include_once($mobile_elements_path . '/footer_mobile.php');
  }

  /**
   * Assembly delegator. Determines which version of template (standard or mobile)
   * should be loaded.
   *
   * @param string $name
   * @param string $page_title
   *
   * @return void
   */
  public function assemblyDelegator($name, $page_title = '')
  {
    $is_mobile = false;
    
    if (isset($_SESSION['mobile_mode']))
    {
      if ($_SESSION['mobile_mode'] == true)
      {
        $is_mobile = true;
      }
      else
      {
        $is_mobile = false;
      }
    }
    else
    {
      // get default
      $is_mobile = Config::getInstance()->getVal('application', 'mobile_web_mode');
    }

    if ($is_mobile == true)
    {
      // Tools::myLog('Mobile');
      $this->assembleMobile($name, $page_title);
    }
    else
    {
      // Tools::myLog('STD');
      $this->assemble($name, $page_title);
    }
  }

  /**
   * Gets file content to process by frist.
   * 
   * @param string $filename
   * @return mixed
   */
  public static function getIncludeContents($filename)
  {
    if (is_file($filename))
    {
      ob_start();
      include $filename;
      $contents = ob_get_contents();
      ob_end_clean();

      return $contents;
    }
    
    return false;
  }

  /**
   * Assemble the ready to display, standard version of a template for backend.
   *
   * @param string $name
   * @param string $page_title
   *
   * @return mixed
   */
  public function assembleForBackend($name, $page_title = '')
  {
    $std_elements_path = _APP_PATH . '/view/templates/admin/';

    /* inclusion of standard page components */
    include_once($std_elements_path . '/header.php');

    // if we want menu defined in separated file
    /*
    $menu_file = $std_elements_path . '/menu.php';
    if (file_exists($menu_file) && filesize($menu_file) > 0)
    {
      include($menu_file);
    }*/

    $path = $std_elements_path . $name . '.php';

    if (!file_exists($path))
    {
      throw new Exception('Template file not found in ' . $path);
      return false;
    }

    // variables loader
    foreach ($this->variables as $key => $value)
    {
      // build a variable using PHP dynamic variables mechanism
      // http://php.net/manual/en/language.variables.variable.php
      $$key = $value;
    }

    // include the template
    include_once($path);

    // inclusion of standard page components: footer
    include_once($std_elements_path . '/footer.php');
  }
  
}
