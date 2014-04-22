<?php

/**
 * ContactModel.class.php
 *
 * @author  Dominik Wlazlowski <dominik-w@dominik-w.pl> 2010
 * @version 1.0
 */
class ContactModel
{
  /**
   * Save contact message in the database
   * 
   * @param string $login
   * @param string $email
   * @param string $body
   *
   * @return boolean
   */
  public function saveContactMessage($login, $email, $body)
  {
    $dbh = DB::getInstance();
    $fx  = DB_PREFIX;
    $now = @date('Y-m-d G:i:s');

    $status = false;

    try
    {
      // prepare statement and bind parameters
      $q = "INSERT INTO
             {$fx}contact_messages (user_name, user_email, message, created_at, updated_at)
           VALUES
             (:login, :email, :body, :created_at, :updated_at)";

      $stmt = $dbh->prepare($q);

      $stmt->bindParam(':login', $login, PDO::PARAM_STR);
      $stmt->bindParam(':email', $email, PDO::PARAM_STR);
      $stmt->bindParam(':body', $body, PDO::PARAM_STR);
      $stmt->bindParam(':created_at', $now, PDO::PARAM_STR);
      $stmt->bindParam(':updated_at', $now, PDO::PARAM_STR);

      $stmt->execute();

      $status = true;
    }
    catch (Exception $e)
    {
      $status = false;
    }

    return $status;
  }

  /**
   * Retrieve contact messages from database
   * @return array
   */
  public static function getContactMessages()
  {
    $dbh = DB::getInstance();
    $fx = DB_PREFIX;

    $result = array();

    try
    {
      $q = "SELECT * FROM {$fx}contact_messages WHERE 1";
      $stmt = $dbh->prepare($q);
      $stmt->execute();
      
      $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
    catch (Exception $e)
    {
      $result = null;
    }

    return $result;
  }

  /**
   * Get message data by ID
   *
   * @param integer $id
   * @return array
   */
  public static function getMessageData($id)
  {
    $dbh = DB::getInstance();
    $fx = DB_PREFIX;

    $result = array();

    try
    {
      $q = "SELECT * FROM {$fx}contact_messages WHERE id = '{$id}'";
      $stmt = $dbh->prepare($q);
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
   * Update message
   *
   * @param integer $id
   * @param integer $is_read
   * @param string $body
   *
   * @return boolean
   */
  public static function updateMessage($id, $is_read, $body)
  {
    $dbh = DB::getInstance();
    $fx = DB_PREFIX;
    
    $status = false;

    try
    {
      // prepare statement and bind parameters
      $q = "UPDATE {$fx}contact_messages SET message=?, is_read=?, updated_at=NOW() WHERE id=?";
      $stmt = $dbh->prepare($q);
      $stmt->execute(array($body, $is_read, $id));

      $status = true;
    }
    catch (Exception $e)
    {
      $status = false;
    }

    return $status;
  }

  /**
   * Delete message
   *
   * @param integer $id
   * @return boolean
   */
  public static function deleteMessage($id)
  {
    $dbh = DB::getInstance();
    $fx = DB_PREFIX;

    $status = false;

    try
    {
      // prepare statement and bind parameters
      $q = "DELETE FROM {$fx}contact_messages WHERE id=?";
      $stmt = $dbh->prepare($q);
      $stmt->execute(array($id));

      $status = true;
    }
    catch (Exception $e)
    {
      $status = false;
    }

    return $status;
  }

}
