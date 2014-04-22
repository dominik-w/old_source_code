<?php

/**
 * Controller for 'index' action - the default action of application.
 *
 * @author Dominik Wlazlowski <dominik-w@dominik-w.pl> 2010
 * @version 1.0
 */
class indexController extends BaseController
{
  /**
   * Index action
   *
   * @return void
   */
  public function index()
  {
    $page_title = 'Welcome to Opti_M Framework';
    $this->registry->view->page_title = $page_title;

    // handle switching between mobile and standard version of the page
    if (isset($_GET['m']))
    {
      if ($_GET['m'] == 1)
      {
        $_SESSION['mobile_mode'] = true;
      }
      else if ($_GET['m'] == 0)
      {
        $_SESSION['mobile_mode'] = false;
      }
    }

    // call the template
    $this->registry->view->assemblyDelegator('index');
  }

}
