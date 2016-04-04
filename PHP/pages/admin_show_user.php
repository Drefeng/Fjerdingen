<pre>
<?php

   $user_id = $_GET['user_id'];

   $sql_get_user = "SELECT * FROM users WHERE id = $user_id";
   $result_get_user = $db->query($sql_get_user);
   while($row_get_user = $result_get_user->fetch_assoc()) {

      echo $row_get_user['first_name'] . " ";
      echo $row_get_user['last_name'] . " \n";

      // Get users blog_posts

      echo "\n\nUSERS BLOG POST'S: \n\n";

      $sql_get_user_blog_posts = "SELECT blog_posts.id
                                    as blog_post_id, assignments.title
                                    as assignment_title, blog_posts.url, blog_posts.note, blog_posts.created
                                    FROM blog_posts
                                    INNER JOIN assignments ON (assignments.id = blog_posts.assignment_id)
                                    WHERE blog_posts.user_id = $user_id";

      $result_get_user_blog_posts = $db->query($sql_get_user_blog_posts);
      while($row_get_user_blog_posts = $result_get_user_blog_posts->fetch_assoc()) {

         echo "\n\nUSERS BLOG POST: \n\n";
         var_dump($row_get_user_blog_posts);
         echo "\n\nCOMMENTS ON USER BLOG POSTS\n\n ";
         // Get the comments on this blog post
         $blog_post_id = $row_get_user_blog_posts['blog_post_id'];
         $sql_get_blog_post_comments = "SELECT * FROM blog_post_comments
                                          WHERE blog_post_id = $blog_post_id";

         $result_get_blog_post_comments = $db->query($sql_get_blog_post_comments);
         while($row_get_blog_post_comments = $result_get_blog_post_comments->fetch_assoc()) {

            var_dump($row_get_blog_post_comments);

         }

      }
      // Get users commments on others blog posts
      echo "\n\nCURRENT USERS COMMENTS ON OTHER BLOG POSTS \n\n ";
      $sql_get_user_blog_post_comments = "SELECT assignments.title
                                          as assignment_title, users.first_name, users.last_name, blog_posts.url, blog_post_comments.comment
                                          FROM blog_post_comments
                                          INNER JOIN blog_posts ON (blog_posts.id = blog_post_comments.blog_post_id)
                                          INNER JOIN assignments ON (assignments.id = blog_posts.assignment_id)
                                          INNER JOIN users ON (users.id = blog_posts.user_id)
                                          WHERE blog_post_comments.user_id = $user_id";

      $result_get_user_blog_post_comments = $db->query($sql_get_user_blog_post_comments);
      while($row_get_user_blog_post_comments = $result_get_user_blog_post_comments->fetch_assoc()) {

         var_dump($row_get_user_blog_post_comments);

      }

   }


?>

</pre>
