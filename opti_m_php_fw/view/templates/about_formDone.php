<h1><?php echo $page_title ?></h1>

<?php if ($status == true): ?>
  <p>
    You message has been sent.<br />
    <a href="<?php echo _APP_WEB_PATH ?>index.php">Homepage</a>
  </p>
<?php else: ?>
  <p>Database error. Please try again later.</p>
<?php endif; ?>
