<?php

	if(!authenticated(array("admin"))) {
			set_error("No access, please log in with administration privileges.");
			return;
	}
?>
<br />
<h1>Administrasjon</h1>
<br />
<?php

	if(isset($_GET['a']) && $_GET['a'] == "add_assignment") {

		$title = $_POST['title'];
		$description = $_POST['description'];

		$sql = "INSERT INTO assignments (title, description) VALUES ('$title', '$description')";
		if(!$db->query($sql)) {
			print_error("Unable to insert new assignment in database.");
		} else {
			print_success("Assignment added.");
		}


	}

	if(isset($_GET['a']) && $_GET['a'] == "delete_assignment") {

		$assignment_id = $_GET['assignment_id'];

		$sql = "DELETE FROM assignments WHERE id = $assignment_id";
		if(!$db->query($sql)) {
			print_error("Unable to delete assignment from database.");
		} else {
			print_success("Assignment deleted.");
		}

	}

?>


<div role="tabpanel">

  <!-- Nav tabs -->
  <ul class="nav nav-tabs" role="tablist">
    <li role="presentation" class="active"><a href="#assignments" aria-controls="assignments" role="tab" data-toggle="tab">Øvinger</a></li>
    <li role="presentation"><a href="#users" aria-controls="users" role="tab" data-toggle="tab">Systembrukere</a></li>
  </ul>

  <!-- Tab panes -->
  <div class="tab-content">
    <div role="tabpanel" class="tab-pane active" id="assignments">
		<br />
		<table class="table table-striped">
			<thead>
				<tr>
					<th>Tittel</th>
					<th>Beskrivelse</th>
					<th>Valg</th>
				</tr>
			</thead>
			<tbody>

		<?php
		$sql = "SELECT assignments.id, assignments.title, assignments.description
					FROM assignments
					ORDER BY id ASC";
					
		$result = $db->query($sql);
		while($row = $result->fetch_assoc()):
		?>

		<tr>
			<td><?php echo $row['title']; ?></td>
			<td><?php echo $row['description']; ?></td>
			<td><a href="?p=admin&a=delete_assignment&assignment_id=<?php echo $row['id']; ?>"><span class="glyphicon glyphicon-trash" aria-hidden="true"></span></td>
		</tr>


		<?php endwhile; ?>
		</tbody>
		</table>
		<br />
		<h4>Legg til øving</h4>
		<form method="post" action="?p=admin&a=add_assignment">
			<input type="text" name="title" placeholder="Tittel" />
			<input type="text" name="description" size="100" placeholder="Beskrivelse" />
			<input type="submit" value="Legg til">
		</form>

	</div>
   <div role="tabpanel" class="tab-pane" id="users">

		<table class="table table-striped">
			<thead>
				<tr>
					<th>#</th>
					<th>Fornavn</th>
					<th>Etternavn</th>
					<th>E-Mail</th>
					<th>Rolle</th>
					<th>Innlevert øving : Antall kommentarer</th>
				</tr>
			</thead>
			<tbody>


		<?php
		$sql = "SELECT users.id
					as user_id, users.first_name, users.last_name, users.email, roles.name
					as role, assignments.title
					as assignment_title, count(blog_post_comments.id)
					as assignment_comments
					FROM users
					LEFT JOIN blog_posts ON (blog_posts.user_id = users.id)
					LEFT JOIN blog_post_comments ON (blog_post_comments.blog_post_id = blog_posts.id)
					LEFT JOIN assignments ON (assignments.id = blog_posts.assignment_id)
					INNER JOIN roles ON (roles.id = users.role_id)
					GROUP BY users.id, blog_posts.assignment_id";
/*
SELECT
	assignments.id,
	count(blog_post_comments.id) as assignment_comments
	FROM
	blog_post_comments
	INNER JOIN blog_posts ON (blog_posts.id = blog_post_comments.blog_post_id)
	INNER JOIN assignments ON (assignments.id = blog_posts.assignment_id)
	WHERE blog_post_comments.user_id = $user_id
	GROUP BY assignments.id)
*/
		$result = $db->query($sql);
		$cur_user_id = -1;
		while($row = $result->fetch_assoc()):

			if($cur_user_id != $row['user_id']):

				if($cur_user_id != -1) echo "</td></tr>";
				echo "<tr>";

		?>
		<td><?php echo $row['user_id']; ?></td>
		<td><a href="?p=admin_show_user&user_id=<?php echo $row['user_id']; ?>"><?php echo $row['first_name']; ?></a></td>
		<td><?php echo $row['last_name']; ?></td>
		<td><?php echo $row['email']; ?></td>
		<td><?php echo $row['role'] == 'admin' ? '<span class="label label-danger">admin</span>': '<span class="label label-primary">' . $row['role'] . '</span>'; ?></td>
		<td>

		<?php endif; ?>
				<?php
					if($row['assignment_title']) {

						if($row['assignment_comments'] <= 0) {

							echo '<span class="label label-danger">' . $row['assignment_title'] . ': ' . $row['assignment_comments'] . '</span>';

						} elseif($row['assignment_comments'] > 0 && $row['assignment_comments'] < 3) {

							echo '<span class="label label-warning">' . $row['assignment_title'] . ': ' . $row['assignment_comments'] . '</span>';

						} elseif($row['assignment_comments'] = 3) {

							echo '<span class="label label-success">' . $row['assignment_title'] . ': ' . $row['assignment_comments'] . '</span>';

						}

					}
				?>
		<?php
			$cur_user_id = $row['user_id'];
			endwhile;
		?>
		</tr>
		</tbody>
		</table>

	</div>
  </div>

</div>
