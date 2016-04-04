<?php
// Start the session
session_start();

// Include configuration and general functions
require_once("inc/config.php");
require_once("inc/functions.php");

// Connect to db
$db = connect_to_db($_cfg['DB_HOST'], $_cfg['DB_USER'], $_cfg['DB_PASSWORD'], $_cfg['DB_NAME']);

// Autentication
if(isset($_GET['auth']) && $auth = $_GET['auth']) {

	if($auth == "login") {

		login($db, $_POST['username'], $_POST['password']);

	} elseif($auth == "logout") {

		logout();

	}

}


// Include layout header
inc_header();


// Business logic / main content
if(isset($_GET['p']) && $page = $_GET['p']) {

	$inc_file = 'pages/' . $page . '.php';

} else {

	$inc_file = 'pages/' . 'main' . '.php';

}

if(file_exists($inc_file)) {

	include_once($inc_file);

} else {

	set_error('Could not load requested page.');

}

//$sql = "SELECT * FROM users WHERE email = '$username' AND password = '$password'";
//echo ($sql);
// Print errors, if any
print_error();

// Include layout footer
inc_footer();

// Print debugging information (will invalidate HTML)
if($_cgf['DEBUG'] == true) print_debug_info();

// Disconnect from database
disconnect_from_db($db);

// Cleanup
cleanup();
