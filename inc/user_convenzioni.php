<?php
$qr = "SELECT * FROM `conventions` WHERE 1";

//connessione al db ed esecuzione query
$connection = mysqli_connect($hostname, $username, $password, $db_name)
    or die("connessione fallita");

$risultato = mysqli_query($connection, $qr)
    or die("Query non valida: " . mysqli_error($connection));

$row = mysqli_num_rows($risultato);

$tmp = [];
//estrazione dati dal db e chiusura db
for ($i = 0; $i < $row; $i++) {
    $tmp[$i] = mysqli_fetch_assoc($risultato);
}
mysqli_close($connection);

echo '<div class="row">';
for ($i = 0; $i < $row; $i++) {
    echo '
            <div class="col-4 header-container header-title-container gap">
                <span class="header-title">
                    <h4>'.$tmp[$i]['company_name'].'</h4>
                    <span>
                        <h5>'.$tmp[$i]['city'].'</h5>
                        <h5>'.$tmp[$i]['phone'].'</h5>
                        <h5>'.$tmp[$i]['address'].'</h5>
                        <h5>'.$tmp[$i]['description'].'</h5>
                        <img class="logoACSI-foo" src="https://github.com/LvcaLucioli/SitoBello/blob/conventions/'.$tmp[$i]['logo_path'].'?raw=true" alt="">
                    </span>
                </span>
            </div>
        ';
}
if (isset($_SESSION['user'])) {
    require_once __DIR__ . '/admin_convenzioni.php';
}
echo '</div>';
