<div class="head-er">
	<header>
		<div>
			<img class="img" src="img\logo.png" alt="Logo">
		</div>
	</header>
	<nav>
		<div class="nav-bar">
			<ul>
				<li><a href="Home.php" class="active">Home</a></li>
				<li><a href="convenzioni.php">Convenzioni</a></li>
				<li><a href="news.php">News</a></li>
				<li><a href="documenti.php">Documenti</a></li>

				<?php
				if (isset($_SESSION['user'])) {
					echo "<li><a href='ModificaUtente.php'>Ciao $_SESSION[user]</a></li>
							<li><a href='LogOut.php'>Log out</a></li>";
				} else {
					echo "<li><a href='Login.php'>Area riservata</a></li>";
				}
				?>
			</ul>
		</div>
	</nav>
</div>