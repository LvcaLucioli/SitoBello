<div class="foo-ter" style="bottom:0;">
    <footer>
        <div class="row row-cust">
            <div class="col-4 header-container header-title-container gap">
                <span class="header-title">
                    <h4>Contatti</h4>
                    <span>
                        <h5>Scriveteci</h5>
                    </span>
                </span>
            </div>
            <div class="col-4 header-container">
                <?php
				if (isset($_SESSION['user'])) {
					echo "<a href='LogOut.php'>
                                Esci
                          </a>";
				} else {
					echo "<a href='Login.php'>
								<img class='logoACSI-foo' src='img\logoACSI.jpg' alt='Logo ACSI'>
						  </a>";
				}
				?>
            </div>
            <div class="col-4 header-container header-title-container">
                <span class="header-title">
                    <h4>SIAMO QUI</h4>
                    <span>
                        <h5>Venite a trovarci</h5>
                    </span>
                </span>
            </div>
        </div>
    </footer>
</div>
<br>