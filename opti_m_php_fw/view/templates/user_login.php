<h1><?php echo $page_title ?></h1>

<p>Please type auth data</p>

<?php if (isset($status)): ?>
  <?php if ($status == false): ?>
    <span style="color: #d00;">Login incorrect. Please try again.</span>
  <?php endif; ?>
<?php endif; ?>

<form id="loginForm" action="<?php echo _APP_WEB_PATH ?>user/login" method="post">
  <fieldset>
    <p>
      <label for="login">Login:</label>
      <input type="text" id="login" name="login" value="" maxlength="32" />
      <?php if (isset($msg_login)): ?>
        <small style="color: #d00;"><?php echo $msg_login ?></small>
      <?php endif; ?>
    </p>
    <p>
      <label for="password">Password:</label>
      <input type="password" id="password" name="password" value="" maxlength="32" />
      <?php if (isset($msg_password)): ?>
        <small style="color: #d00;"><?php echo $msg_password ?></small>
      <?php endif; ?>
    </p>
    <?php /*
    <p><label for="remember">Remember me</label>
      <input type="checkbox" name="remember" id="remember" value="1" /></p>*/ ?>
    <p>
      <input type="submit" value="Log in" />
    </p>
  </fieldset>
</form>
