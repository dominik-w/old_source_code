<?php

/**
 * Controller for 'error404' action.
 *
 * @author Dominik Wlazlowski <dominik-w@dominik-w.pl> 2010
 * @version 1.0
 */
class error404Controller extends BaseController
{
  /**
   * Index action
   *
   * @return void
   */
  public function index()
  {
    $this->registry->view->page_title = '404';

    // call the template
    $this->registry->view->assemblyDelegator('error404');
  }

}
