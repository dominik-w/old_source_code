<?php

/**
 * UserModel.class.php
 *
 * @author  Dominik Wlazlowski <dominik-w@dominik-w.pl> 2010
 * @version 1.0
 */
class UserModel
{
  /**
   * Checking availability of username
   * 
   * @param string $login
   * @return boolean
   */
  public static function checkLoginAvailability($login)
  {
    $dbh = DB::getInstance();
    $fx = DB_PREFIX;

    $login = filter_var($login, FILTER_SANITIZE_STRING);

    $q = "SELECT COUNT(id) AS cnt FROM `{$fx}users` WHERE `login` = '{$login}'";
    $stmt = $dbh->query($q);
    $result = $stmt->fetch();

    if ($result['cnt'] > 0)
    {
      return false;
    }

    return true;
  }

  /**
   * Checking availability of email
   *
   * @param string $login
   * @return boolean
   */
  public static function checkEmailAvailability($email)
  {
    $dbh = DB::getInstance();
    $fx = DB_PREFIX;

    $email = filter_var($email, FILTER_SANITIZE_STRING);

    $q = "SELECT COUNT(id) AS cnt FROM `{$fx}users` WHERE `email` = '{$email}'";
    $stmt = $dbh->query($q);
    $result = $stmt->fetch();

    if ($result['cnt'] > 0)
    {
      return false;
    }

    return true;
  }

  /**
   * Checking if password is correct for the user
   *
   * @param integer $user_id
   * @param string $password
   *
   * @return boolean
   */
  public static function checkUserPassword($user_id, $password)
  {
    $dbh = DB::getInstance();
    $fx = DB_PREFIX;

    $password = filter_var($password, FILTER_SANITIZE_STRING);
    $sec_pass = Security::passwordEncrypt($password);

    $q = "SELECT COUNT(id) AS cnt FROM `{$fx}users` WHERE `id` = '{$user_id}' AND
          password = '{$sec_pass}'";
    $stmt = $dbh->query($q);
    $result = $stmt->fetch();

    if ($result['cnt'] > 0)
    {
      return true;
    }

    return false;
  }
  
  /**
   * Registration of new user
   * 
   * @param string $login
   * @param string $password
   * @param string $email
   * @param string $firstname
   * @param string $lastname
   * @param string $hash
   * 
   * @return boolean
   */
  public function userRegister($login, $password, $email, $firstname, $lastname, $hash)
  {
    $dbh = DB::getInstance();
    $fx = DB_PREFIX;

    $ip = $_SERVER['REMOTE_ADDR'];
    $now = @date('Y-m-d G:i:s');
    $active = true;

    $status = false;

    try
    {
      // prepare statement and bind parameters
      $q = "INSERT INTO
             {$fx}users (email, login, password, mail_hash, is_active, last_ip, created_at, updated_at)
           VALUES
             (:email, :login, :password, :mail_hash, :is_active, :last_ip, :created_at, :updated_at)";

      $stmt = $dbh->prepare($q);
      
      $stmt->bindParam(':email', $email, PDO::PARAM_STR);
      $stmt->bindParam(':login', $login, PDO::PARAM_STR);
      $stmt->bindParam(':password', $password, PDO::PARAM_STR, 32);
      $stmt->bindParam(':mail_hash', $hash, PDO::PARAM_STR, 32);
      $stmt->bindParam(':is_active', $active, PDO::PARAM_BOOL);
      $stmt->bindParam(':last_ip', $ip, PDO::PARAM_STR);
      $stmt->bindParam(':created_at', $now, PDO::PARAM_STR);
      $stmt->bindParam(':updated_at', $now, PDO::PARAM_STR);
      
      $stmt->execute();

      // create user's profile
      $user_id = $dbh->lastInsertId();
      
      $q2 = "INSERT INTO
               {$fx}user_profiles (user_id, firstname, lastname, updated_at)
             VALUES
               (:user_id, :firstname, :lastname, :updated_at)";

      $stmt2 = $dbh->prepare($q2);

      $stmt2->bindParam(':user_id', $user_id, PDO::PARAM_INT);
      $stmt2->bindParam(':firstname', $firstname, PDO::PARAM_STR);
      $stmt2->bindParam(':lastname', $lastname, PDO::PARAM_STR);
      $stmt2->bindParam(':updated_at', $now, PDO::PARAM_STR);

      $stmt2->execute();
      
      $status = true;
    }
    catch (Exception $e)
    {
      /* if ($e->getCode() == 23000) { $status = 'Username already exists.'; } */
      $status = false;
    }

    return $status;
  }

  /**
   * User authentication process
   * 
   * @param string $login
   * @param string $password
   *
   * @return boolean
   */
  public static function userAuth($login, $password)
  {
    $dbh = DB::getInstance();
    $fx = DB_PREFIX;

    $sec_pass = Security::passwordEncrypt($password);

    $status = false;

    try
    {
      $q = "SELECT
              id, login, password FROM {$fx}users
            WHERE
              login = :login AND password = :password";
              
      $stmt = $dbh->prepare($q);
      
      $stmt->bindParam(':login', $login, PDO::PARAM_STR);
      $stmt->bindParam(':password', $sec_pass, PDO::PARAM_STR, 32);
      
      $stmt->execute();

      $user_id = $stmt->fetchColumn();
      
      if (!$user_id)
      {
        $status = false;
      }
      else
      {
        $_SESSION['user_id'] = $user_id;
        $_SESSION['user_name'] = $login;
        
        $status = true;
      }
    }
    catch (Exception $e)
    {
      $status = false;
    }

    return $status;
  }
  
  /**
   * Get user's profile data
   *
   * @param integer $user_id
   * @return array
   */
  public static function getUserData($user_id)
  {
    $dbh = DB::getInstance();
    $fx = DB_PREFIX;
    
    $result = array();

    try
    {
      $q = "SELECT firstname, lastname FROM {$fx}user_profiles WHERE user_id = :user_id LIMIT 1";
      $stmt = $dbh->prepare($q);
      
      $stmt->bindParam(':user_id', $user_id, PDO::PARAM_INT);
      $stmt->execute();
      $result = $stmt->fetch(PDO::FETCH_ASSOC);
    }
    catch (Exception $e)
    {
      $result = null;
    }

    return $result;
  }
  
  /**
   * Update user's profile data
   *
   * @param integer $user_id
   * @param string $firstname
   * @param string $lastname
   *
   * @return boolean
   */
  public static function updateUserData($user_id, $firstname, $lastname)
  {
    $dbh = DB::getInstance();
    $fx = DB_PREFIX;

    $status = false;

    try
    {
      // prepare statement and bind parameters
      $q = "UPDATE {$fx}user_profiles SET firstname=?, lastname=?, updated_at=NOW() WHERE user_id=?";
      $stmt = $dbh->prepare($q);
      $stmt->execute(array($firstname, $lastname, $user_id));

      $status = true;
    }
    catch (Exception $e)
    {
      $status = false;
    }

    return $status;
  }

  /**
   * Update user's password
   *
   * @param integer $user_id
   * @param string $password
   *
   * @return boolean
   */
  public static function updateUserPassword($user_id, $password)
  {
    $dbh = DB::getInstance();
    $fx = DB_PREFIX;

    $sec_pass = Security::passwordEncrypt($password);

    $status = false;

    try
    {
      // prepare statement and bind parameters
      $q = "UPDATE {$fx}users SET password=? WHERE id=?";
      $stmt = $dbh->prepare($q);
      $stmt->execute(array($sec_pass, $user_id));

      $status = true;
    }
    catch (Exception $e)
    {
      $status = false;
    }

    return $status;
  }

  /**
   * Administrator authentication process
   *
   * @param string $login
   * @param string $password
   *
   * @return boolean
   */
  public static function adminAuth($login, $password)
  {
    $dbh = DB::getInstance();
    $fx = DB_PREFIX;

    $sec_pass = Security::passwordEncrypt($password);

    $status = false;

    try
    {
      $q = "SELECT
              id, login, password FROM {$fx}users
            WHERE
              login = :login AND password = :password AND is_admin = 1";

      $stmt = $dbh->prepare($q);

      $stmt->bindParam(':login', $login, PDO::PARAM_STR);
      $stmt->bindParam(':password', $sec_pass, PDO::PARAM_STR, 32);

      $stmt->execute();

      $user_id = $stmt->fetchColumn();

      if (!$user_id)
      {
        $status = false;
      }
      else
      {
        $_SESSION['user_id']   = $user_id;
        $_SESSION['user_name'] = $login;
        $_SESSION['is_admin']  = true;

        $status = true;
      }
    }
    catch (Exception $e)
    {
      $status = false;
    }

    return $status;
  }
  
}
