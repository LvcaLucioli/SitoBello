<nav><!-- menù superiore -->
    <div class="conteiner-fluid">
        <div>
            <ul>
                <li><a href="index.php" class="active">Home</a></li>
                <li><a href="convenzioni.php">Convenzioni</a></li>
                <li><a href="settori.php">Settori</a></li>
                <li><a href="news.php">News</a></li>
                <li><a href="documenti.php">Documenti online</a></li>
                <li><a href="contatti.php">Contatti</a></li>
            </ul>
            
            <?php
            if (isset($_SESSION['user'])){
                echo "<ul class='accessi nav navbar-nav navbar-right' style='margin-top: -53px; margin-right: 0;'>
                        <li><a href='admin.php'>Ciao $_SESSION[user]</a></li>
                        <li><a href='logout.php'>Esci</a></li>
                        </ul>";
            }else{
                echo "<ul class='accessi nav navbar-nav navbar-right' style='margin-top: -53px; margin-right: 0;'>
                        <li><a href='login.php'>Area riservata</a></li>
                        </ul>";
            }
            ?>
        </div>
    </div>
</nav>