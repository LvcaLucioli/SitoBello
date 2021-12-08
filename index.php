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
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
        <link rel="stylesheet" type="text/css" href="css/stile_header.css">
        <script src="js/header.js"></script>
        <title>ACSI Macerata</title>
    </head>
	
    <body>
        <?php
			require 'inc\header.php';
		?>
		
    </body>
</html>