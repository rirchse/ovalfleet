<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01//EN"
	"http://www.w3.org/TR/html4/strict.dtd">
<html>
<head>
	<title>osTicket @ Your Company</title>
</head>
<body>
<!-- In case redirection fails, show instructions for users -->
<h1>Welcome to the Support Center</h1>
<h2>Signing you in, please wait a few seconds.<br>You will be redirected automatically...</h2><br><br>
<h1>In case redirect does not work:<br></h1>
<h1><a href="osticket/index.php">Support Center</a></h1>
<?php
// Get username from webserver using REMOTE_USER
// Separate username and domain - method: split after @ symbol
$usernameATdomain = $_SERVER;

$ATposition = strpos($usernameATdomain,"@");

$username = substr($usernameATdomain, 0, $ATposition);

// Alternative method:

// Separate username and domain - method: using domain array

//$domain = array('@DOMAIN.COM' => '');

//$username = $_SERVER;

//$username = strtr($username, $domain);

// Make sure username has a value before querying database

if (!empty($username))

{

// MySQL connection settings - readonly account recommended:

// CREATE USER 'osticket-readonly'@'localhost' IDENTIFIED BY 'PASSWORD';

// GRANT SELECT (username) ON osticket.ost_staff TO 'osticket-readonly'@'localhost';

define('DBHOST','localhost');

define('DBNAME','osticket');

define('DBUSER','osticket-readonly');

define('DBPASS','PASSWORD');

// Connect to database

$mysqli = new mysqli(DBHOST, DBUSER, DBPASS, DBNAME);

// Check for connection errors

if (!$mysqli->connect_errno) {
// Query ost_staff table for REMOTE_USER username
$qry_is_agent = "SELECT username FROM ost_staff WHERE username LIKE '" . $username . "'";

$res_is_agent = $mysqli->query($qry_is_agent);

$is_agent = $res_is_agent->num_rows; 
}
} else {
	// Assume user is not an agent
	$is_agent = 0;
}

?>

<!-- Load login.php in background for silent login -->

<script type="text/javascript">

window.onload = function() {

var login = new XMLHttpRequest();

login.open('GET', 'osticket/login.php', false);

login.send(null);

};

</script>

<?php

// Username found in the ost_staff table?

// YES --> 1 --> Agent --> Redirect to scp after timeout

// NO --> 0 --> User --> Redirect to end user portal

if ($is_agent == "1")

{

?>

<!-- Redirect to scp after timeout, 1000 = 1 second -->

<script type="text/javascript">

setTimeout('location.href = "osticket/scp/"', 5000);

</script>

<?php

}

else

{

?>

<!-- Redirect to end user portal -->

<script type="text/javascript">

location.href = "osticket/open.php";

</script>

<?php

}

?>

</body>

</html>