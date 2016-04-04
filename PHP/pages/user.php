<?php

	if(!authenticated(array("admin", "user"))) {
		set_error("No access, please log in.");
		return;
	}
	$user_id = $_SESSION['user_id'];
?>
<br />
<h1>Min side</h1>
<br />

<?php



if(isset($_GET['a']) && $_GET['a'] == "add_assignment_blog_post") {

	$assignment_id = $_POST['assignment_id'];
	$url = $_POST['url'];
	$note = $_POST['note'];

	$sql_add_assignment_blog_post = "INSERT INTO blog_posts (user_id, assignment_id, url, note) VALUES ($user_id, $assignment_id, '$url', '$note')";
	if(!$db->query($sql_add_assignment_blog_post)) {
		print_error("Unable to insert new blog post in database.");
	} else {
		print_success("Blog post added.");
	}


}

if(isset($_GET['a']) && $_GET['a'] == "add_blog_post_comment") {

	$blog_post_comment_id = $_POST['blog_post_comment_id'];
	$comment = $_POST['comment'];

	$sql_add_assignment_blog_post_comment = "UPDATE blog_post_comments SET comment = '$comment', completed = 1 WHERE id = $blog_post_comment_id";
	if(!$db->query($sql_add_assignment_blog_post_comment)) {
		print_error("Unable to update blog post comment in database.");
	} else {
		print_success("Blog post added.");
	}


}



?>

<table class="table table-striped">

<thead>
	<tr>
		<th>Øving</th>
		<th>Innlevering</th>
		<th>Tilbakemelding #1</th>
		<th>Tilbakemelding #2</th>
		<th>Tilbakemelding #3</td>
	</tr>
</thead>
<tbody>
	<?php

		$sql_get_assignments = "SELECT * FROM assignments";
		$result_get_assignments = $db->query($sql_get_assignments);
		while($row_get_assignments = $result_get_assignments->fetch_assoc()):

		// Have the student delivered this assignment?
		$assignment_id = $row_get_assignments['id'];

		$sql_get_user_assignment_blog_posts = "SELECT * FROM blog_posts WHERE user_id = $user_id AND assignment_id = $assignment_id";
		$result_get_user_assignment_blog_posts = $db->query($sql_get_user_assignment_blog_posts);
		if(!$result_get_user_assignment_blog_posts || $result_get_user_assignment_blog_posts->num_rows == 0) {
			// This user have no blog posts for this assignment
			$assignment_delivered = false;

		} else {

			// This user have a blog post for this assignment
			$assignment_delivered = true;
			$blog_post = $result_get_user_assignment_blog_posts->fetch_assoc();


		}




?>

	<tr>
		<td><?php echo $row_get_assignments['title']; ?></td>
		<td><?php echo $assignment_delivered ? '<a href="?p=user_show_blog_post&blog_post_id=' . $blog_post['id'] . '">Vis innlevering</a>' : '<a href="?p=user_add_assignment_blog_post&assignment_id=' . $row_get_assignments['id'] . '">Lever</a>'; ?></td>
		<?php if(!$assignment_delivered): ?>
			<td colspan="3" class="warning"><center>Lever øving selv først</center></td>
		<?php
			else:

			$sql_get_user_assignment_blog_post_comments = "SELECT blog_post_comments.id as blog_post_comment_id, blog_post_comments.completed FROM blog_posts INNER JOIN blog_post_comments ON (blog_post_comments.blog_post_id = blog_posts.id) WHERE blog_post_comments.user_id = $user_id AND blog_posts.assignment_id = $assignment_id";
			$result_get_user_assignment_blog_post_comments = $db->query($sql_get_user_assignment_blog_post_comments);
			while($row_get_user_assignment_blog_post_comments = $result_get_user_assignment_blog_post_comments->fetch_assoc()): ?>

				<td><?php echo $row_get_user_assignment_blog_post_comments['completed'] ? '<a href="?p=user_show_blog_post_comment&blog_post_comment_id=' . $row_get_user_assignment_blog_post_comments['blog_post_comment_id'] . '"><span class="label label-success">Fullført</span></a>' : '<a href="?p=user_add_assignment_blog_post_comment&blog_post_comment_id=' . $row_get_user_assignment_blog_post_comments['blog_post_comment_id'] . '"><span class="label label-danger">Ikke fullført</span></a>'; ?></td>

		<?php	endwhile; ?>

		<?php for($i = 0; $i < (3 - $result_get_user_assignment_blog_post_comments->num_rows); $i++): ?>

			<td><a href="?p=user_add_assignment_blog_post_comment&assignment_id=<?php echo $assignment_id; ?>"><span class="label label-default">Trekk tilfeldig</span></a></td>

		<?php endfor; ?>



		<?php endif; ?>
	</tr>

<?php endwhile; ?>

</tbody>
</table>
