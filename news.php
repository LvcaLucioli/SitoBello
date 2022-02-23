<?php
session_start();

$_SESSION['previousPage'] = 'news.php';


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
	<link rel="stylesheet" type="text/css" href="css\stile_news.css">
	<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
	<link href='https://fonts.googleapis.com/css?family=Nunito:400,300' rel='stylesheet' type='text/css'>
	<title>ACSI | Comitato Provinciale di Macerata</title>
</head>

<body>
	<div class="wrap">
		<?php
		require_once __DIR__ . '/config.inc.php';
        require_once __DIR__ . '/inc/header.php';
        if (isset($_SESSION['user']))   require_once __DIR__ . '/inc/admin_news.php';
        	else    require_once __DIR__ . '/inc/user_news.php';
		require_once __DIR__ . '/inc/footer.php';
		?>
	</div>
</body>

</html>