<div class="head-er">
	<header>
		<div class="row">
			<div class="col-4 header-container">
				<a href='index.php'>
					<img class="logoACSI" src="img\logoACSI.jpg" alt="Logo ACSI">
				</a>
			</div>

			<div class="col-4 header-container header-title-container gap">
				<span class="header-title">
					<h4>COMITATO PROVINCIALE DI MACERATA</h4>
					<span>
						<h5>Associazione di Cultura Sport e Tempo libero</h5>
					</span>
				</span>
			</div>

			<div class="col-4 header-container gap">
				<img class="logoConi" src="img\logoConi.png" alt="Logo Coni">
			</div>
		</div>
	</header>
	<nav>
		<div class="nav-bar">
			<ul>
				<?php
				$url= $_SERVER['REQUEST_URI']; 
				
				if (str_contains($url, "index")){
					echo "<li class='activee'><a href='index.php' class='active'>Home</a></li>";
				} else {
					echo "<li><a href='index.php'>Home</a></li>";
				}

				if (str_contains($url, "convenzioni")){
					echo "<li class='activee'><a href='convenzioni.php' class='active'>Convenzioni</a></li>";
				} else {
					echo "<li><a href='convenzioni.php'>Convenzioni</a></li>";
				}

				if (str_contains($url, "news")){
					echo "<li class='activee'><a href='news.php' class='active'>News</a></li>";
				} else {
					echo "<li><a href='news.php'>News</a></li>";
				}

				if (str_contains($url, "documenti")){
					echo "<li class='activee'><a href='documenti.php' class='active'>Documenti</a></li>";
				} else {
					echo "<li><a href='documenti.php'>Documenti</a></li>";
				}

				if (str_contains($url, "sport")){
					echo "<li class='activee'><a href='sport.php' class='active'>Sport convenzionati</a></li>";
				} else {
					echo "<li><a href='sport.php'>Sport convenzionati</a></li>";
				}
				?>
			</ul>
		</div>
	</nav>
</div>