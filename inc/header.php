<div class="head-er">
	<header>
		<div class="row">
			<div class="col-lg-4 header-container">
				<img class="logoACSI" src="img\logoACSI.png" alt="Logo ACSI">
			</div>
			
			<div class="col-lg-4 header-container header-title-container gap">
				<span class="header-title">
					<h4>COMITATO PROVINCIALE DI MACERATA</h4>
					<span><h5>Associazione di Cultura Sport e Tempo libero</h5></span>
				</span>
			</div>
			
			<div class="col-lg-4 header-container gap">
				<img class="logoConi" src="img\logoConi.png" alt="Logo Coni">
			</div>
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
					echo "<li>
							<a style='color: #f28383' href='Login.php'>
								Area riservata
							</a>
						  </li>";
				}
				?>
			</ul>
		</div>
	</nav>
</div>