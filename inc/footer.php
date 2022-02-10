<div class="foo-ter" style="bottom:0;">
    <footer>
        <div class="row">
            <div class="col-4 header-container header-title-container">
                <span class="header-title">
                    <h4>Contatti</h4>
                    <span>
                        <h5>Scriveteci</h5>
                    </span>
                </span>
            </div>
            
            <?php
                if (isset($_SESSION['user'])) {
                    echo "<div class='col-4 header-container header-title-container'>
                            <span class='header-title'>
                                <h4 style='font-size: medium; margin-top: 7%;'>Accesso effettuato come Amministratore</h4>
                                <span>
                                <a href='LogOut.php'><h5 style='color: #f28383;'>Logout</h5></a>
                                </span>
                            </span>
                          </div>";
                } else {
                    echo "<div class='col-4 header-container'>
                            <a href='Login.php'>
                                <img class='logoACSI-foo' src='img\logoACSI.jpg' alt='Logo ACSI'>
                            </a>
                          </div>";
                }
            ?>
            
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