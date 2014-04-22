<?php

/**
 * Controller for 'user' actions.
 *
 * @author Dominik Wlazlowski <dominik-w@dominik-w.pl> 2010
 * @version 0.9
 */
class userController extends BaseController
{
  /**
   * Index action
   *
   * @return void
   */
  public function index()
  {
    $page_title = 'User account';
    $this->registry->view->page_title = $page_title;
    
    if (isset($_SESSION['user_id']))
    {
      // $msg = 'User is already logged in';
      $this->registry->view->assemblyDelegator('user_index', $page_title);
      
      return true;
    }

    // call the template
    $this->registry->view->assemblyDelegator('user_login', 'Login page');
  }

  /**
   * Register action
   *
   * @return void
   */
  public function register()
  {
    $page_title = 'User register';
    $this->registry->view->page_title = $page_title;
    
    // set a form token
    if (!isset($_SESSION['form_token']))
    {
      $form_token = md5(uniqid('register', true));
      $_SESSION['form_token'] = $form_token;
    }
    else
    {
      $form_token = $_SESSION['form_token'];
    }

    $this->registry->view->form_token = $form_token;

    // process the form
    if ($_SERVER["REQUEST_METHOD"] == "POST")
    {
      // for pre-fill of the form
      $tmp_login = $_POST['login'];
      $this->registry->view->tmp_login = $tmp_login;
      
      $tmp_email = $_POST['email'];
      $this->registry->view->tmp_email = $tmp_email;

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
      else if (ctype_alnum($_POST['login']) != true)
      {
        $msg_login = 'Login must be alpha numeric';
        $this->registry->view->msg_login = $msg_login;
      }
      else if (UserModel::checkLoginAvailability($_POST['login']) == false)
      {
        $msg_login = 'Login already exists';
        $this->registry->view->msg_login = $msg_login;
      }
      else if (!isset($_POST['email']))
      {
        $msg_email = 'Please enter a valid e-mail';
        $this->registry->view->msg_email = $msg_email;
      }
      else if (filter_var($_POST['email'], FILTER_VALIDATE_EMAIL) == false)
      {
        $msg_email = 'Please enter a valid e-mail';
        $this->registry->view->msg_email = $msg_email;
      }
      else if (UserModel::checkEmailAvailability($_POST['email']) == false)
      {
        $msg_email = 'E-mail already exists';
        $this->registry->view->msg_email = $msg_email;
      }
      else if (!isset($_POST['password'], $_POST['password_re'])
               || $_POST['password'] != $_POST['password_re'])
      {
        $msg_password_re = 'Please enter a valid passwords';
        $this->registry->view->msg_password_re = $msg_password_re;
      }
      else if (strlen($_POST['password']) > 32 || strlen($_POST['password']) < 4)
      {
        $msg_password_re = 'Incorrect length for Password';
        $this->registry->view->msg_password_re = $msg_password_re;
      }
      else if ($_POST['form_token'] != $_SESSION['form_token'])
      {
        $msg_login = 'CSRF attempt detected!';
        $this->registry->view->msg_login = $msg_login;
      }
      else
      {
        // all data correct and we can finish the process
        $login    = filter_var($_POST['login'], FILTER_SANITIZE_STRING);
        $password = filter_var($_POST['password'], FILTER_SANITIZE_STRING);
        $email    = filter_var($_POST['email'], FILTER_SANITIZE_STRING);
        $first    = filter_var($_POST['firstname'], FILTER_SANITIZE_STRING);
        $last     = filter_var($_POST['lastname'], FILTER_SANITIZE_STRING);
        
        $sec_pass = Security::passwordEncrypt($password);
        $hash = Security::mailHashEncrypt($email);

        $user = new UserModel();
        $result = $user->userRegister($login, $sec_pass, $email, $first, $last, $hash);

        $this->registry->view->status = $result;

        // after process remove form token from session
        unset($_SESSION['form_token']);

        // call the template
        $this->registry->view->assemblyDelegator('user_registerDone', $page_title);

        return true;
      }
    }

    // call the template
    $this->registry->view->assemblyDelegator('user_register', $page_title);
  }

  /**
   * Login action
   *
   * @return void
   */
  public function login()
  {
    $page_title = 'Login page';
    $this->registry->view->page_title = $page_title;
    
    if (isset($_SESSION['user_id']))
    {
      // $msg = 'Users is already logged in';
      $this->registry->view->assemblyDelegator('user_index', 'Your account');
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
        // all data correct and we can finish the process
        $login    = filter_var($_POST['login'], FILTER_SANITIZE_STRING);
        $password = filter_var($_POST['password'], FILTER_SANITIZE_STRING);
        
        $result = UserModel::userAuth($login, $password);

        $this->registry->view->status = $result;

        // call the template
        if ($result == true)
        {
          $this->registry->view->assemblyDelegator('user_index', 'User account');
        }
        else
        {
          $this->registry->view->assemblyDelegator('user_login', $page_title);
        }

        return true;
      }
    }

    // call the template
    $this->registry->view->assemblyDelegator('user_login', $page_title);
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
    }

    if (isset($_SESSION['is_admin']))
    {
      unset($_SESSION['is_admin']);
    }

    // redirect
    header("Location: /index.php");
    
    ob_end_flush();
  }

  /**
   * Edit account action
   *
   * @return void
   */
  public function edit()
  {
    $page_title = 'Edit account';
    $this->registry->view->page_title = $page_title;

    if (!isset($_SESSION['user_id']))
    {
      $this->registry->view->assemblyDelegator('user_login', 'Login page');

      return true;
    }

    $user_id = $_SESSION['user_id'];

    // process the form
    if ($_SERVER["REQUEST_METHOD"] == "POST")
    {
      $firstname = filter_var($_POST['firstname'], FILTER_SANITIZE_STRING);
      $lastname = filter_var($_POST['lastname'], FILTER_SANITIZE_STRING);
      
      $result = UserModel::updateUserData($user_id, $firstname, $lastname);
      $this->registry->view->status = $result;
      
      // call the template
      if ($result == true)
      {
        $this->registry->view->assemblyDelegator('user_index', 'User account');

        return true;
      }
    }

    $user_data = UserModel::getUserData($user_id);
    $this->registry->view->user_firstname = '';
    $this->registry->view->user_lastname = '';

    if (count($user_data))
    {
      $this->registry->view->user_firstname = $user_data['firstname'];
      $this->registry->view->user_lastname = $user_data['lastname'];
    }

    // call the template
    $this->registry->view->assemblyDelegator('user_edit', $page_title);
  }

  /**
   * Edit password action
   *
   * @return void
   */
  public function editPassword()
  {
    $page_title = 'Edit password';
    $this->registry->view->page_title = $page_title;

    if (!isset($_SESSION['user_id']))
    {
      $this->registry->view->assemblyDelegator('user_login', 'Login page');

      return true;
    }

    $user_id = $_SESSION['user_id'];

    // process the form
    if ($_SERVER["REQUEST_METHOD"] == "POST")
    {
      // validation
      if (strlen($_POST['old_pass']) == 0 || strlen($_POST['new_pass']) == 0 ||
          strlen($_POST['new_pass_re']) == 0)
      {
        $msg_password = 'Please fill whole form';
        $this->registry->view->msg_password = $msg_password;
      }
      else if (UserModel::checkUserPassword($user_id, $_POST['old_pass']) == false)
      {
        $msg_password = 'Old password is incorrect';
        $this->registry->view->msg_password_old = $msg_password;
      }
      else if ($_POST['new_pass'] != $_POST['new_pass_re'])
      {
        $msg_password = 'Passwords are not the same';
        $this->registry->view->msg_password = $msg_password;
      }
      else if (strlen($_POST['new_pass']) > 32 || strlen($_POST['new_pass']) < 4)
      {
        $msg_password = 'Incorrect length for Password';
        $this->registry->view->msg_password = $msg_password;
      }
      else
      {
        // $old_pass = filter_var($_POST['old_pass'], FILTER_SANITIZE_STRING);
        $new_pass = filter_var($_POST['new_pass'], FILTER_SANITIZE_STRING);

        $result = UserModel::updateUserPassword($user_id, $new_pass);
        $this->registry->view->status = $result;

        // call the template
        if ($result == true)
        {
          $this->registry->view->assemblyDelegator('user_index', 'User account');
          
          return true;
        }
      }
    }

    // call the template
    $this->registry->view->assemblyDelegator('user_editPassword', $page_title);
  }
  
}
