<?php
session_start();

$_SESSION['previousPage'] = 'convenzioni.php';
?>

<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <link rel="shortout icon" href="favicon.ico">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
    <link rel="stylesheet" type="text/css" href="css\stile_generale.css">
    <link rel="stylesheet" type="text/css" href="css\stile_home.css">
    <link href='https://fonts.googleapis.com/css?family=Nunito:400,300' rel='stylesheet' type='text/css'>
    <script type="text/javascript" src="js/slideshow.js"></script>
    <title>ACSI Macerata</title>
</head>

<body>

    <?php
    require_once __DIR__ . '/config.inc.php';
    require_once __DIR__ . '/inc/header.php';
    if (isset($_SESSION['user'])) {
        require_once __DIR__ . '/inc/admin_convenzioni.php';
    } else {
        require_once __DIR__ . '/inc/user_convenzioni.php';
    }
    ?>
</body>
<?php
require_once __DIR__ . '/inc/footer.php';
?>

</html>