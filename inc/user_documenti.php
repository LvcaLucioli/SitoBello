<?php
$qr = "SELECT * FROM `categorie_documenti` WHERE 1";

//connessione al db ed esecuzione query
$connection = mysqli_connect($hostname, $username, $password, $db_name)
    or die("connessione fallita");

$risultato = mysqli_query($connection, $qr)
    or die("Query non valida: " . mysqli_error($connection));

$row = mysqli_num_rows($risultato);

$category = [];
//estrazione dati dal db e chiusura db
for ($i = 0; $i < $row; $i++) {
    $category[$i] = mysqli_fetch_assoc($risultato);
}
mysqli_close($connection);

echo "<div class='doc-gap'></div>";
for ($i = 0; $i < $row; $i++) {

    $qr = "SELECT * FROM `documenti` WHERE `category`='".$category[$i]['title']."'";

    //connessione al db ed esecuzione query
    $connection = mysqli_connect($hostname, $username, $password, $db_name)
        or die("connessione fallita");

    $risultato = mysqli_query($connection, $qr)
        or die("Query non valida: " . mysqli_error($connection));

    $row_doc = mysqli_num_rows($risultato);

    $documents = [];
    //estrazione dati dal db e chiusura db
    for ($c = 0; $c < $row_doc; $c++) {
        $documents[$c] = mysqli_fetch_assoc($risultato);
    }
    mysqli_close($connection);

    echo '<div class="row row-doc">
                <div class="col-12 header-container header-title-container doc-wrap">
                <span class="header-title doc-container">
                    <h4 class="sub-title" style="font-size: x-large">'.$category[$i]['title'].'</h4>
                    <ul>';

    for ($j = 0; $j < $row_doc; $j++){
        echo '<li><h5>
                    <a href="https://acsimacerata.com/documenti/'.$documents[$j]['path'].'" target="_blank">'
                        .$documents[$j]['title'].
                    '</a>
              </h5></li>';
                
    }

    echo "  </ul>
            </span>
            </div>
        </div>";
}