<?php
session_start();

$_SESSION['previousPage'] = 'sport.php';
?>

<!DOCTYPE html>
<html>

<head>
	<meta charset="utf-8">
	<link rel="shortout icon" href="img\favicon.ico">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
	<link rel="stylesheet" type="text/css" href="css\stile_generale.css">
	<link rel="stylesheet" type="text/css" href="css\stile_sport.css">
	<link href='https://fonts.googleapis.com/css?family=Nunito:400,300' rel='stylesheet' type='text/css'>
	<title>ACSI Macerata</title>
</head>

<body>
	<div class="wrap">
		<?php
		require_once __DIR__ . '/config.inc.php';
		require_once __DIR__ . '/inc/header.php';
		
        echo "<div class='sport-gap'></div>";

        echo '<div class="row row-sport">
                <div class="col-12 header-container header-title-container sport-wrap">
                    <span class="header-title sport-container">
                    <iframe src="http://docs.google.com/gview?url=http://storm-beaten-instan.000webhostapp.com/news/attachments/' . $tmp[$i]['attachment_path'] . '&embedded=true" frameborder="0"></iframe>
                    </span>
                </div>;
              </div>';

		require_once __DIR__ . '/inc/footer.php';
		?>
	</div>
</body>

</html>