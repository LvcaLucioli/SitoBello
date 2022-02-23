<?php

use Ilovepdf\CompressTask;

function ftp_upload(string $dest_file, int $type)
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
        if ($type == 0) {
            move_uploaded_file($_FILES["image_path"]["tmp_name"], "news/images/" . $dest_file);
        }
        if ($type == 1) {
            move_uploaded_file($_FILES["attachment_path"]["tmp_name"], "news/attachments/" . $dest_file);
            // file var keeps info about server file id, name...
            // it can be used latter to cancel file
            $myTask = new Ilovepdf\CompressTask('project_public_fe7d05db2f555516e59386339d7f0de1_PB4GF086ea043e7fc6da8725262dde0c5572f', 'secret_key_731123636b18460b13d7cc862325f4b5_mfiMr56a52460c6929a58058cd2352c57d34d');

            $file = $myTask->addFile('news/attachments/' . $dest_file);
            $dest_file = 'compressed_' . $file->filename;

            $myTask->setOutputFilename($dest_file);
            // process files
            $myTask->execute();
            // and finally download file. If no path is set, it will be downloaded on current folder
            $myTask->download('news/attachments/');

            my_ftp_delete($file->filename, 1);
        }
        if ($type == 2) {
            move_uploaded_file($_FILES["file_path"]["tmp_name"], "news/files/" . $dest_file);
        }
    }
    // close the FTP connection 
    ftp_close($ftp);
    return $dest_file;
}

function my_ftp_delete(string $target_file, int $type)
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
        ftp_chdir($ftp, "news");
        if ($type == 0) {
            ftp_chdir($ftp, "images");
        }
        if ($type == 1) {
            ftp_chdir($ftp, "attachments");
        }
        if ($type == 2) {
            ftp_chdir($ftp, "files");
        }
        ftp_delete($ftp, $target_file);
    }

    ftp_close($ftp);
}



$connection = mysqli_connect($hostname, $username, $password, $db_name)
    or die("connessione fallita");


if (isset($_POST['delete'])) {
    $get_file_query = "SELECT `image_path`, `attachment_path`, `file_path` FROM `news` WHERE `news_key`=" . $_POST['news_key'];
    $to_delete = mysqli_query($connection, $get_file_query)
        or die("Query non valida: " . mysqli_error($connection));
    if ($news = mysqli_fetch_assoc($to_delete)) {
        if ($news['image_path'] != "")   my_ftp_delete($news['image_path'], 0);
        if ($news['attachment_path'] != "") my_ftp_delete($news['attachment_path'], 1);
        if ($news['file_path'] != "") my_ftp_delete($news['file_path'], 2);
    }
    $delete_query = "DELETE FROM `news` WHERE `news_key` = '" . $_POST['news_key'] . "'";
    $risultato = mysqli_query($connection, $delete_query)
        or die("Query non valida: " . mysqli_error($connection));
    $_POST = array();
    Header('Location: ' . $_SERVER['PHP_SELF']);
    echo "<p class='conf_msg'>Eliminazione riuscita</p>";
}


if (isset($_POST['submit'])) { // if mauro is trying to upload or update a news
    $insert_query = "";
    $new_image = "";
    $new_attachment = "";
    $new_file = "";

    if ($_POST['news_key'] != "") { // updating case
        $check_query = "SELECT* FROM `news` WHERE `news_key` = '" . $_POST['news_key'] . "'";
        $isTheNewsPresent = mysqli_query($connection, $check_query)
            or die("Query non valida: " . mysqli_error($connection));

        if ($news = mysqli_fetch_assoc($isTheNewsPresent)) {
            // if mauro is trying to change image or attachment
            if ($news['image_path'] != $_FILES['image_path']['name']) {
                if ($_FILES['image_path']['name'] != "") { // if a new file is posted
                    $new_image = ftp_upload($news['news_key'] . $_FILES['image_path']['name'], 0); // upload file
                    if ($news['image_path'] != "") my_ftp_delete($news['image_path'], 0); // remove file if there was one
                }
            }

            if ($news['attachment_path'] != $_FILES['attachment_path']["name"]) {
                if ($_FILES['attachment_path']['name'] != "") {
                    $new_attachment = ftp_upload($news['news_key'] . $_FILES['attachment_path']['name'], 1);

                    if ($news['attachment_path'] != "") my_ftp_delete($news['attachment_path'], 1);
                    Header('Location: ' . $_SERVER['PHP_SELF']);
                }
            }

            if ($news['file_path'] != $_FILES['file_path']["name"]) {
                if ($_FILES['file_path']['name'] != "") {
                    $new_file = ftp_upload($news['news_key'] . $_FILES['file_path']['name'], 2);
                    if ($news['file_path'] != "") my_ftp_delete($news['file_path'], 2);
                }
            }

            if ($new_image == "") $new_image = $news['image_path'];
            if ($new_attachment == "") $new_attachment = $news['attachment_path'];
            if ($new_file == "") $new_file = $news['file_path'];

            $insert_query = "UPDATE `news` SET `title`='" . $_POST['title'] . "',`body`='" . $_POST['body'] . "',`image_path`='" . $new_image . "',`attachment_path`='" . $new_attachment . "',`file_path`='" . $new_file . "' WHERE `news_key`='" . $news['news_key'] . "'";
            $risultato = mysqli_query($connection, $insert_query)
                or die("Query non valida: " . mysqli_error($connection));
        }
        $_POST = array();
        Header('Location: ' . $_SERVER['PHP_SELF']);
        echo "<p class='conf_msg'>Modifica riuscita</p>";
    } else { // brand new news
        $insert_query = "INSERT INTO `news` (`title`, `body`) VALUES ('" . $_POST['title'] . "', '" . $_POST['body'] . "')";

        $risultato = mysqli_query($connection, $insert_query)
            or die("Query non valida: " . mysqli_error($connection));
        // should have news w/out any file

        if (($_FILES['image_path']['name'] != "") || ($_FILES['attachment_path']['name'] != "") || ($_FILES['file_path']['name'] != "")) {
            $get_key = "SELECT `news_key` FROM  `news` WHERE `title`='" . $_POST['title'] . "' AND `body`='" . $_POST['body'] . "'";
            $risultato = mysqli_query($connection, $get_key)
                or die("key: " . mysqli_error($connection));

            $key = mysqli_fetch_assoc($risultato);
            if ($_FILES['image_path']['name'] != "") $new_image = ftp_upload($key['news_key'] . $_FILES['image_path']['name'], 0);
            if ($_FILES['attachment_path']['name'] != "")   $new_attachment = ftp_upload($key['news_key'] . $_FILES['attachment_path']['name'], 1);
            if ($_FILES['file_path']['name'] != "") $new_file = ftp_upload($key['news_key'] . $_FILES['file_path']['name'], 2);

            $upload_files = "UPDATE `news` SET `image_path`='" . $new_image . "', `attachment_path`='" . $new_attachment . "', `file_path`='" . $new_file . "' WHERE `news_key`='" . $key['news_key'] . "'";
            $risultato = mysqli_query($connection, $upload_files)
                or die("logo: " . mysqli_error($connection));
        }
        $_POST = array();
        Header('Location: ' . $_SERVER['PHP_SELF']);
        echo "<p class='conf_msg'>Caricamento riuscito</p>";
    }
}

$qr = "SELECT * FROM `news` WHERE 1";

//connessione al db ed esecuzione query

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

// for uploading a news
echo '  <div class="col-md-6 col-lg-6 col-sm-12 col-xs-12 header-container header-title-container news-wrap" style="margin-top: 0;">
                <form id="upload_news" method="POST" action="" enctype="multipart/form-data">
                    <span class="header-title news-container" style="overflow: hidden;">
                    <h4 style="font-size: x-large;"><b>Nuova news</b></h4>
                    <input type="hidden" name="news_key">
                    
                    <div class="row" style="margin-top: 5%">
                        <div class="col-4" style="padding: 0"><h4 class="sub-title" style="font-size: medium; color: #779bcc;"><b>Titolo:</b></h4></div>
                        <div class="col-8" style="padding: 0">                            
                            <input class="in_text" type="text" name="title" required><br>
                        </div>
                    </div>
    
                    <span>
                        <div class="row" style="margin-top: 5%">
                            <div class="col-4" style="padding: 0"><h4 class="sub-title" style="font-size: medium; color: #779bcc;"><b>Testo notizia:</b></h4></div>
                            <div class="col-8" style="padding: 0">                            
                                <textarea class="mod_txtarea" name="body"></textarea>     
                            </div>
                        </div>
                        
                        <div class="row" style="margin-top: 9%">
                            <div class="col-4" style="padding: 0"><h4 class="sub-title" style="font-size: medium; color: #779bcc;"><b>Immagine:</b></h4></div>
                            <div class="col-8" style="padding: 0; align-content: left; overflow: hidden;">
                                <input style="padding: 0; align-content: left; overflow: hidden;"class="in_file" type="file" name="image_path"  accept="image/*"><br>
                            </div>
                        </div>
                        
                        <div class="row" style="margin-top: 3%">
                            <div class="col-4" style="padding: 0"><h4 class="sub-title" style="font-size: medium; color: #779bcc;"><b>PDF:</b></h4></div>
                            <div class="col-8" style="padding: 0; align-content: left; overflow: hidden;">
                                <input class="in_file" type="file" name="attachment_path" accept=".pdf"><br>
                            </div>
                        </div>

                        <div class="row" style="margin-top: 3%">
                            <div class="col-4" style="padding: 0"><h4 class="sub-title" style="font-size: medium; color: #779bcc;"><b>File allegato:</b></h4></div>
                            <div class="col-8" style="padding: 0; align-content: left; overflow: hidden;">
                                <input class="in_file" type="file" name="file_path"><br><br>
                            </div>
                        </div>';

echo '              <input class="btn_update" type="submit" name="submit" value="Carica"><br><br>';
echo '          </span>';
echo '      </span>
                </form>
          </div>';

for ($i = $row - 1; $i >= 0; $i--) {
    echo '  <div class="col-md-6 col-lg-6 col-sm-12 col-xs-12 header-container header-title-container news-wrap">
                <form id="upload_news" method="POST" action="" enctype="multipart/form-data">
                    <span class="header-title news-container" style="overflow: hidden;">';

    echo '          <input type="hidden" name="news_key" value="' . $tmp[$i]['news_key'] . '">';

    echo '          <div class="row" style="margin-top: 3%">
                        <div class="col-4" style="padding: 0"><h4 class="sub-title" style="font-size: medium; color: #779bcc;"><b>Titolo:</b></h4></div>
                        <div class="col-8" style="padding: 0">                            
                            <input class="in_text" type="text" name="title" value="' . $tmp[$i]['title'] . '"><br>
                        </div>
                    </div>';

    echo '          <span>';
    echo '              <div class="row" style="margin-top: 3%">
                            <div class="col-4" style="padding: 0"><h4 class="sub-title" style="font-size: medium; color: #779bcc;"><b>Testo notizia:</b></h4></div>
                            <div class="col-8" style="padding: 0">                            
                                <textarea class="mod_txtarea" name="body">' . $tmp[$i]['body'] . '</textarea>     
                            </div>
                        </div>
                        
                        <div class="row" style="margin-top: 12%">
                            <div class="col-4" style="padding: 0;"><h4 class="sub-title" style="font-size: medium; color: #779bcc;"><b>Immagine:</b></h4></div>
                            <div class="col-8" style="padding: 0; align-content: left; overflow: hidden;">
                                <input style="padding: 0; align-content: left; overflow: hidden;"class="in_file" type="file" name="image_path"  accept="image/*"><br>
                            </div>
                        </div>';

    if ($tmp[$i]['image_path'] != "")
        echo '<img  style="margin-top: 1%" class="news-img" src="https://acsimacerata.com/news/images/' . $tmp[$i]['image_path'] . '" alt="">';

    echo '  <div class="row" style="margin-top: 5%">
                <div class="col-4" style="padding: 0;"><h4 class="sub-title" style="font-size: medium; color: #779bcc;"><b>PDF:</b></h4></div>
                <div class="col-8" style="padding: 0; align-content: left; overflow: hidden;">
                    <input class="in_file" type="file" name="attachment_path" accept=".pdf"><br>
                </div>
            </div>';

    if ($tmp[$i]['attachment_path'] != "")
        echo '<div>
            <iframe style="margin-top: 1%" id="pdf-js-viewer" src="/web/viewer.html?file=https://acsimacerata.com/news/attachments/' . $tmp[$i]['attachment_path'] . '" title="webviewer" frameborder="0"></iframe>
        </div>';

    echo '  <div class="row" style="margin-top: 3%">
                <div class="col-4" style="padding: 0"><h4 class="sub-title" style="font-size: medium; color: #779bcc;"><b>File allegato:</b></h4></div>
                <div class="col-8" style="padding: 0; align-content: left; overflow: hidden;">
                    <input class="in_file" type="file" name="file_path"><br><br>
                </div>
            </div>';

    if ($tmp[$i]['file_path'] != "")
        echo '<div class="attachment-ad"><a href="https://acsimacerata.com/news/files/' . $tmp[$i]['file_path'] . '" target="_blank">Allegato caricato</a><br></div><br>';

    echo '              <input class="btn_update" type="submit" name="submit" value="Modifica"><br><br>';
    echo '              <input class="btn_delete" type="submit" name="delete" value="Cancella"><br><br>';
    echo '          </span>';
    echo '      </span>
                </form>
          </div>';
}

echo '</div>';
