<?php
$qr = "SELECT `title`, `body`, `image_path`, `attachment_path`, `file_path` FROM `news` WHERE 1";

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

echo "<div class='news-gap'></div>";
echo '<div class="row row-news">';
for ($i = $row - 1; $i >= 0; $i--) {
    echo '<div class="col-md-6 col-lg-6 col-sm-12 col-xs-12 header-container header-title-container news-wrap">
                <span class="header-title news-container">';

    if ($tmp[$i]['title'] != "")    echo "<h4>" . $tmp[$i]['title'] . "</h4>";
    echo '<span>';

    if ($tmp[$i]['body'] != "") echo '<p>' . $tmp[$i]['body'] . '</p>';

    if ($tmp[$i]['image_path'] != "")   echo '<img class="logoACSI-foo" src="https://acsimacerata.com/news/images/' . $tmp[$i]['image_path'] . '" alt="">';
    
    if ($tmp[$i]['attachment_path'] != "")
    echo '<div>
            <iframe id="pdf-js-viewer" src="/web/viewer.html?file=https://acsimacerata.com/news/attachments/' . $tmp[$i]['attachment_path'] . '" title="webviewer" frameborder="0" width="500" height="600"></iframe>
          </div>';

    if ($tmp[$i]['file_path'] != "")
    echo '<div class="attachment"><a href="https://acsimacerata.com/news/files/' . $tmp[$i]['file_path'] . '" target="_blank">Apri allegato</a></div>';

    echo '</span>
                </span>
          </div>';
}
echo '</div>';
