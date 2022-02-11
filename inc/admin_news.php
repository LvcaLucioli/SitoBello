<?php

function ftp_upload(string $dest_file, int $type)
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
        exit;
    } else {
        echo "connesso bro";
        if ($type == 0) {
            move_uploaded_file($_FILES["image_path"]["tmp_name"], "news/images/" . $dest_file);
        }
        if ($type == 1) {
            // ftp_chdir($ftp, "/public_html");
            // ftp_chdir($ftp, "news");
            // ftp_chdir($ftp, "attachments");
            // $source_file = "news/attachments/" . $source_file;
            move_uploaded_file($_FILES["attachment_path"]["tmp_name"], "news/attachments/" . $dest_file);
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
        ftp_chdir($ftp, "news");
        if ($type == 0) {
            ftp_chdir($ftp, "images");
        }
        if ($type == 1) {
            ftp_chdir($ftp, "attachments");
        }
        ftp_delete($ftp, $target_file);
    }

    ftp_close($ftp);
}




$connection = mysqli_connect($hostname, $username, $password, $db_name)
    or die("connessione fallita");


if (isset($_POST['delete'])) {
    $get_file_query = "SELECT `image_path`, `attachment_path` FROM `news` WHERE `news_key`=" . $_POST['news_key'];
    $to_delete = mysqli_query($connection, $get_file_query)
        or die("Query non valida: " . mysqli_error($connection));
    if ($news = mysqli_fetch_assoc($to_delete)) {
        if ($news['image_path'] != "")   my_ftp_delete($news['image_path'], 0);
        if ($news['attachment_path'] != "") my_ftp_delete($news['attachment_path'], 1);
    } else {
        echo 'qua';
    }

    $delete_query = "DELETE FROM `news` WHERE `news_key` = '" . $_POST['news_key'] . "'";
    $risultato = mysqli_query($connection, $delete_query)
        or die("Query non valida: " . mysqli_error($connection));
}


if (isset($_POST['submit'])) { // if mauro is trying to upload or update a news
    $insert_query = "";
    // should be useless 
    // if ($_FILES["image_path"]["name"] != "") {
    //     $dest_image = ftp_upload($_FILES["image_path"]["name"], 0);
    // }
    // if ($_FILES["attachment_path"]["name"] != "") {
    //     $dest_pdf = ftp_upload($_FILES["attachment_path"]["name"], 1);
    // }

    $new_image = "";
    $new_attachment = "";

    if (isset($_POST['news_key'])) { // updating case

        $check_query = "SELECT* FROM `news` WHERE `news_key` = '" . $_POST['news_key'] . "'";
        $isTheNewsPresent = mysqli_query($connection, $check_query)
            or die("Query non valida: " . mysqli_error($connection));

        if ($news = mysqli_fetch_assoc($isTheNewsPresent)) {
            // if mauro is trying to change image or attachment
            if ($news['image_path'] != $_FILES['image_path']['name']) {
                if ($_FILES['image_path']['name'] != ""){ // if a new file is posted
                    $new_image = ftp_upload($news['news_key'] . $_FILES['image_path']['name'], 0); // upload file
                    if ($news['image_path'] != "") my_ftp_delete($news['image_path'], 0); // remove file if there was one
                }   
            }
            
            if ($news['attachment_path'] != $_FILES['attachment_path']["name"]) {
                if ($_FILES['attachment_path']['name'] != ""){
                    $new_attachment = ftp_upload($news['news_key'] . $_FILES['attachment_path']['name'], 1);
                    if ($news['attachment_path'] != "") my_ftp_delete($news['attachment_path'], 1);
                } 
            }
            if ($new_image == "") $new_image = $news['image_path'];
            if ($new_attachment == "") $new_attachment = $news['attachment_path'];
            $insert_query = "UPDATE `news` SET `title`='" . $_POST['title'] . "',`body`='" . $_POST['body'] . "',`image_path`='" . $new_image . "',`attachment_path`='" . $new_attachment . "',`flyer_path`='" . $news['flyer_path'] . "' WHERE `news_key`='" . $news['news_key'] . "'";

            $risultato = mysqli_query($connection, $insert_query)
                or die("Query non valida: " . mysqli_error($connection));
        }
    } else { // brand new news
        $insert_query = "INSERT INTO `news` (`title`, `body`) VALUES ('" . $_POST['title'] . "', '" . $_POST['body'] . "')";

        $risultato = mysqli_query($connection, $insert_query)
            or die("Query non valida: " . mysqli_error($connection));
        // should have news w/out any file
        if (($_FILES['image_path']['name'] != "") || ($_FILES['attachment_path']['name'] != "")) {
            $get_key = "SELECT `news_key` FROM  `news` WHERE `title`='" . $_POST['title'] . "' AND `body`='" . $_POST['body'] . "'";
            $risultato = mysqli_query($connection, $get_key)
                or die("key: " . mysqli_error($connection));

            $key = mysqli_fetch_assoc($risultato);
            if ($_FILES['image_path']['name'] != "") $new_image = ftp_upload($key['news_key'] . $_FILES['image_path']['name'], 0);
            if ($_FILES['attachment_path']['name'] != "") $new_attachment = ftp_upload($key['news_key'] . $_FILES['attachment_path']['name'], 1);
            // echo '\nciao'.$new_attachment;

            $upload_files = "UPDATE `news` SET `image_path`='" . $new_image . "', `attachment_path`='" . $new_attachment . "' WHERE `news_key`='" . $key['news_key'] . "'";
            $risultato = mysqli_query($connection, $upload_files)
                or die("logo: " . mysqli_error($connection));
        }
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


// $f = 0;
echo "<div class='news-gap'></div>";
echo '<div class="row row-news">';
for ($i = $row - 1; $i >= 0; $i--) {
    echo '  <div class="col-md-6 col-lg-6 col-sm-12 col-xs-12 header-container header-title-container news-wrap">
                <form id="upload_news" method="POST" action="" enctype="multipart/form-data">
                    <span class="header-title news-container th-lg">';
    echo '          <input type="hidden" name="news_key" value="' . $tmp[$i]['news_key'] . '"><br>';
    echo '          <input type="text" name="title" value="' . $tmp[$i]['title'] . '"><br>';
    echo '          <span>';
    echo '              <textarea name="body" rows="10" cols="50">' . $tmp[$i]['body'] . '</textarea>';
    if (isset($tmp[$i]['image_path'])) echo '
                            <img class="logoACSI-foo" src="https://acsimacerata.site/news/images/' . $tmp[$i]['image_path'] . '" alt="">';
    echo '              <input type="file" name="image_path"><br>';
    if ($tmp[$i]['attachment_path'] != "")  echo '
                            <iframe src="http://docs.google.com/gview?url=https://acsimacerata.site/news/attachments/' . $tmp[$i]['attachment_path'] . '&embedded=true" style="width:600px; height:500px;" frameborder="0"></iframe>';
    echo '              <input type="file" name="attachment_path"  accept=".pdf"><br>';
    echo '              <input type="submit" name="submit" value="aggiorna">';
    echo '              <input type="submit" name="delete" value="cancella">';
    echo '          </span>';
    echo '      </span>
                </form>
          </div>';
}

// for uploading a news
echo '  <div class="col-md-6 col-lg-6 col-sm-12 col-xs-12 header-container header-title-container news-wrap">
            <form id="upload_news" method="POST" action="" enctype="multipart/form-data">
                <span class="header-title news-container th-lg">
                    titolo<input type="text" name="title"><br>
                    body<textarea name="body" rows="10" cols="50"></textarea>
                    <input type="file" name="image_path"><br>
                    <input type="file" name="attachment_path" accept=".pdf"><br>
                    <input type="submit" name="submit" value="carica">
                </span>  
            </form>
        </div>';
echo '
    </div>';
