<h1><?php echo $page_title ?></h1>

<p>List of contact messages</p>

<?php if (count($results) > 0): ?>
<ul>
<?php foreach ($results as $idx => $result): ?>
  <li>
    ID: <?php echo $result['id'] ?> |
    User name: <?php echo $result['user_name'] ?> |
    User e-mail: <?php echo $result['user_email'] ?> |
    Message: <?php echo $result['message'] ?> |
    Is read: <?php echo $result['is_read'] ?>
    Created At: <?php echo $result['created_at'] ?> |
    Updated At: <?php echo $result['updated_at'] ?> |
    <a href="<?php echo _APP_WEB_PATH ?>backend/contactEdit?id=<?php echo $result['id'] ?>">
      <img src="<?php echo _APP_WEB_PATH ?>view/images/edit_16.gif" style="border: 0px" alt="edit" title="edit" />
    </a>
    |
    <a href="<?php echo _APP_WEB_PATH ?>backend/contactDelete?id=<?php echo $result['id'] ?>"
       onclick="return confirm('Are you sure?');">
      <img src="<?php echo _APP_WEB_PATH ?>view/images/delete_16.png" style="border: 0px" alt="delete" title="delete" />
    </a>
  </li>
<?php endforeach; ?>
</ul>
<?php else: ?>
  <p>No results.</p>
<?php endif; ?>
