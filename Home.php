<?php
session_start();

$_SESSION['previousPage'] = 'Home.php';
?>

<!DOCTYPE html>
<html>

<head>
	<meta charset="utf-8">
	<link rel="shortout icon" href="favicon.ico">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<link rel="stylesheet" type="text/css" href="css\stile_home.css">
	<link href='https://fonts.googleapis.com/css?family=Nunito:400,300' rel='stylesheet' type='text/css'>
	<title>Noleggiopattino</title>
</head>

<body>
	<?php
	require 'inc\header.php';
	require 'inc\sectionHome.php';
	?>
</body>

</html>