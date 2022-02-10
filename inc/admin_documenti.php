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
}

if (isset($_POST['documento_submit'])) {
    $insert_query = "INSERT INTO `documenti` (`title`, `path`, `category` ) VALUES 
            ('" . $_POST['title'] . "', '" . $_FILES["path"]["name"] . "', '" . $_POST['category'] . "')";
    $risultato = mysqli_query($connection, $insert_query)
        or die("Query non valida: " . mysqli_error($connection));
    ftp_upload($_FILES["path"]["name"], $_FILES["path"]["name"]);
}

if (isset($_POST['edit_documento'])) {
    $edit_query = "UPDATE `documenti` SET `title`='" . $_POST['title'] . "' WHERE `path`='" . $_POST['path'] . "'";
    $risultato = mysqli_query($connection, $edit_query)
        or die("Query non valida: " . mysqli_error($connection));
}

if (isset($_POST['delete_documento'])) {
    $remove_query = "DELETE FROM `documenti` WHERE `path`='" . $_POST['path'] . "'";
    $risultato = mysqli_query($connection, $remove_query)
        or die("Query non valida: " . mysqli_error($connection));
    my_ftp_delete($_POST['path']);
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
}

if (isset($_POST['edit_categoria'])) {
    $edit_query = "UPDATE `categorie_documenti` SET `title`='" . $_POST['title'] . "' WHERE `cat_key`='" . $_POST['cat_key'] . "'";
    $risultato = mysqli_query($connection, $edit_query)
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
                        <h4 class="sub-title" style="font-size: x-large">' . $category[$i]['title'] . '
                            <form method="POST" name="edit_category">
                                <input type="text" name="title">
                                <input type="hidden" name="cat_key" value="' . $category[$i]['cat_key'] . '">
                                <input type="hidden" name="category" value="' . $category[$i]['title'] . '">
                                <input type="submit" name="edit_categoria" value="modifica categoria">
                                <input type="submit" name="delete_categoria" value="elimina tutta la categoria">
                            </form>
                        </h4>
                        <ul>';

    for ($j = 0; $j < $row_doc; $j++) {
        echo '              <li>
                                <h5>
                                    <a href="' . $documents[$j]['path'] . '"  target="_blank">' . $documents[$j]['title'] . '</a>
                                    <form method="POST" name="edit_documento">
                                        <input type="text" name="title">
                                        <input type="hidden" name="category" value="' . $documents[$j]['category'] . '">
                                        <input type="hidden" name="path" value="' . $documents[$j]['path'] . '">
                                        <input type="submit" name="edit_documento" value="modifica nome">
                                        <input type="submit" name="delete_documento" value="elimina">
                                    </form>
                                </h5>
                            </li>';
    }
    echo '              </ul>
                        <form method="POST" enctype="multipart/form-data">
                            <input type="hidden" name="category" value="' . $category[$i]['title'] . '">
                            titolo<input type="text" name="title"><br>
                            <input type="file" name="path">
                            <input type="submit" name="documento_submit" value="nuovo documento">
                        </form> 
                    </span>
                </div>
            </div>';
}
echo '<form method="POST" enctype="multipart/form-data">
            <input type="text" name="title"><br>
            <input type="submit" name="categoria_submit" value="nuova categoria">
        </form>';
