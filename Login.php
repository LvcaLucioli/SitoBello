<?php
if (isset($_POST['username'])) {

  require "config.inc.php";

  //connessione al db
  $conn = mysqli_connect($hostname, $username, $password, $db_name);

  //controllo connessione
  if (!$conn) {
    echo "Impossibile collegarsi al database";
    exit();
  }

  if (CRYPT_SHA256 == 1) {
    $pwd = hash('sha256', mysqli_real_escape_string($conn, $_POST['password']));
  }
  $user = mysqli_real_escape_string($conn, $_POST['username']);

  //preparazione query di inserimento
  $query = "SELECT `username`, `password` FROM `mauro` WHERE `username` = '$user' AND `password` = '$pwd'";
  $result = mysqli_query($conn, $query);
  
  if (mysqli_num_rows($result) == 0) { //se la query riporta un errore
    
    $err = "Password non valida"; //errore per il campo invalido

    //-- ricerca username --
    //preparazione query
    $query = "SELECT * FROM `mauro` WHERE `username` = '$user'";

    //esecuzione query
    $result = mysqli_query($conn, $query);

    if (mysqli_num_rows($result) == 0) {
      $err = "Username non registrato";
      $user = "";
    }

    mysqli_close($conn);
    showPage(1, $user, $err); //visualizzazione form con errore

  } else { //se la query va a buon fine

    mysqli_close($conn);
    session_start();
    $_SESSION['user'] = $_POST['username'];
    echo "<script>
    function redirect() {
      window.location.replace('".$_SESSION['previousPage']."');
      return false;
    }
    </script>
    <body onload='redirect()'>
    </body>
    ";

  }
} else {
  showPage(0, "", ""); //visualizzazione form
}


//funzione di visualizzazione del form di login
function showPage($flag, $user, $err)
{
  echo   "<!DOCTYPE html>
              <html>
                <head>
                  <meta charset='utf-8'>
                  <link rel='shortout icon' href='favicon.ico'>
                  <meta name='viewport' content='width=device-width, initial-scale=1'>
                  <link rel='stylesheet' href='https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css' integrity='sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T' crossorigin='anonymous'>
                  <link rel='stylesheet' type='text/css' href='css\stile_generale.css'>
                  <link rel='stylesheet' type='text/css' href='css\stile_login.css'>
                  <link href='https://fonts.googleapis.com/css?family=Nunito:400,300' rel='stylesheet' type='text/css'>
                  <script type='text/javascript' src='js/slideshow.js'></script>
                  <title>Accedi</title>
                </head>
                <body>
                <div class='wrap'>
                ";
  require_once __DIR__ . '/inc/header.php';
  echo "
                  <form action='' method='post' >
                    <h2>Accedi all'area riservata</h2>";

  if ($flag == 1) { //visualizzazione dell'errore in caso di login errato
    echo "<fieldset><center  style='color: red; background-color: #ffe6e6; border-radius: 15px;'>$err</center></fieldset>";
  }


  echo         "<fieldset>
                    <label for='username'>Username:</label>
                    <input type='text' name='username' title='Inserire il proprio username' value='$user' required>
                  
                    <label for='password'>Password:</label>
                    <input type='password' name='password' title='Inserire la propria password' style='margin-bottom: 20px' required>
                    </fieldset>

                    <div class='header-container header-title-container text'>
                      <span class='header-title'>
                          <h5>!!&nbsp&nbspAREA RISERVATA AL SOLO PERSONALE AUTORIZZATO ALLA GESTIONE DEL SITO&nbsp&nbsp!!</h5>
                      </span>
                    </div>
                  
                    <button class='accedi' type='submit' id='submit'>Accedi</button>
                  </form>
                  <br>
                </div>
                </body>
              </html>";
}
