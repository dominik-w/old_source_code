<h1><?php echo $page_title ?></h1>

Hello, Administrator.
<br />
<?php if (isset($_SESSION['user_id']) && isset($_SESSION['user_name'])): ?>
  Logged as user <?php echo $_SESSION['user_name'] ?> (ID: <?php echo $_SESSION['user_id'] ?>)
<?php endif; ?>

 <br /><br />
 <a href="<?php echo _APP_WEB_PATH ?>backend/contact">Contact messages</a>
 <span>|</span>
 <a href="<?php echo _APP_WEB_PATH ?>user/editPassword">Edit password</a>
 