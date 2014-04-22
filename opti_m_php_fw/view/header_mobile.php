<?php echo '<?xml version="1.0" encoding="UTF-8"?>' . "\n" ?>
<!DOCTYPE html PUBLIC "-//WAPFORUM//DTD XHTML Mobile 1.1//EN"
  "http://www.openmobilealliance.org/tech/DTD/xhtml-mobile11.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
  <meta http-equiv="Content-type" content="text/html; charset=utf-8" />
  <meta name="description" content="Opti_M Framework" />
  <meta name="keywords" content="Opti_M, Framework, Mobile Web" />
  <meta name="author" content="Dominik Wlazlowski" />
  <meta name="language" content="en" />
  <meta name="robots" content="index, follow" />

  <title>{$title}</title>
  <link rel="stylesheet" type="text/css" href="<?php echo _APP_WEB_PATH ?>view/css/mobile.css" media="all" />
  
  <?php /*
  <link rel="stylesheet" type="text/css" href="<?php echo _APP_WEB_PATH ?>view/css/mobile.css" media="handheld" />
  <script src="<?php echo _APP_WEB_PATH ?>view/js/jq-mobile/jquery.mobile-1.0a2.min.js" type="text/javascript"></script>
  <link rel="stylesheet" type="text/css" href="<?php echo _APP_WEB_PATH ?>view/js/jq-mobile/jquery.mobile-1.0a2.min.css" media="handheld" />
  */ ?>

<?php /* if (DEBUG_MODE): ?>
  <script type="text/javascript" src="https://getfirebug.com/firebug-lite.js"></script>
<?php endif; */ ?>
</head>
<body>

  <div id="top" class="mobile-links">
    <small>
      <p>
        <a href="<?php echo _APP_WEB_PATH ?>index.php" accesskey="1">Home</a>
        <?php if (isset($_SESSION['user_id'])): ?>
        <span>|</span>
        <a href="<?php echo _APP_WEB_PATH ?>user/index" accesskey="2">Account</a>
        <span>|</span>
        <a href="<?php echo _APP_WEB_PATH ?>user/logout" accesskey="3">Logout</a>
        <?php else: ?>
        <span>|</span>
        <a href="<?php echo _APP_WEB_PATH ?>user/register" accesskey="2">Register</a>
        <span>|</span>
        <a href="<?php echo _APP_WEB_PATH ?>user/login" accesskey="3">Login</a>
        <?php endif; ?>
        <span>|</span>
        <a href="<?php echo _APP_WEB_PATH ?>about/index" accesskey="4">About</a>
        <span>|</span>
        <a href="<?php echo _APP_WEB_PATH ?>about/form" accesskey="5">Contact</a>
        <span>|</span>
        <a href="<?php echo _APP_WEB_PATH ?>index.php?m=0" accesskey="6">Standard version</a>
      </p>
    </small>
  </div>
  