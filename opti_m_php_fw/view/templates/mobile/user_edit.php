<h2><?php echo $page_title ?></h2>

<form action="<?php echo _APP_WEB_PATH ?>user/edit" method="post">
  <fieldset>
    <p>
      <label for="firstname">Firstname:</label>
      <input type="text" id="firstname" name="firstname" value="<?php echo $user_firstname ?>" maxlength="50" />
    </p>
    <p>
      <label for="lastname">Lastname:</label>
      <input type="text" id="lastname" name="lastname" value="<?php echo $user_lastname ?>" maxlength="50" />
    </p>
    <p>
      <input type="submit" value="Save" />
    </p>
  </fieldset>
</form>
