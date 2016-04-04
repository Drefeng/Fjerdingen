<a href="?p=user">Tilbake</a>


<?php

   $blog_post_comment_id = $_GET['blog_post_comment_id'];
   $sql = "SELECT * FROM blog_post_comments WHERE id = $blog_post_comment_id";
   $result = $db->query($sql);
   $row = $result->fetch_assoc();

?>

<p>Kommentar: <?php echo $row['comment']; ?></p>
