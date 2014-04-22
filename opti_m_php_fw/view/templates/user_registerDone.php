<h1><?php echo $page_title ?></h1>

<?php if ($status == true): ?>
  <p>
    An account has been created.<br />
    Now You can log in on <a href="<?php echo _APP_WEB_PATH ?>user/login">following page.</a>
  </p>
<?php else: ?>
  <p>Database error. Please try again later.</p>
<?php endif; ?>
