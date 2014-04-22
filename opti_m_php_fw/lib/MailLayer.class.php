<?php

/**
 * MailLayer.class.php
 * A class with methods for easy sending e-mail notifications from application.
 * Default mailing vendor: Zend_Mail
 *
 * @author  Dominik Wlazlowski <dominik-w@dominik-w.pl> 2010
 * @version 1.0
 */
class MailLayer
{
  /** Status code - success. */
  const STATUS_OK = "OK";

  /** Status code - success. */
  const STATUS_ERR = "ERROR";

  /**
   * Send standard notification.
   * 
   * @param string $rec_email Receiver's email
   * @param string $rec_name Receiver's name
   * @param string $topic Email subject
   * @param string $text Text body
   * @param string $html HTML body
   * @param array $params An array with optional params (bccEmail, bccName, attachFile,
   *                      attachName, attachType)
   *
   * @return string Status code
   */
  public static function standardMail($rec_email, $rec_name, $topic, $text = '',
          $html = '', $params = null)
  {
    // include libraries
    ini_set('include_path', 'lib/vendor/');
    require_once('Zend/Mail.php');

    // define sender data
    if (!empty($params['sender_name']) && !empty($params['sender_email']))
    {
      $sender_name  = $params['sender_name'];
      $sender_email = $params['sender_email'];
    }
    else
    {
      $cfg = Config::getInstance();
      
      $sender_name = $cfg->getVal('application', 'app_name');
      $sender_email = $cfg->getVal('application', 'root_email');
    }

    try
    {
      $mail = new Zend_Mail('utf-8');

      $mail->setBodyText($text);

      if (strlen($html) > 0)
      {
        $mail->setBodyHtml($html);
      }

      // $mail->setMimeBoundary('=_' . md5(microtime(1) . rand(0, 99)));

      $mail->setFrom($sender_email, $sender_name);
      $mail->addTo($rec_email, $rec_name);

      if (!empty($params['bccEmail']) && !empty($params['bccName']))
      {
        $mail->addBcc($params['bccEmail'], $params['bccName']);
      }
      
      $mail->setSubject($topic);

      if (!empty($params['attachFile']) && file_exists($params['attachFile']))
      {
        $at = $mail->addAttachment(file_get_contents($params['attachFile']));
        $at->type        = $params['attachType'];
        $at->disposition = Zend_Mime::DISPOSITION_ATTACHMENT;
        $at->filename    = $params['attachName'];
      }

      if ($mail->send())
      {
        return self::STATUS_OK;
      }
    }
    
    catch (Exception $e)
    {
      $status = self::STATUS_ERR;
    }

    return $status;
  }
  
}
