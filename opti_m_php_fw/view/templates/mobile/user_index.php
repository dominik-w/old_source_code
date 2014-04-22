<h2><?php echo $page_title ?></h2>

<br />
<strong>Hello!</strong>
<br />
<?php if (isset($_SESSION['user_id']) && isset($_SESSION['user_name'])): ?>
  Logged as user <?php echo $_SESSION['user_name'] ?> (ID: <?php echo $_SESSION['user_id'] ?>)
 using mobile device.
<?php endif; ?>

 <br /><br />
 <a href="<?php echo _APP_WEB_PATH ?>user/edit">Edit account via mobile</a>
 <br />
 <a href="<?php echo _APP_WEB_PATH ?>user/editPassword">Edit password via mobile</a>
 