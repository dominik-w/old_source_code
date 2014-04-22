<?php

/**
 * Mobile.class.php
 * A class with mobile related utilities.
 *
 * @author  Dominik Wlazlowski <dominik-w@dominik-w.pl> 2010
 * @version 0.2.1

 */
class Mobile
{
  /**
   * Detect mobile device. Deprecated. The Mobile Detect library used instead.
   *
   * @return boolean
   */
  public static function isMobileDevice()
  {
    $useragent = $_SERVER['HTTP_USER_AGENT'];
    if (preg_match("/Creative\AutoUpdate/i", $useragent)) return false;
    $uamatches = array("midp", "j2me", "avantg", "docomo", "novarra", "palmos",
      "palmsource", "240x320", "opwv", "chtml", "pda", "windows\ ce", "mmp\/",
      "blackberry", "mib\/", "symbian", "wireless", "nokia", "hand", "mobi", "phone",
      "cdm", "up\.b", "audio", "SIE\-", "SEC\-", "samsung", "HTC", "mot\-", "mitsu",
      "sagem", "sony", "alcatel", "lg", "erics", "vx", "NEC", "philips", "mmm", "xx",
      "panasonic", "sharp", "wap", "sch", "rover", "pocket", "benq", "java", "pt", "pg",
      "vox", "amoi", "bird", "compal", "kg", "voda", "sany", "kdd", "dbt", "sendo",
      "sgh", "gradi", "jb", "\d\d\di", "moto", "OperaMini");
    
    foreach ($uamatches as $uastring)
    {
      if (preg_match("/" . $uastring . "/i" , $useragent))
      {
        return true;
      }
    }
    
    return false;
  }

}
