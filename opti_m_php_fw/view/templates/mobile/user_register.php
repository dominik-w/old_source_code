<h2><?php echo $page_title ?></h2>

<p>Register using mobile device</p>

<form action="<?php echo _APP_WEB_PATH ?>user/register" method="post">
  <fieldset>
    <p>
      <label for="login">Login *:</label>
      <input type="text" id="login" name="login" value="<?php echo isset($tmp_login) ? $tmp_login : '' ?>" maxlength="32" />
      <br />
      <?php if (isset($msg_login)): ?>
        <small style="color: #d00;"><?php echo $msg_login ?></small>
      <?php endif; ?>
    </p>
    <p>
      <label for="email">Email *:</label>
      <input type="text" id="email" name="email" value="<?php echo isset($tmp_email) ? $tmp_email: '' ?>" maxlength="100" />
      <br />
      <?php if (isset($msg_email)): ?>
        <small style="color: #d00;"><?php echo $msg_email ?></small>
      <?php endif; ?>
    </p>
    <p>
      <label for="password">Password *:</label>
      <input type="password" id="password" name="password" value="" maxlength="32" />
    </p>
    <p>
      <label for="password_re">Password again *:</label>
      <input type="password" id="password_re" name="password_re" value="" maxlength="32" />
      <br />
      <?php if (isset($msg_password_re)): ?>
        <small style="color: #d00;"><?php echo $msg_password_re ?></small>
      <?php endif; ?>
    </p>
    <p>
      <label for="firstname">Firstname:</label>
      <input type="text" id="firstname" name="firstname" value="" maxlength="50" />
    </p>
    <p>
      <label for="lastname">Lastname:</label>
      <input type="text" id="lastname" name="lastname" value="" maxlength="50" />
    </p>
    <p>
      <input type="hidden" name="form_token" value="<?php echo $form_token ?>" />
    </p>
    <p>
      <input type="submit" value="Create an account" />
    </p>
  </fieldset>
</form>
