<?php

/**
 * Tools.class.php
 * A class with utilities for Opti_M application.
 *
 * @author  Dominik Wlazlowski <dominik-w@dominik-w.pl> 2010
 * @version 1.0
 */
class Tools
{
  /**
   * Quick log method. Logs of data with datetime inclusion in neutral file.
   *
   * @param string $message
   * @return void
   */
  public static function myLog($message)
  {
    $logPath = 'var';
    $outFile = 'app_log.log';
    
    $logFile = $logPath . DIRECTORY_SEPARATOR . $outFile;

    $now = @date('Y-m-d G:i:s'); // include datetime
    $out = $now . ": " . $message . "\n";

    $fp = fopen($logFile, "a+");
    fwrite($fp, $out);
    fwrite($fp, "\n");
    fclose($fp);
  }

  /**
   * Quick debug preview.
   *
   * @param string $message
   * @return string
   */
  public static function debug($message)
  {
    $formatted = "<span style='border: solid 1px; float: left;'>{$message}</span>";
    
    return $formatted;
  }
  
  /**
   * Generates random output - letters and digits combined.
   *
   * @param integer $length A length of generated output
   * @return string
   */
  public static function generateRandomString($length = 32)
  {
    list($usec, $sec) = explode(' ', microtime());
    $s_in = (float) $sec + ((float) $usec * 100000);
    srand($s_in);

    $input = "1234567890abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ";
    $output = "";
    while (strlen($output) < $length)
    {
      $output .= substr($input, rand() % (strlen($input)), 1);
    }

    return $output;
  }

  /**
   * Generates random output - digits only.
   * @return integer
   */
  public static function generateRandomDigits()
  {
    srand();

    return rand(0, getrandmax());
  }

  /**
   * Filesystem operations: recursive deleting of files from directory.
   *
   * @param string $dir Directory name
   * @return void
   */
  public static function deleteFilesFromDirectory($dir)
  {
    $h = @opendir($dir);
    if ($h)
    {
      while (($file = readdir($h)) !== false)
      {
        if ($file != "." && $file != "..")
        {
          unlink($dir . '/' . $file);
        }
      }
      closedir($h);
    }
  }

  /**
   * Filesystem operations: removing directory.
   *
   * @param string   $dir  Directory name
   * @param boolean  $rec  Recursive flag
   *
   * @return boolean
   */
  public static function deleteDirectory($dir, $rec = false)
  {
    if ($rec)
    {
      self::deleteFilesFromDirectory($dir);
    }

    return @rmdir($dir);
  }

  /**
   * Slug generator. Main purpose: creating seo- and user-friendly links for various resources.
   *
   * @param string $str Input string
   * @return string
   */
  public static function createSlug($str)
  {
    $str = strtolower(trim($str));
    $str = preg_replace('/039/', "", $str);
    $str = preg_replace('/[^a-z0-9-]/', '-', $str);
    $str = preg_replace('/-+/', " ", $str);

    return $str;
  }

  /**
   * Permalink generator. It uses ASCII conversion with iconv.
   *
   * @param string $str Input string
   * @return string
   */
  public static function createPermalink($str)
  {
    $output = iconv('UTF-8', 'ASCII//TRANSLIT', $str);
    $output = preg_replace("/[^a-zA-Z0-9\/_| -]/", '', $output);
    $output = strtolower(trim($output, '-'));
    $output = preg_replace("/[\/_| -]+/", '-', $output);

    return $output;
  }

  /**
   * Calculates the user age from a given birth date.
   * Inspired by: http://snippets.dzone.com/posts/show/1310
   *
   * @example:
   * self::calculateAge("1986-03-27");
   *
   * @param string $birthdate Input date
   * @return integer
   */
  public static function calculateAge($birthdate)
  {
    list($year, $month, $day) = explode("-", $birthdate);

    $y_diff = date("Y") - $year;
    $m_diff = date("m") - $month;
    $d_diff = date("d") - $day;

    if ($m_diff < 0) {
      $y_diff--;
    }
    else if ( ($m_diff == 0) && ($d_diff < 0) ) {
      $y_diff--;
    }

    return $y_diff;
  }

  /**
   * Formatting filesize.
   *
   * @param integer $bytes
   * @param integer $precision
   *
   * @return string
   */
  public static function formatBytes($bytes, $precision = 2)
  {
    $units = array('B', 'KB', 'MB', 'GB', 'TB');

    $bytes = max($bytes, 0);
    $pow = floor(($bytes ? log($bytes) : 0) / log(1024));
    $pow = min($pow, count($units) - 1);

    $bytes /= pow(1024, $pow);

    return round($bytes, $precision) . ' ' . $units[$pow];
  }

  /**
   * Class reflection method. Returns output string formatted with XHTML.
   * Sometimes it's really useful during development.
   *
   * @return string
   */
  public static function displayClassDiagnostic()
  {
    $classes = get_declared_classes();
    $output = "";

    foreach ($classes as $class)
    {
      $output .= "Class info: {$class}<br />";
      $output .= "Methods {$class}:<br />";

      $methods = get_class_methods($class);
      if (!count($methods))
      {
        $output .= "<i>None</i><br />";
      }
      else
      {
        foreach ($methods as $method)
        {
          $output .= "<b>$method</b>()<br />";
        }
      }

      $output .= "Properties {$class}:<br />";

      $properties = get_class_vars($class);
      if (!count($properties))
      {
        $output .= "<i>None</i><br />";
      }
      else
      {
        foreach (array_keys($properties) as $property)
        {
          $output .= "<b>\${$property}</b><br />";
        }
      }

      $output .= "<hr />";
    }

    return $output;
  }
  
}
