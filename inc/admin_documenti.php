<?php


function ftp_upload(string $dest_file, string $source_file)
{
    $timeout = 90;
    $ftp_port = 21;
    $ftp_host = "acsimacerata.site";
    $ftp_user = "u338544383";
    $ftp_pass = "Q34uZUchpA8E-i$";

    $ftp = ftp_connect($ftp_host);
    $login_result = ftp_login($ftp, $ftp_user, $ftp_pass);

    // check connection
    if ((!$ftp) || (!$login_result)) {
        echo "FTP connection has failed!";
        exit;
    } else {
        ftp_chdir($ftp, "/public_html");
        ftp_chdir($ftp, "documenti");
        move_uploaded_file($_FILES["path"]["tmp_name"], $source_file);

        $upload = ftp_put($ftp, $dest_file, $source_file, FTP_BINARY);

        // check upload status
        if (!$upload) {
            echo "FTP upload has failed!";
        } else {
            echo "Uploaded $source_file to $ftp_host as $dest_file";
        }
    }
    // close the FTP connection 
    ftp_close($ftp);
    return $dest_file;
}


function my_ftp_delete(string $target_file)
{
    $timeout = 90;
    $ftp_port = 21;
    $ftp_host = "acsimacerata.site";
    $ftp_user = "u338544383";
    $ftp_pass = "Q34uZUchpA8E-i$";

    $ftp = ftp_connect($ftp_host);
    $login_result = ftp_login($ftp, $ftp_user, $ftp_pass);

    // check connection
    if ((!$ftp) || (!$login_result)) {
        echo "FTP connection has failed!";
        //echo "Attempted to connect to $ftp_server for user $ftp_user_name"; 
        exit;
    } else {
        ftp_chdir($ftp, "/public_html");
        ftp_chdir($ftp, "documenti");

        if (ftp_delete($ftp, $target_file)) {
            echo "$target_file deleted successful\n";
        } else {
            echo "could not delete $target_file\n";
        }
    }
    // close the FTP connection 
    ftp_close($ftp);
}

$connection = mysqli_connect($hostname, $username, $password, $db_name)
    or die("connessione fallita");

if (isset($_POST['category_upload'])) {
    $insert_query = "INSERT INTO `categorie_documenti` (`title``) VALUES 
            ('" . $_POST['category_title'] . "')";
    $risultato = mysqli_query($connection, $insert_query)
        or die("Query non valida: " . mysqli_error($connection));
}

if (isset($_POST['document_upload'])) { 
    $insert_query = "INSERT INTO `documenti` (`title`, `path`, `category` ) VALUES 
            ('" . $_POST['category_title'] . "', '" . $_POST['path'] . "', '" . $_POST['category'] . "')";
    $risultato = mysqli_query($connection, $insert_query)
        or die("Query non valida: " . mysqli_error($connection));
}






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

echo "  <div class='doc-gap'></div>";
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

    echo '  <div class="row row-doc">
                <div class="col-12 header-container header-title-container doc-wrap">
                    <span class="header-title doc-container">
                        <h4 class="sub-title" style="font-size: x-large">'.$category[$i]['title'].'</h4>
                        <ul>';
    
    for ($j = 0; $j < $row_doc; $j++){
            echo '          <li><h5>
                                <a href="'.$documents[$j]['path'].'">'
                                    .$documents[$j]['title'].
                                '</a>
                            </h5></li>';
    }

    echo '              </ul>
                        <form id="documenti" method="POST" enctype="multipart/form-data">
                            <input type="file" name="path"><br>
                        </form> 
                    </span>
                </div>
            </div>';
}

