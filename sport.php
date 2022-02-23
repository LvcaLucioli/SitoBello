<?php

session_start();


$_SESSION['previousPage'] = 'sport.php';

use Ilovepdf\CompressTask;
require_once __DIR__ . '/ilovepdf/init.php';

?>

<!DOCTYPE html>
<html>

<head>
	<meta charset="utf-8">
	<link rel="apple-touch-icon" sizes="180x180" href="/apple-touch-icon.png">
    <link rel="icon" type="image/png" sizes="32x32" href="/favicon-32x32.png">
    <link rel="icon" type="image/png" sizes="16x16" href="/favicon-16x16.png">
    <link rel="manifest" href="/site.webmanifest">
    <link rel="mask-icon" href="/safari-pinned-tab.svg" color="#5bbad5">
    <meta name="msapplication-TileColor" content="#da532c">
    <meta name="theme-color" content="#ffffff">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
	<link rel="stylesheet" type="text/css" href="css\stile_generale.css">
	<link rel="stylesheet" type="text/css" href="css\stile_sport.css">
	<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
	<link href='https://fonts.googleapis.com/css?family=Nunito:400,300' rel='stylesheet' type='text/css'>
	<title>ACSI | Comitato Provinciale di Macerata</title>
</head>

<body>
	<div class="wrap">
		<?php
		
		require_once __DIR__ . '/config.inc.php';
		
		require_once __DIR__ . '/inc/header.php';

		$qr = "SELECT * FROM `sport` WHERE `sport_key`=1";

		//connessione al db ed esecuzione query
		$connection = mysqli_connect($hostname, $username, $password, $db_name)
			or die("connessione fallita");

		$risultato = mysqli_query($connection, $qr)
			or die("Query non valida: " . mysqli_error($connection));

		$row = mysqli_num_rows($risultato);
		$tmp = mysqli_fetch_assoc($risultato);

		echo "<div class='sport-gap'></div>";

		echo '<div class="row-sport">
                <div class="col-12 header-container header-title-container sport-wrap">
                    <span class="header-title sport-container">';
                    
        if (isset($_SESSION['user'])) require_once __DIR__ . '/inc/admin_sport.php';
		mysqli_close($connection);
		
		echo '		<div>
                    <iframe id="pdf-js-viewer" src="/web/viewer.html?file=https://acsimacerata.com/sport/' . $tmp['path'] . '" title="webviewer" frameborder="0" width="800" height="600"></iframe>
                    </div>
                    </span>
                </div>
              </div>';

			  
		require_once __DIR__ . '/inc/footer.php';
		?>
	</div>
</body>

</html>