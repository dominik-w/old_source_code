<!-- footer -->
<div id="footer">
  <div>
    <p class="left">
      <a href="<?php echo _APP_WEB_PATH ?>backend/index">Admin</a>
      <span>|</span>
      <a href="<?php echo _APP_WEB_PATH ?>backend/contact">Contact messages</a>
      <span>|</span>
      <a href="<?php echo _APP_WEB_PATH ?>index.php">Back to frontend</a>
      <?php if (isset($_SESSION['user_id'])): ?>
        <span>|</span>
        <a href="<?php echo _APP_WEB_PATH ?>backend/logout">Logout</a>
      <?php else: ?>
        <span>|</span>
        <a href="<?php echo _APP_WEB_PATH ?>backend/login">Login</a>
      <?php endif; ?>
    </p>
    <p class="right">Opti_M Framework &copy; Dominik Wlazlowski 2010
  </div>
</div>
<!-- end: footer -->

</body>
</html>