<?php

function ftp_upload(string $dest_file, string $source_file, int $type)
{
    // 0 = image
    // 1 = pdf
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
        echo "connesso bro";
        if ($type == 0) {
            // ftp_chdir($ftp, "/public_html");
            // ftp_chdir($ftp, "news");
            // ftp_chdir($ftp, "images");
            $source_file = "news/images/" . $source_file;
            move_uploaded_file($_FILES["image_path"]["tmp_name"], $source_file);
        }
        if ($type == 1) {
            // ftp_chdir($ftp, "/public_html");
            // ftp_chdir($ftp, "news");
            // ftp_chdir($ftp, "attachments");
            $source_file = "news/attachments/" . $source_file;
            move_uploaded_file($_FILES["attachment_path"]["tmp_name"], $source_file);
        }

        // $upload = ftp_put($ftp, $dest_file, $source_file, FTP_BINARY);

        // // check upload status
        // if (!$upload) {
        //     echo "FTP upload has failed!";
        // } else {
        //     echo "Uploaded $source_file to $ftp_host as $dest_file";
        // }
    }
    // close the FTP connection 
    ftp_close($ftp);
    return $dest_file;
}

function my_ftp_delete(string $target_file, int $type)
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
        ftp_chdir($ftp, "news");
        if ($type == 0) {
            ftp_chdir($ftp, "images");
        }
        if ($type == 1) {
            ftp_chdir($ftp, "attachments");
        }
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


if (isset($_POST['delete'])) {
    $get_file_query = "SELECT `image_path`, `attachment_path` FROM `news` WHERE `news_key`=" . $_POST['news_key'];
    $to_delete = mysqli_query($connection, $get_file_query)
        or die("Query non valida: " . mysqli_error($connection));
    if ($news = mysqli_fetch_assoc($to_delete)) {
        my_ftp_delete($news['image_path'], 0);
        my_ftp_delete($news['attachment_path'], 1);
    }

    $delete_query = "DELETE FROM `news` WHERE `news_key` = '" . $_POST['news_key'] . "'";
    $risultato = mysqli_query($connection, $delete_query)
        or die("Query non valida: " . mysqli_error($connection));
}

if (isset($_POST['submit'])) { // if mauro is trying to upload or update a news
    $insert_query = "";
    if ($_FILES["image_path"]["name"] != "") {
        $dest_image = ftp_upload($_FILES["image_path"]["name"], $_FILES["image_path"]["name"], 0);
    }
    if ($_FILES["attachment_path"]["name"] != "") {
        $dest_pdf = ftp_upload($_FILES["attachment_path"]["name"], $_FILES["attachment_path"]["name"], 1);
    }

    if (isset($_POST['news_key'])) {
        $check_query = "SELECT* FROM `news` WHERE `news_key` = '" . $_POST['news_key'] . "'";
        $isTheNewsPresent = mysqli_query($connection, $check_query)
            or die("Query non valida: " . mysqli_error($connection));

        if ($news = mysqli_fetch_assoc($isTheNewsPresent)) {
            if (!isset($dest_image)) $dest_image = $news['image_path'];
            if (!isset($dest_pdf)) $dest_pdf = $news['attachment_path'];
            $insert_query = "UPDATE `news` SET `title`='" . $_POST['title'] . "',`body`='" . $_POST['body'] . "',`image_path`='" . $dest_image . "',`attachment_path`='" . $dest_pdf . "',`flyer_path`='" . $news['flyer_path'] . "' WHERE `news_key`='" . $news['news_key'] . "'";
        }
    } else {
        if (!isset($dest_image))  $dest_image = "";
        if (!isset($dest_pdf))  $dest_pdf = "";
        $insert_query = "INSERT INTO `news` (`title`, `body`, `image_path`, `attachment_path`) VALUES ('" . $_POST['title'] . "', '" . $_POST['body'] . "', '" . $dest_image . "', '" . $dest_pdf . "')";
    }

    $risultato = mysqli_query($connection, $insert_query)
        or die("Query non valida: " . mysqli_error($connection));
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


$f = 0;
echo "<div class='news-gap'></div>";

for ($i = $row - 1; $i >= 0; $i--) {
    if ($f == 2) {
        echo '</div>';
        $f = 0;
    }

    if ($f == 0) {
        echo '<div class="row row-news">';
        $f++;
    }

    echo '  <div class="col-md-6 col-lg-6 col-sm-12 col-xs-12 header-container header-title-container news-wrap">
                <form id="upload_news" method="POST" action="" enctype="multipart/form-data">
                    <span class="header-title news-container th-lg">';
    echo '          <input type="hidden" name="news_key" value="' . $tmp[$i]['news_key'] . '"><br>';
    echo '          <input type="text" name="title" value="' . $tmp[$i]['title'] . '"><br>';
    echo '<span>';
    echo '              <input type="text" name="body" value="' . $tmp[$i]['body'] . '"><br>';
    if (isset($tmp[$i]['image_path'])) echo '
                                        <img class="logoACSI-foo" src="https://acsimacerata.site/news/images/' . $tmp[$i]['image_path'] . '" alt="">';
    echo '              <input type="file" name="image_path"><br>';
    if ($tmp[$i]['attachment_path'] != "")  echo '
                        <iframe src="http://docs.google.com/gview?url=https://acsimacerata.site/news/attachments/' . $tmp[$i]['attachment_path'] . '&embedded=true&view=fitV" style="width:600px; height:500px;" frameborder="0"></iframe>';
    echo '              <input type="file" name="attachment_path"><br>';
    echo '<input type="submit" name="submit" value="aggiorna">';
    echo '<input type="submit" name="delete" value="cancella">';
    echo '</form>';
    echo '</span>

                </span>
          </div>';
}

// for uploading a news
echo '  <div class="col-md-6 col-lg-6 col-sm-12 col-xs-12 header-container header-title-container news-wrap">
            <form id="upload_news" method="POST" action="" enctype="multipart/form-data">
                titolo<input type="text" name="title"><br>
                body<input type="text" name="body"><br>
                <input type="file" name="image_path"><br>
                <input type="file" name="attachment_path"><br>
                <input type="submit" name="submit" value="carica">
            </form>
        </div>';
echo '
    </div>';
