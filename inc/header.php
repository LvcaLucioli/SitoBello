<div style="border: 3px solid #ff8000;">
	<header>
		<div>
			<img class="img" src="img\logo.png" alt="Logo">
		</div>
	</header>
	<nav>
		<!-- menù superiore -->
		<div class="nav-bar">
			<ul>
				<li><a href="Home.php" class="active">Home</a></li>
				<li><a href="Noleggio.php">Noleggia</a></li>
				<li><a href="#">Contatti</a></li>
				<li><a href="#">Informazioni</a></li>

				<?php
				if (isset($_SESSION['user'])) {
					echo "
										<li><a href='ModificaUtente.php'>Ciao $_SESSION[user]</a></li>
										<li><a href='LogOut.php'>Log out</a></li>
									";
				} else {
					echo "
										<li><a href='Login.php'>Accedi</a></li>
										<li><a href='Registrazione.php'>Registrati</a></li>
									";
				}
				?>
			</ul>
		</div>
	</nav>
</div>