<?php

/**
 * Controller for 'test' actions. 
 *
 * @author Dominik Wlazlowski <dominik-w@dominik-w.pl> 2010
 * @version 1.0
 */
class testController extends BaseController
{
  /**
   * Index action
   *
   * @return void
   */
  public function index()
  {
    $config = Config::getInstance();

    $page_title = 'Testing';
    $this->registry->view->page_title = $page_title;

    // Tools::myLog('test');
    // $this->registry->view->test = Tools::generateRandomString(8);

    // mail test
    $rec_email = $config->getVal('application', 'root_email');
    $rec_name = 'DW';
    $topic = 'Test';
    $text = 'Test text';
    $html = '<html><head></head><body><p><b><u>Test html</u></b></p></body></html>';
    // $x = MailLayer::standardMail($rec_email, $rec_name, $topic, $text, $html);
    // var_dump($x);
    
    // $login = 'aaaa2';
    // $x = UserModel::checkLoginAvailability($login);
    // var_dump($x);

    // $email = 'aaa2@aaa.pl';
    // $x = UserModel::checkEmailAvailability($email);
    // var_dump($x);

    // $this->registry->view->test = $config->cfg['application']['root_email'];
    $this->registry->view->test = $config->getVal('application', 'root_email');
    
    // call the template
    $this->registry->view->assemblyDelegator('test_index', $page_title);
  }

}
