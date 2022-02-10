<?php

function ftp_upload(string $source_file)
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
        $source_file = "sport/".$source_file;
        move_uploaded_file($_FILES["path"]["tmp_name"], $source_file);
    }
    // close the FTP connection 
    ftp_close($ftp);
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
        ftp_chdir($ftp, "sport");
        ftp_delete($ftp, $target_file);
    }
    // close the FTP connection 
    ftp_close($ftp);
}

if(isset($_POST['upload_sport'])){
    my_ftp_delete($tmp['path']);
    $edit_query = "UPDATE `sport` SET `path`='" . $_FILES['path']['name'] . "' WHERE `sport_key`='" . $_POST['sport_key'] . "'";
    $risultato = mysqli_query($connection, $edit_query)
        or die("Query non valida: " . mysqli_error($connection));
    ftp_upload($_FILES['path']['name']);
}

echo '  <form method="POST" enctype="multipart/form-data">
            <input type="file" name="path">
            <input type="hidden" name="sport_key" value="'.$tmp['sport_key'].'">
            <input type="submit" name="upload_sport" value="aggiorna">
        </form>';