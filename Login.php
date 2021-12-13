<?php

    if (isset($_POST['username'])){//

      require "config.inc.php";
	
      //connessione al db
      $conn = mysqli_connect($host, $username, $password, $name);
      
      //controllo connessione
      if (!$conn){
        echo "Impossibile collegarsi al database";
        exit();
      }
      
      //preparazione query di inserimento
      $query = "SELECT * FROM Utenti WHERE username = '$_POST[username]' AND password = '$_POST[password]'";

      //esecuzione query
      $result = mysqli_query($conn, $query);
      
      if ( mysqli_num_rows($result) == 0 ){//se la query riporta un errore

        $user = $_POST['username'];
        $err = "Password non valida";//errore per il campo invalido
        
        //-- ricerca username --
        //preparazione query
        $query = "SELECT * FROM Utenti WHERE username = '$_POST[username]'";

        //esecuzione query
        $result = mysqli_query($conn, $query);
        
        if ( mysqli_num_rows($result) == 0 ){
          $err = "Username non registrato";
          $user = "";
        }

        showPage(1, $user, $err);//visualizzazione form con errore

      }else{//se la query va a buon fine

        session_start();
        $_SESSION['user'] = $_POST['username'];
		echo "<script>
				window.location = '$_SESSION[previousPage]';
			  </script>";
      }
      
      mysqli_close($conn);

    }else{//prima visualizzazione della pagina di login

        showPage(0, "", "");//visualizzazione form

    }
    
    //funzione di visualizzazione del form di login
    function showPage($flag, $user, $err){
      echo   "<!DOCTYPE html>
              <html>
                <head>
                  <meta charset='utf-8'>
                  <link rel='shortout icon' href='favicon.ico'>
                  <meta name='viewport' content='width=device-width, initial-scale=1.0'>
                  <link rel='stylesheet' href='css\stile_login.css'>
                  <link href='https://fonts.googleapis.com/css?family=Nunito:400,300' rel='stylesheet' type='text/css'>
                  <script src='js\Ripeti_password_script.js'></script>
                  <title>Accedi</title>
                </head>
                <body>

                  <a href='Home.php'>
                  <div class='logo'>
                  <img class='img' src='img\logo.png' alt='Logo'>
                  </div>
                  </a>

                  <form action='' method='post'>
                    <h2>Accedi al tuo account</h2>";

      if ($flag == 1){//visualizzazione dell'errore in caso di login errato
          echo "<fieldset><center  style='color: red; background-color: #ffe6e6; border-radius: 15px;'>$err</center></fieldset>";
      }
                    
                    
      echo         "<fieldset>
                    <label for='username'>Username:</label>
                    <input type='text' name='username' title='Inserire il proprio username' value='$user' required>
                  
                    <label for='password'>Password:</label>
                    <input type='password' name='password' title='Inserire la propria password' style='margin-bottom: 20px' required>
                    </fieldset>
                  
                    <button class='accedi' type='submit' id='submit'>Accedi</button>

                    <div class='linea'>
                    <div class='car_int'><span style='background-color: white; padding: 6px;'>Non sei ancora registrato?</span></div>
                    </div>

                    <button class='registrati' onclick='window.location.href='Registrazione.php''>Crea un account</button>
                  </form>
                </body>
              </html>";
    }
?>