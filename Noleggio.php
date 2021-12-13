<?php
	session_start();
	
	$_SESSION['previousPage'] = 'Noleggio.php';
?>

<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8">
        <link rel="shortout icon" href="favicon.ico">
        <meta name="viewport" content="width=device-width, initial-scale=1">
		<link rel="stylesheet" type="text/css" href="css\stile_home.css">
        <link rel="stylesheet" type="text/css" href="css\bootstrap\bootstrap.css">
        <link href='https://fonts.googleapis.com/css?family=Nunito:400,300' rel='stylesheet' type='text/css'>
        <title>Noleggia il tuo monopattino</title>
    </head>
	
    <body>
        <?php
			require 'inc\header.php';
		?>
		
		<nav><!-- menù superiore -->
			<div class="conteiner-fluid">
				<div>
					<ul>
						<li><a href="Home.php">Home</a></li>
						<li><a href="Noleggio.php" class="active">Noleggia</a></li>
						<li><a href="#">Contatti</a></li>
						<li><a href="#">Informazioni</a></li>
					</ul>
					
					<?php
					if (isset($_SESSION['user'])){
						echo "<ul class='accessi nav navbar-nav navbar-right' style='margin-top: -53px; margin-right: 0;'>
								<li><a href='ModificaUtente.php'>Ciao $_SESSION[user]</a></li>
								<li><a href='LogOut.php'>Log out</a></li>
							  </ul>";
					}else{
						echo "<ul class='accessi nav navbar-nav navbar-right' style='margin-top: -53px; margin-right: 0;'>
								<li><a href='Login.php'>Accedi</a></li>
								<li><a href='Registrazione.php'>Registrati</a></li>
							  </ul>";
					}
					?>
				</div>
			</div>
		</nav>
		
		
    </body>
</html>