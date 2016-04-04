<a href="?p=user">Tilbake</a>


<?php

   $blog_post_id = $_GET['blog_post_id'];
   $sql = "SELECT * FROM blog_posts WHERE id = $blog_post_id";
   $result = $db->query($sql);
   $row = $result->fetch_assoc();

?>

<p>URL: <a href="<?php echo $row['url']; ?>" target="_blank"><?php echo $row['url']; ?></a></p>
<p>NOTE: <?php echo $row['note']; ?></p>


<h4>Kommentarer</h4>
<ul>
<?php
$sql = "SELECT * FROM blog_post_comments INNER JOIN users ON (users.id = blog_post_comments.user_id) WHERE blog_post_id = $blog_post_id AND completed = 1";
$result = $db->query($sql);
if($result->num_rows < 1):
   echo "No comments yet";
else:
   while($row = $result->fetch_assoc()):
?>

<li><?php echo $row['comment']; ?> (<?php echo $row['first_name']; ?>)</li>

<?php endwhile; ?>
</ul>
<?php endif; ?>
