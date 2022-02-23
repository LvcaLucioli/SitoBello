<?php


function ftp_upload(string $source_file)
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
        $source_file = "sport/" . $source_file;
        move_uploaded_file($_FILES["path"]["tmp_name"], $source_file);
    }
    // close the FTP connection 
    ftp_close($ftp);
    return $source_file;
    // you can call task class directly
    // to get your key pair, please visit https://developer.ilovepdf.com/user/projects

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
        ftp_chdir($ftp, "sport");
        ftp_delete($ftp, $target_file);
    }
    // close the FTP connection 
    ftp_close($ftp);
}

if (isset($_POST['upload_sport'])) {
    my_ftp_delete($tmp['path']);
    $source_file = ftp_upload($_FILES['path']['name']);

    $myTask = new Ilovepdf\CompressTask('project_public_fe7d05db2f555516e59386339d7f0de1_PB4GF086ea043e7fc6da8725262dde0c5572f', 'secret_key_731123636b18460b13d7cc862325f4b5_mfiMr56a52460c6929a58058cd2352c57d34d');

    //echo $source_file;
    //var_dump($myTask);
    // file var keeps info about server file id, name...
    // it can be used latter to cancel file
    $file = $myTask->addFile($source_file);

    $myTask->setOutputFilename('compressed_' . $file->filename);
    // process files

    $myTask->execute();

    // and finally download file. If no path is set, it will be downloaded on current folder
    $myTask->download('sport/');

    $edit_query = "UPDATE `sport` SET `path`='compressed_" . $_FILES['path']['name'] . "' WHERE `sport_key`='" . $_POST['sport_key'] . "'";
    $risultato = mysqli_query($connection, $edit_query)
        or die("Query non valida: " . mysqli_error($connection));
    my_ftp_delete($_FILES['path']['name']);
    $_POST = array();
    Header('Location: ' . $_SERVER['PHP_SELF']);
}

echo '  <form method="POST" enctype="multipart/form-data">
            <input type="hidden" name="sport_key" value="' . $tmp['sport_key'] . '">
            
            <div class="row" style="margin-top: 1%; margin-bottom: 1%;">
                <div class="col-8 input-sport" style="padding-top: 0.5%;">
                    <input type="file" name="path" accept="application/pdf" required>
                </div>
                <div class="col-4" style="padding: 0;">
                    <input class="btn" type="submit" name="upload_sport" value="Carica">
                </div>
            </div>
        </form>';
