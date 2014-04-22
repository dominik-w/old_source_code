<h2><?php echo $page_title ?></h2>

<p>Please type auth data</p>

<?php if (isset($status)): ?>
  <?php if ($status == false): ?>
    <span style="color: #d00;">Login incorrect. Please try again.</span>
  <?php endif; ?>
<?php endif; ?>

<form action="<?php echo _APP_WEB_PATH ?>user/login" method="post">
  <fieldset>
    <p>
      <label for="login" style="margin-right: 26px">Login:</label>
      <input type="text" id="login" name="login" value="" maxlength="32" />
      <br />
      <?php if (isset($msg_login)): ?>
        <small style="color: #d00;"><?php echo $msg_login ?></small>
      <?php endif; ?>
    </p>
    <p>
      <label for="password">Password:</label>
      <input type="password" id="password" name="password" value="" maxlength="32" />
      <br />
      <?php if (isset($msg_password)): ?>
        <small style="color: #d00;"><?php echo $msg_password ?></small>
      <?php endif; ?>
    </p>
    <p>
      <input type="submit" value="Log in" />
    </p>
  </fieldset>
</form>
