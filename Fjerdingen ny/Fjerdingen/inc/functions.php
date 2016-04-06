<?php

function inc_header() {

	require_once('inc/layout/header.php');
}

function inc_footer() {

	require_once('inc/layout/footer.php');

}

function inc_navigation() {

	require_once('inc/layout/navigation.php');

}

function connect_to_db($host, $username, $password, $database) {

	$db_resource = new mysqli($host, $username, $password, $database);
	if ($db_resource->connect_errno) {
		echo "Failed to connect to MySQL: (" . $db_resource->connect_errno . ") " . $db_resource->connect_error;
	}
	$db_resource->set_charset("utf8");
	return $db_resource;

}

function disconnect_from_db($db_resource) {

	$db_resource->close();

}


function set_error($msg = "") {

	$_SESSION['error'] = $msg;

}


function login($db, $username, $password) {

	$sql = "SELECT users.id, roles.name as role FROM users INNER JOIN roles ON (roles.id = users.role_id) WHERE email = '$username' AND password = '$password'";
	$result = $db->query($sql);
	if($result->num_rows > 0) {
		// Valid credentials

		$row = $result->fetch_assoc();

		$_SESSION['authenticated'] = true;
		$_SESSION['user_id'] = $row['id'];
		$_SESSION['role'] = $row['role'];

		return true;

	} else {
		// Invalid credentials

		set_error("Wrong username or password");
		return false;

	}

}

function logout() {

	session_destroy();

	// Quickfix
	session_start();

}


/*
 * Is the current user authenticated?
 *
 */
function authenticated($roles = array("user")) {

	if(isset($_SESSION['authenticated']) && $_SESSION['authenticated'] == true && in_array($_SESSION['role'], $roles)) {

		return true;

	} else {

		return false;

	}

}


function print_error($msg = "") {

	if(!empty($msg)) {

		echo '<br /><div class="alert alert-danger"><strong>Error!</strong> '. $msg .'</div>';

	} elseif(isset($_SESSION['error'])) {

		echo '<br /><div class="alert alert-danger"><strong>Error!</strong> '. $_SESSION['error'] .'</div>';

	}

}

function print_success($msg = "") {

	if(!empty($msg)) {

		echo '<br /><div class="alert alert-success">'. $msg .'</div>';

	}

}

function print_info($msg = "") {

	if(!empty($msg)) {

		echo '<br /><div class="alert alert-info">'. $msg .'</div>';

	}

}

/*
 * Global cleanup procedure, should be run at the end.
 *
 */
function cleanup() {

	unset($_SESSION['error']);

}

function print_debug_info() {


	echo '<pre>';
	echo '*** DEBUG INFO START ***' . "\n";
	echo '$_GET: ' . "\n";
	print_r($_GET);
	echo '$_POST: ' . "\n";
	print_r($_POST);
	echo '$_SESSION: ' . "\n";
	print_r($_SESSION);
	echo '*** DEBUG INFO END ***' . "\n";

	echo '</pre>';

}
