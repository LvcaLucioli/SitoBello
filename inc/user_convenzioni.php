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

$f = 0;
echo "<div class='conv-gap'></div>";

for ($i = 0; $i < $row; $i++) {
    if ($f == 2) {
        echo '</div>';
        $f = 0;
    }

    if ($f == 0) {
        echo '<div class="row row-conv">';
        $f++;
    }

    echo '<div class="col-md-4 col-lg-4 col-sm-12 col-xs-12 header-container header-title-container conv-wrap">
            <span class="header-title conv-container th-lg">
                    <span>
                        <h4>'.$tmp[$i]['company_name'].'</h4>
                        <img class="logoACSI-foo" src="https://acsimacerata.site/convenzioni/'.$tmp[$i]['logo_path'].'" alt="">
                        
                        <h4 class="sub-title" style="font-size: medium; color: #779bcc; padding: 0;"><b>Descrizione:</b></h4>
                        <h5>'.$tmp[$i]['description'].'</h5>
                        
                        <div class="row" style="margin-top: 3%">
                        <div class="col-3"><h4 class="sub-title" style="font-size: medium; color: #779bcc;"><b>Indirizzo:</b></h4></div>
                        <div class="col-8"><h5>'.$tmp[$i]['address'].'</h5></div>
                        </div>

                        <div class="row" style="margin-top: 3%">
                        <div class="col-3"><h4 class="sub-title" style="font-size: medium; color: #779bcc;"><b>Città:</b></h4></div>
                        <div class="col-8"><h5>'.$tmp[$i]['city'].'</h5></div>
                        </div>

                        <div class="row" style="margin-top: 3%">
                        <div class="col-3"><h4 class="sub-title" style="font-size: medium; color: #779bcc;"><b>Telefono:</b></h4></div>
                        <div class="col-8"><h5>'.$tmp[$i]['phone'].'</h5></div>
                        </div>
                    </span>
                </span>
            </div>
        ';
}

if ($f) echo '</div>';
