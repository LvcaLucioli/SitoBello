<nav class="navbar navbar-expand-lg navbar-light bg-linght "><!-- menù superiore -->
    <div class="collapse navbar-collapse" id="navbarSupportedContent">
        <ul class="navbar-nav mr-auto">
            <li class="nav-item active">
                <a class="nav-link" href="index.php">Home <span class="sr-only">(current)</span></a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="convenzioni.php">Convenzioni</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="settori.php">Settori</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="documenti.php">Documenti online</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="contatti.php">Contatti</a>
            </li>
            <?php
            if (isset($_SESSION['user'])){
                echo "<li class='nav-item'>
                    <a class='nav-link' href='admin.php'>Ciao $_SESSION[user]</a>
                    </li>
                    <li class='nav-item'>
                    <a class='nav-link' href='logout.php'>Esci</a>
                    </li>
                    ";
            }else{
                echo "<li class='nav-item'><a class='nav-link'href='login.php'>Area riservata</a></li>";
            }
            ?>
        </ul>
           
    </div>
</nav>