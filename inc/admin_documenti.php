<?php


function ftp_upload(string $dest_file, string $source_file)
{
    $timeout = 90;
    $ftp_port = 21;
    $ftp_host = "acsimacerata.com";
    $ftp_user = "u338544383";
    $ftp_pass = "Q34uZUchpA8E-i$";

    $ftp = ftp_connect($ftp_host);
    $login_result = ftp_login($ftp, $ftp_user, $ftp_pass);

    // check connection
    if ((!$ftp) || (!$login_result)) {
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
    $ftp_host = "acsimacerata.com";
    $ftp_user = "u338544383";
    $ftp_pass = "Q34uZUchpA8E-i$";

    $ftp = ftp_connect($ftp_host);
    $login_result = ftp_login($ftp, $ftp_user, $ftp_pass);

    // check connection
    if ((!$ftp) || (!$login_result)) {
        exit;
    } else {
        ftp_chdir($ftp, "/public_html");
        ftp_chdir($ftp, "documenti");
        ftp_delete($ftp, $target_file);
    }
    // close the FTP connection 
    ftp_close($ftp);
}

$connection = mysqli_connect($hostname, $username, $password, $db_name)
    or die("connessione fallita");

if (isset($_POST['categoria_submit'])) {
    $insert_query = "INSERT INTO `categorie_documenti` (`title`) VALUES 
            ('" . $_POST['title'] . "')";
    $risultato = mysqli_query($connection, $insert_query)
        or die("Query non valida: " . mysqli_error($connection));
    $_POST = array();
    Header('Location: ' . $_SERVER['PHP_SELF']);
}

if (isset($_POST['documento_submit'])) {
    $insert_query = "INSERT INTO `documenti` (`title`, `category` ) VALUES 
            ('" . $_POST['title'] . "', '" . $_POST['category'] . "')";
    $risultato = mysqli_query($connection, $insert_query)
        or die("Query non valida: " . mysqli_error($connection));

    $get_key = "SELECT `document_key` FROM  `documenti` WHERE `title`='" . $_POST['title'] . "' AND `category`='" . $_POST['category'] . "'";
    $risultato = mysqli_query($connection, $get_key)
        or die("key: " . mysqli_error($connection));
    $document = "";
    $key = mysqli_fetch_assoc($risultato);
    if ($_FILES["path"]["name"] != "")   $document = ftp_upload($key['document_key'] . $_FILES["path"]["name"], $_FILES["path"]["name"]);

    $update_query = "UPDATE `documenti` SET `path`='" . $document . "' WHERE `document_key`='" . $key['document_key'] . "'";
    $risultato = mysqli_query($connection, $update_query)
        or die("logo: " . mysqli_error($connection));
    $_POST = array();
    Header('Location: ' . $_SERVER['PHP_SELF']);
}

if ((isset($_POST['edit_documento'])) && ($_POST['title'] != "")) {
    $edit_query = "UPDATE `documenti` SET `title`='" . $_POST['title'] . "' WHERE `path`='" . $_POST['path'] . "'";
    $risultato = mysqli_query($connection, $edit_query)
        or die("Query non valida: " . mysqli_error($connection));
    $_POST = array();
    Header('Location: ' . $_SERVER['PHP_SELF']);
}

if (isset($_POST['delete_documento'])) {
    $remove_query = "DELETE FROM `documenti` WHERE `path`='" . $_POST['path'] . "'";
    $risultato = mysqli_query($connection, $remove_query)
        or die("Query non valida: " . mysqli_error($connection));
    my_ftp_delete($_POST['path']);
    $_POST = array();
    Header('Location: ' . $_SERVER['PHP_SELF']);
}

if (isset($_POST['delete_categoria'])) {
    $get_paths_query = "SELECT `path` FROM `documenti` WHERE `category`='" . $_POST['category'] . "'";
    $risultato = mysqli_query($connection, $get_paths_query)
        or die("Query non valida: " . mysqli_error($connection));

    $row = mysqli_num_rows($risultato);

    $documents = [];
    for ($i = 0; $i < $row; $i++) {
        $documents[$i] = mysqli_fetch_assoc($risultato);
        my_ftp_delete($documents[$i]["path"]);
    }

    $delete_query = "DELETE FROM `documenti` WHERE `category`='" . $_POST['category'] . "'";
    $risultato = mysqli_query($connection, $delete_query)
        or die("Query non valida: " . mysqli_error($connection));

    $delete_query = "DELETE FROM `categorie_documenti` WHERE `title`='" . $_POST['category'] . "'";
    $risultato = mysqli_query($connection, $delete_query)
        or die("Query non valida: " . mysqli_error($connection));
    $_POST = array();
    Header('Location: ' . $_SERVER['PHP_SELF']);
}

if ((isset($_POST['edit_categoria'])) && ($_POST['title'] != "")) {
    $edit_query = "UPDATE `categorie_documenti` SET `title`='" . $_POST['title'] . "' WHERE `cat_key`='" . $_POST['cat_key'] . "'";
    $risultato = mysqli_query($connection, $edit_query)
        or die("Query non valida: " . mysqli_error($connection));
    $_POST = array();
    Header('Location: ' . $_SERVER['PHP_SELF']);
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

echo '  <div class="row row-doc">
                <div class="col-12 header-container header-title-container doc-wrap">
                    <span class="header-title doc-container">
                        
                        <h4 class="sub-title" style="font-size: x-large">
                            <form method="POST" name="edit_category">
                            
                                <div class="row"">
                                    <div class="col-md-4 col-lg-4 col-sm-6 col-xs-6">Nuova categoria:</div>
                                    <div class="col-md-4 col-lg-4 col-sm-6 col-xs-6" style="padding: 0;">     
                                        <input class="in_text cat_text" type="text" name="title">
                                    </div>
                                    <div class="col-md-4 col-lg-4 col-sm-6 col-xs-6" style="padding: 0;">
                                        <input class="btn_update" type="submit" name="categoria_submit" value="Carica categoria">
                                    </div>
                                </div>
                            </form>
                        </h4>
                    </span>
                </div>
            </div>';
            
            
for ($i = 0; $i < $row; $i++) {

    $qr = "SELECT * FROM `documenti` WHERE `category`='" . $category[$i]['title'] . "'";

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
                        
                        <h4 class="sub-title" style="font-size: x-large">
                            <form method="POST" name="edit_category">
                            
                                <div class="row"">
                                    <div class="col-md-3 col-lg-3 col-sm-6 col-xs-6">Nome categoria:</div>
                                    <div class="col-md-3 col-lg-3 col-sm-6 col-xs-6" style="padding: 0;">
                                        <input class="in_text cat_text" type="text" name="title" value="' . $category[$i]['title'] . '">
                                    </div>
                                    <div class="col-md-3 col-lg-3 col-sm-6 col-xs-6" style="padding: 0;">
                                        <input class="btn_update" type="submit" name="edit_categoria" value="Modifica">
                                    </div>
                                    <div class="col-md-3 col-lg-3 col-sm-6 col-xs-6" style="padding: 0;">
                                        <input class="btn_delete" type="submit" name="delete_categoria" value="Elimina">
                                    </div>
                                </div>
                                
                                <input type="hidden" name="cat_key" value="' . $category[$i]['cat_key'] . '">
                                <input type="hidden" name="category" value="' . $category[$i]['title'] . '">
                            </form>
                        </h4>
                        
                        
                        <ul>';

    for ($j = 0; $j < $row_doc; $j++) {
        echo '              <li>
                                <h5>
                                    <form method="POST" name="edit_documento">
                                        <div class="row"">
                                            <div class="col-md-3 col-lg-3 col-sm-6 col-xs-6"><a href="https://acsimacerata.com/documenti/' . $documents[$j]['path'] . '"  target="_blank">' . $documents[$j]['title'] . '</a></div>
                                            <div class="col-md-3 col-lg-3 col-sm-5 col-xs-5" style="padding: 0;">
                                                <input class="in_text text2" type="text" name="title" value="' . $documents[$i]['title'] . '">
                                            </div>
                                            <div class="col-md-3 col-lg-3 col-sm-6 col-xs-6 b1">
                                                <input class="btn_update" type="submit" name="edit_documento" value="Modifica nome">
                                            </div>
                                            <div class="col-md-3 col-lg-3 col-sm-6 col-xs-6" style="padding: 0;">                            
                                                <input class="btn_delete" type="submit" name="delete_documento" value="Elimina">
                                            </div>
                                        </div>
                                        
                                        <input type="hidden" name="category" value="' . $documents[$j]['category'] . '">
                                        <input type="hidden" name="path" value="' . $documents[$j]['path'] . '">
                                    </form>
                                </h5>
                            </li>';
    }
    echo '                  <h4 class="sub-title" style="font-size: x-large; background-color: white; padding: 0; margin-top: 3%;">Nuovo documento:</h4>
                            <li style="margin-top: 0.5%;">
                                <h5>
                                    <form method="POST" enctype="multipart/form-data">
                                        <div class="row"">
                                            <div class="col-md-1 col-lg-1 col-sm-4 col-xs-4" style="margin-top: 0.2%;">Titolo:</div>
                                            <div class="col-md-3 col-lg-3 col-sm-6 col-xs-6" style="padding: 0;">
                                                <input class="in_text text2" type="text" name="title" required>
                                            </div>
                                            <div class="col-1"></div>
                                            <div class="col-md-1 col-lg-1 col-sm-4 col-xs-4" style="margin-top: 0.2%;">File:</div>
                                            <div class="col-md-3 col-lg-3 col-sm-6 col-xs-6" style="padding: 0;">
                                                <input class="in_file" type="file" name="path" required>
                                            </div>
                                            <div class="col-md-3 col-lg-3 col-sm-6 col-xs-6" style="padding: 0;">
                                                <input class="btn_update" type="submit" name="documento_submit" value="Carica">
                                            </div>
                                        </div>
                                        
                                        <input type="hidden" name="category" value="' . $category[$i]['title'] . '">
                                    </form>
                                </h5>
                            </li>
                        </ul>
                    </span>
                </div>
            </div>';
}
