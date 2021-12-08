<?php
	session_start();
	
	$_SESSION['previousPage'] = 'Home.php';
?>

<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8">
        <!--<link rel="shortout icon" href="favicon.ico">-->
        <meta name="viewport" content="width=device-width, initial-scale=1">
		<link rel="stylesheet" type="text/css" href="css\stile_home.css">
        <link rel="stylesheet" type="text/css" href="css\stile_header.css">
        <link rel="stylesheet" type="text/css" href="css\bootstrap\bootstrap.css">
        <title>ACSI Macerata</title>
    </head>
	
    <body>
        <?php
			require 'inc\header.php';
		?>
		
    </body>
</html>