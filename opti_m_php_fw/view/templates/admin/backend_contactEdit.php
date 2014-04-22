<h1><?php echo $page_title ?></h1>

<?php if (isset($status) && (is_string($status))): ?>
  <span style="color: #00d;"><?php echo $status ?></span>
<?php endif; ?>

<form id="editForm" action="<?php echo _APP_WEB_PATH ?>backend/contactEdit" method="post">
  <fieldset>
    <p>
      <label for="body">Message:</label>
      <textarea id="body" name="body"><?php echo $body ?></textarea>
    </p>
    <p>
      <label for="is_read">Is read:</label>
      <?php $state = ($is_read) ? 'checked' : ''; ?>
      <input type="checkbox" id="is_read" name="is_read" value="1" <?php echo $state ?> />
    </p>
    <input type="hidden" id="id" name="id" value="<?php echo $id ?>" />
    <p>
      <input type="submit" value="Save" />
    </p>
  </fieldset>
</form>

<a href="<?php echo _APP_WEB_PATH ?>backend/contact">Back to list</a>
