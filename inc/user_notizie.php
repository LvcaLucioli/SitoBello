<?php
$qr = "SELECT `title`, `body`, `image_path`, `attachment_path`, `flyer_path` FROM `news` WHERE 1";

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
    echo '<div class="col-4 header-container header-title-container gap">
                <span class="header-title">';
                if(isset($tmp[$i]['title']))    echo '<h4>' . $tmp[$i]['title'] . '</h4>';
                    echo '<span>';
                    if(isset($tmp[$i]['body'])) echo '<h5>' . $tmp[$i]['body'] . '</h5>';
                    if(isset($tmp[$i]['image_path']))   echo '<img class="logoACSI-foo" src="https://storm-beaten-instan.000webhostapp.com/news/images/' . $tmp[$i]['image_path'] . '" alt="">';
                    if(isset($tmp[$i]['attachment_path']))  echo '<iframe src="http://docs.google.com/gview?url=http://storm-beaten-instan.000webhostapp.com/news/attachments/' . $tmp[$i]['attachment_path'] . '&embedded=true" style="width:600px; height:500px;" frameborder="0"></iframe>';
                    echo '
                    </span>
                </span>
            </div>
        ';
}

if (isset($_SESSION['user'])) {
    require_once __DIR__ . '/admin_notizie.php';
}
echo '</div>';
