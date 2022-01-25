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

$f = 0;
echo "<div class='news-gap'></div>";

for ($i = $row - 1; $i >= 0; $i--) {
    if (($i % 2 == 0) && ($i != $row - 1)) {
        echo '</div>';
        $f = 0;
    }

    if ($i % 2 == 0) {
        echo '<div class="row row-news">';
        $f = 1;
    }

    echo '<div class="col-md-6 col-lg-6 col-sm-12 col-xs-12 header-container header-title-container news-wrap">
                <span class="header-title news-container th-lg">';

                if($tmp[$i]['title'] != "")    echo "<h4>".$tmp[$i]['title']."</h4>";
                echo '<span>';
                if($tmp[$i]['body'] != "") echo '<p>' . $tmp[$i]['body'] . '</p>';
                if($tmp[$i]['image_path'] != "")   echo '<img class="logoACSI-foo" src="https://storm-beaten-instan.000webhostapp.com/news/images/' . $tmp[$i]['image_path'] . '" alt="">';
                if($tmp[$i]['attachment_path'] != "")  echo '<iframe src="http://docs.google.com/gview?url=http://storm-beaten-instan.000webhostapp.com/news/attachments/' . $tmp[$i]['attachment_path'] . '&embedded=true" frameborder="0"></iframe>';
                echo '</span>

                </span>
          </div>';
}

if ($f) echo '</div>';