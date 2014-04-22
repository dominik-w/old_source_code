<?php

/**
 * Controller for backend / administration.
 *
 * @author Dominik Wlazlowski <dominik-w@dominik-w.pl> 2010
 * @version 1.0
 */
class backendController extends BaseController
{
  /**
   * Index action
   * 
   * @return void
   */
  public function index()
  {
    $page_title = 'Admin Panel';
    $this->registry->view->page_title = $page_title;
    
    if (!isset($_SESSION['is_admin']) || $_SESSION['is_admin'] == false)
    {
      $this->registry->view->assembleForBackend('backend_login', $page_title);

      return true;
    }

    // call the template
    $this->registry->view->assembleForBackend('backend_index', $page_title);
  }
  
  /**
   * Login action
   *
   * @return void
   */
  public function login()
  {
    $page_title = 'Login to backend';
    $this->registry->view->page_title = $page_title;

    if (isset($_SESSION['user_id']) && isset($_SESSION['is_admin']) && $_SESSION['is_admin'] == true)
    {
      $this->registry->view->assembleForBackend('backend_index', $page_title);
      
      return true;
    }

    // process the form
    if ($_SERVER["REQUEST_METHOD"] == "POST")
    {
      // validation
      if (!isset($_POST['login']))
      {
        $msg_login = 'Please enter a valid login';
        $this->registry->view->msg_login = $msg_login;
      }
      else if (strlen($_POST['login']) > 32 || strlen($_POST['login']) < 3)
      {
        $msg_login = 'Incorrect length for Login';
        $this->registry->view->msg_login = $msg_login;
      }
      else if (!isset($_POST['password']))
      {
        $msg_password = 'Please enter a password';
        $this->registry->view->msg_password_re = $msg_password;
      }
      else
      {
        // data correct and we can finish the process
        $login    = filter_var($_POST['login'], FILTER_SANITIZE_STRING);
        $password = filter_var($_POST['password'], FILTER_SANITIZE_STRING);

        $result = UserModel::adminAuth($login, $password);

        $this->registry->view->status = $result;

        // call the template
        if ($result == true)
        {
          $this->registry->view->assembleForBackend('backend_index', 'Admin panel');
        }
        else
        {
          $this->registry->view->assembleForBackend('backend_login', $page_title);
        }

        return true;
      }
    }
    
    $this->registry->view->assembleForBackend('backend_login', $page_title);
  }

  /**
   * Logout action
   *
   * @return void
   */
  public function logout()
  {
    ob_start();

    if (isset($_SESSION['user_id']))
    {
      unset($_SESSION['user_id']);
      unset($_SESSION['user_name']);
      unset($_SESSION['is_admin']);
    }

    // redirect
    header("Location: /backend/index");

    ob_end_flush();
  }

 /**
   * Contact action
   *
   * @return void
   */
  public function contact()
  {
    $page_title = 'Browse contact messages';
    $this->registry->view->page_title = $page_title;

    if (!isset($_SESSION['is_admin']) || $_SESSION['is_admin'] == false)
    {
      $this->registry->view->assembleForBackend('backend_login', $page_title);

      return true;
    }

    $results = ContactModel::getContactMessages();
    $this->registry->view->results = $results;

    // call the template
    $this->registry->view->assembleForBackend('backend_contact', $page_title);
  }

  /**
   * Edit contact message action
   *
   * @return void
   */
  public function contactEdit()
  {
    $page_title = 'Edit contact message';
    $this->registry->view->page_title = $page_title;

    if (!isset($_SESSION['is_admin']) || $_SESSION['is_admin'] == false)
    {
      $this->registry->view->assembleForBackend('backend_login', $page_title);

      return true;
    }

    // process the form
    if ($_SERVER["REQUEST_METHOD"] == "POST")
    {
      $id = $_POST['id'];
      $is_read = isset($_POST['is_read']);
      $body = filter_var($_POST['body'], FILTER_SANITIZE_STRING);

      $result = ContactModel::updateMessage($id, $is_read, $body);
      $this->registry->view->status = $result;
      
      if ($result == true)
      {
        $this->registry->view->status = 'Changes saved.';
      }
      else
      {
        $this->registry->view->status = 'An error occured.';
      }
      
      $this->registry->view->id = $id;
      $this->registry->view->is_read = $is_read;
      $this->registry->view->body = $body;
    }
    else if (isset($_GET['id']))
    {
      $id = $_GET['id'];
      $message = ContactModel::getMessageData($id);

      if ($message['id'] > 0)
      {
        $this->registry->view->id = $id;
        $this->registry->view->is_read = $message['is_read'];
        $this->registry->view->body = $message['message'];
      }
      else
      {
        $this->registry->view->status = 'Incorrect message ID.';
      }
    }

    // call the template
    $this->registry->view->assembleForBackend('backend_contactEdit', $page_title);
  }

  /**
   * Delete contact message action
   *
   * @return void
   */
  public function contactDelete()
  {
    if (!isset($_SESSION['is_admin']) || $_SESSION['is_admin'] == false)
    {
      $this->registry->view->assembleForBackend('backend_login', $page_title);

      return true;
    }
    
    if (isset($_GET['id']))
    {
      $id = $_GET['id'];

      $status = ContactModel::deleteMessage($id);
    }

    header("Location: /backend/contact");
  }

}
