<h2><?php echo $page_title ?></h2>

<form action="<?php echo _APP_WEB_PATH ?>user/editPassword" method="post">
  <fieldset>
    <p>
      <label for="old_pass">Old password</label>
      <input type="password" id="old_pass" name="old_pass" value="" maxlength="32" />
      <br />
      <?php if (isset($msg_password_old)): ?>
        <small style="color: #d00;"><?php echo $msg_password_old ?></small>
      <?php endif; ?>
    </p>
    <p>
      <label for="new_pass">New password</label>
      <input type="password" id="new_pass" name="new_pass" value="" maxlength="32" />
    </p>
    <p>
      <label for="new_pass_pass">New password repeat</label>
      <input type="password" id="new_pass_re" name="new_pass_re" value="" maxlength="32" />
      <br />
      <?php if (isset($msg_password)): ?>
        <small style="color: #d00;"><?php echo $msg_password ?></small>
      <?php endif; ?>
    </p>
    <p>
      <input type="submit" value="Save" />
    </p>
  </fieldset>
</form>

<br />
<?php /*<a href="javascript:history.go(-1)">Turn back</a>*/ ?>
