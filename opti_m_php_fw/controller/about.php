<?php

/**
 * Controller for 'about' page actions and contact form actions.
 *
 * @author Dominik Wlazlowski <dominik-w@dominik-w.pl> 2010
 * @version 1.0
 */
class aboutController extends BaseController
{
  /**
   * Index action
   * 
   * @return void
   */
  public function index()
  {
    $page_title = 'About';
    $this->registry->view->page_title = $page_title;

    // call the template
    $this->registry->view->assemblyDelegator('about_index', $page_title);
    // $this->registry->view->assembleMobile('about_index'); // tmp way
  }
  
  /**
   * Form action
   *
   * @return void
   */
  public function form()
  {
    $page_title = 'Contact form';
    $this->registry->view->page_title = $page_title;

    // process the form
    if ($_SERVER["REQUEST_METHOD"] == "POST")
    {
      // for pre-fill of the form
      $tmp_login = $_POST['login'];
      $this->registry->view->tmp_login = $tmp_login;

      $tmp_email = $_POST['email'];
      $this->registry->view->tmp_email = $tmp_email;

      // validation
      if (strlen($_POST['login']) == 0 || strlen($_POST['email']) == 0 ||
          strlen($_POST['body']) == 0)
      {
        $msg_body = 'Please fill whole form';
        $this->registry->view->msg_body = $msg_body;
      }
      else if (filter_var($_POST['email'], FILTER_VALIDATE_EMAIL) == false)
      {
        $msg_email = 'Please enter a valid e-mail';
        $this->registry->view->msg_email = $msg_email;
      }
      else
      {
        $login = filter_var($_POST['login'], FILTER_SANITIZE_STRING);
        $email = filter_var($_POST['email'], FILTER_SANITIZE_STRING);
        $body  = filter_var($_POST['body'], FILTER_SANITIZE_STRING);

        $c = new ContactModel();
        $result = $c->saveContactMessage($login, $email, $body);

        $this->registry->view->status = $result;
        $this->registry->view->assemblyDelegator('about_formDone', $page_title);

        return true;
      }
    }
    
    // call the template
    $this->registry->view->assemblyDelegator('about_form', $page_title);
  }

}
