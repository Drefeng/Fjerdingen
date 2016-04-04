<?php

   $display_form = false;

   if(isset($_GET['blog_post_comment_id'])) {

         $blog_post_comment_id = $_GET['blog_post_comment_id'];
         $display_form = true;

   } else {

      $user_id = $_SESSION['user_id'];
      $assignment_id = $_GET['assignment_id'];

      // Get other blog post comments from this user on this assignment
      $sql = "SELECT blog_posts.id FROM blog_posts INNER JOIN blog_post_comments ON (blog_post_comments.blog_post_id = blog_posts.id) WHERE blog_posts.assignment_id = $assignment_id AND blog_post_comments.user_id = $user_id";
      $result = $db->query($sql);
      if($result->num_rows <= 0) {

         $commented_blog_posts = "-1"; //quickfix

      } else {

         $commented_blog_posts_array = array();
         while($row = $result->fetch_assoc()) {

            $commented_blog_posts_array[] = $row['id'];

         }

         $commented_blog_posts = implode(",", $commented_blog_posts_array);

      }

      $sql = "SELECT blog_posts.id, count(blog_post_comments.id) FROM blog_posts LEFT JOIN blog_post_comments ON (blog_post_comments.blog_post_id = blog_posts.id) WHERE blog_posts.assignment_id = $assignment_id AND blog_posts.user_id <> $user_id AND blog_posts.id NOT IN ($commented_blog_posts) GROUP BY blog_posts.id HAVING count(blog_post_comments.id) < 3 ORDER BY RAND() LIMIT 1";
      $result = $db->query($sql);

      if($result->num_rows <= 0) {

         print_info("No blog posts available for commenting right now, please try again later.");

      } else {

         // Reserve the comment, and display comment form.
         $row = $result->fetch_assoc();
         $blog_post_id = $row['id'];


         $sql = "INSERT INTO blog_post_comments (user_id, blog_post_id) VALUES ($user_id, $blog_post_id)";
         if(!$db->query($sql)) {

            print_error("Unable to reserve blog post comment in database.");

         } else {

            print_success("You have been assigned a blog post to comment on this assignment");
            $blog_post_comment_id = $db->insert_id;
            echo $blog_post_comment_id;

         }

         $display_form = true;

      }

   }


?>

<?php if($display_form): ?>
<form method="post" action="?p=user&a=add_blog_post_comment">
   <input type="hidden" name="blog_post_comment_id" value="<?php echo $blog_post_comment_id; ?>" />
   <textarea name="comment" placeholder="Kommentar på blogginnlegget"></textarea>
   <input type="submit" value="Lever">
</form>

<?php endif; ?>
