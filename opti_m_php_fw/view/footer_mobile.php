<!-- footer for mobile -->
<div id="footer" class="mobile-links">
  <small>
    <p>
      <a href="<?php echo _APP_WEB_PATH ?>index.php">Home</a>
      <?php if (isset($_SESSION['user_id'])): ?>
      <span>|</span>
      <a href="<?php echo _APP_WEB_PATH ?>user/index">Account</a>
      <span>|</span>
      <a href="<?php echo _APP_WEB_PATH ?>user/logout">Logout</a>
      <?php else: ?>
      <span>|</span>
      <a href="<?php echo _APP_WEB_PATH ?>user/register">Register</a>
      <span>|</span>
      <a href="<?php echo _APP_WEB_PATH ?>user/login">Login</a>
      <?php endif; ?>
      <span>|</span>
      <a href="<?php echo _APP_WEB_PATH ?>about/index">About</a>
      <span>|</span>
      <a href="<?php echo _APP_WEB_PATH ?>about/form">Contact</a>
      <span>|</span>
      <a href="<?php echo _APP_WEB_PATH ?>index.php?m=0">Standard version</a>
    </p>
    <p style="margin-top: 8px;">
      <?php $_v = Config::getInstance()->getVal('application', 'app_version') ?>
      Mobile version | Powered by: Opti_M Framework v. <?php echo $_v ?> | &copy; Dominik Wlazlowski 2010
    </p>
  </small>
</div>
<!-- end: footer for mobile -->

</body>
</html>