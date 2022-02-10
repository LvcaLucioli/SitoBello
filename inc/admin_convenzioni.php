<?php


function ftp_upload(string $dest_file)
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
        echo 'here';
        exit;
    } else {
        if(move_uploaded_file($_FILES["logo_path"]["tmp_name"], "convenzioni/logos/".$dest_file))  echo " OK ";
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
        ftp_chdir($ftp, "convenzioni");
        ftp_chdir($ftp, "logos");
        ftp_delete($ftp, $target_file);

    }
    // close the FTP connection 
    ftp_close($ftp);
}

$connection = mysqli_connect($hostname, $username, $password, $db_name)
    or die("connessione fallita");


if (isset($_POST['delete'])) {
    $get_file_query = "SELECT `logo_path` FROM `conventions` WHERE `convention_key`=" . $_POST['convention_key'];
    $to_delete = mysqli_query($connection, $get_file_query)
        or die("Query non valida: " . mysqli_error($connection));
    if ($conv = mysqli_fetch_assoc($to_delete)) {
        my_ftp_delete($conv['logo_path']);
    }

    $delete_query = "DELETE FROM `conventions` WHERE `convention_key` = '" . $_POST['convention_key'] . "'";
    $risultato = mysqli_query($connection, $delete_query)
        or die("Query non valida: " . mysqli_error($connection));
}



if (isset($_POST['submit'])) { // if mauro is trying to upload or update a news
    $insert_query = "";

    if (isset($_POST['convention_key'])) { // updating case

        $check_query = "SELECT * FROM `conventions` WHERE `convention_key` = '" . $_POST['convention_key'] . "'";
        $isTheConvPresent = mysqli_query($connection, $check_query)
            or die("Query non valida: " . mysqli_error($connection));

        $dest_path = "";

        if ($conv = mysqli_fetch_assoc($isTheConvPresent)) { // should be present at this point
            if ($conv['logo_path'] != $_FILES['logo_path']['name']) { // if uploading new logo [(b: no logo, a: logo), (b: logo, a: logo)]
                if($conv['logo_path'] != "")    my_ftp_delete($conv['logo_path']);
                $dest_file = ftp_upload($conv['convention_key'] . $_FILES["logo_path"]["name"]); // es: 1nomefile.jpg
                // uploaded new logo
                $insert_query = "UPDATE `conventions` SET `company_name`='" . $_POST['company_name'] . "',
                `city`='" . $_POST['city'] . "', `logo_path`='" . $dest_file . "',`address`='" . $_POST['address'] . "',
                `phone`='" . $_POST['phone'] . "', `description`='" . $_POST['description'] . "', `email`='" . $_POST['email'] . "'  
                WHERE `convention_key`='" . $_POST['convention_key'] . "'";
                // w/ logo query
            } else {
                $insert_query = "UPDATE `conventions` SET `company_name`='" . $_POST['company_name'] . "',
                `city`='" . $_POST['city'] . "',`address`='" . $_POST['address'] . "',
                `phone`='" . $_POST['phone'] . "', `description`='" . $_POST['description'] . "', `email`='" . $_POST['email'] . "'  
                WHERE `convention_key`='" . $conv['convention_key'] . "'";
                // no logo query
            }
            $risultato = mysqli_query($connection, $insert_query)
                or die("Query non valida: " . mysqli_error($connection));
            // everything good here  
        }
    } else { // brand new conv
        $insert_query = "INSERT INTO `conventions` (`company_name`, `city`, `address`, `phone`, `description`, `email`) VALUES 
        ('" . $_POST['company_name'] . "', '" . $_POST['city'] . "', '" . $_POST['address'] . "', '" . $_POST['phone'] . "', '" . $_POST['description'] . "', '" . $_POST['email'] . "')";

        $risultato = mysqli_query($connection, $insert_query)
            or die("insert: " . mysqli_error($connection));

        // here we have a new conv in the db w/out logo

        if ($_FILES['logo_path']['name'] != "") {
            $get_key = "SELECT `convention_key` FROM `conventions` WHERE `company_name`='" . $_POST['company_name'] . "' AND
            `city`='" . $_POST['city'] . "' AND `address`='" . $_POST['address'] . "' AND
            `phone`='" . $_POST['phone'] . "' AND `description`='" . $_POST['description'] . "' AND `email`='" . $_POST['email'] . "'";

            $risultato = mysqli_query($connection, $get_key)
                or die("key: " . mysqli_error($connection));

            $key = mysqli_fetch_assoc($risultato);
            $dest_path = $key['convention_key'] . $_FILES["logo_path"]["name"];
            ftp_upload($dest_path);
            echo $_FILES['logo_path']['name'];

            $upload_logo = "UPDATE `conventions` SET `logo_path`='" . $dest_path . "' WHERE `convention_key`='" . $key['convention_key'] . "'";
            $risultato = mysqli_query($connection, $upload_logo)
                or die("logo: " . mysqli_error($connection));
        }
    }
}



$qr = "SELECT * FROM `conventions` WHERE 1";

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

echo "<div class='conv-gap'></div>";

echo '<div class="row row-conv">';
for ($i = 0; $i < $row; $i++) {
    echo '  <div class="col-md-4 col-lg-4 col-sm-12 col-xs-12 header-container header-title-container conv-wrap">
    
                <form id="update" method="POST" enctype="multipart/form-data">      
                     
                    <span class="header-title conv-container">
                        <span>
                            <input type="hidden" name="convention_key" value="' . $tmp[$i]['convention_key'] . '"><br>

                            <input type="text" name="company_name" value="' . $tmp[$i]['company_name'] . '"><br>';
    if (isset($tmp[$i]['logo_path']))  echo
    '<img class="logoACSI-foo" src="https://acsimacerata.site/convenzioni/logos/' . $tmp[$i]['logo_path'] . '" alt=""><br>
                            <input type="file" name="logo_path"><br>';
    echo '              <h4 class="sub-title" style="font-size: medium; color: #779bcc; padding: 0;"><b>Descrizione:</b></h4>
                            
    <textarea name="description">' . $tmp[$i]['description'] . '</textarea>     
                            
                            <div class="row" style="margin-top: 3%">
                                <div class="col-3"><h4 class="sub-title" style="font-size: medium; color: #779bcc;"><b>Indirizzo:</b></h4></div>
                                <div class="col-8">
                                    <input type="text" name="address" value="' . $tmp[$i]['address'] . '"><br>
                                </div>
                            </div>

                            <div class="row" style="margin-top: 3%">
                                <div class="col-3"><h4 class="sub-title" style="font-size: medium; color: #779bcc;"><b>Città:</b></h4></div>
                                <div class="col-8">
                                    <input type="text" name="city" value="' . $tmp[$i]['city'] . '"><br>
                                </div>
                            </div>

                            <div class="row" style="margin-top: 3%">
                                <div class="col-3"><h4 class="sub-title" style="font-size: medium; color: #779bcc;"><b>Telefono:</b></h4></div>
                                <div class="col-8">
                                    <input type="text" name="phone" value="' . $tmp[$i]['phone'] . '"><br>
                                </div>
                            </div>

                            <div class="row" style="margin-top: 3%">
                                <div class="col-3"><h4 class="sub-title" style="font-size: medium; color: #779bcc;"><b>E-mail:</b></h4></div>
                                <div class="col-8">
                                    <input type="text" name="email" value="' . $tmp[$i]['email'] . '"><br>
                                </div>
                            </div>
                        </span>
                        <input type="submit" name="submit" value="aggiorna"><br>
                        <input type="submit" name="delete" value="cancella">
                    </span>
                    
                </form>
            </div>
            ';
}


// for uploading a convention
echo '  <div class="col-md-4 col-lg-4 col-sm-12 col-xs-12 header-container header-title-container conv-wrap">
            <form id="upload" method="POST" enctype="multipart/form-data">
                <span class="header-title conv-container">
                    Compagnia<input type="text" name="company_name"><br>
                    <input type="file" name="logo_path"><br>
                    Descrizione<textarea rows="4" cols="50" name="description" maxlenght="400"></textarea>
                    Indirizzo<input type="text" name="address"><br>
                    Città<input type="text" name="city"><br>
                    Telefono<input type="text" name="phone"><br>
                    E-mail<input type="text" name="email"><br>
                    <input type="submit" name="submit" value="carica">
                </span>
            </form>
        </div>';



echo '</div>';
