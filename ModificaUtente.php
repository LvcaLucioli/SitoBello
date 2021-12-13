<?php
	session_start();
?>

<!DOCTYPE html>
<html>
	<head>
        <meta charset="utf-8">
        <link rel="shortout icon" href="favicon.ico">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <link rel="stylesheet" href="css\stile_registrazione.css">
        <link href='https://fonts.googleapis.com/css?family=Nunito:400,300' rel='stylesheet' type='text/css'>
        <script src="js\Ripeti_password_script.js"></script>
        <title>Area Utenti</title>
  </head>
  <body>

      <a href="Home.php">
      <div class="logo">
        <img class="img" src="img\logo.png" alt="Logo">
      </div>
      </a>

        <?php

            require "config.inc.php";
                            
            //connessione al db
            $conn = mysqli_connect($host, $username, $password, $name);

            //controllo connessione
            if (!$conn){
                echo "Impossibile collegarsi al database";
                exit();
            }

            if (isset($_POST['nome'])){
				
				//preparazione query di selezione
                $query = "SELECT * FROM Utenti WHERE username = '$_SESSION[user]' AND email = '$_POST[email]'";

                //esecuzione query
                $result = mysqli_query($conn, $query);
				
				//preparazione query di modifica
				$query = "UPDATE Utenti SET nome = '$_POST[nome]', cognome = '$_POST[cognome]', indirizzo = '$_POST[indirizzo]'";

				if ( mysqli_num_rows($result) == 0 ){//se la query riporta un errore
                    $query = $query.", email = '$_POST[email]'";
                }
				
                if ($_POST['password'] != ""){
                    $query = $query.", password = '$_POST[password]'";
                }
				
				$query = $query." WHERE username = '$_SESSION[user]'";

                //esecuzione query
                $result = mysqli_query($conn, $query);
				
                
                if ( mysqli_affected_rows($conn) <= 0 ){//se la query riporta un errore

                    showPage(1, $conn);//visualizzazione form con errore sulla mail

                }else{//se la query va a buon fine

                    echo "<script>
                            window.location = 'ModificaUtente.php';
                          </script>";
                }
                
                mysqli_close($conn);

            }else{//prima visualizzazione della pagina di modifica

                showPage(0, $conn);//visualizzazione form

            }
            
            //funzione di visualizzazione del form di modifica
            function showPage($flag, $conn){

                //preparazione query di selezione
                $query = "SELECT * FROM Utenti WHERE username = '$_SESSION[user]'";

                //esecuzione query
                $result = mysqli_query($conn, $query);

                $row = mysqli_fetch_assoc($result);

                echo   "<form action='' method='post'>
                            <h2>Modifica il tuo account: $_SESSION[user]</h2>";

                if ($flag == 1){//visualizzazione dell'errore in caso di login errato
                    echo "<fieldset><center  style='color: red; background-color: #ffe6e6; border-radius: 15px;'>E-mail già registrata</center></fieldset>";
                }
                                
                                
                echo        "<fieldset>
                                <legend><span class='number'>1</span>Informazioni personali</legend>
                                <label for='name' id='1'>Nome*:</label>
                                <input type='text' name='nome' value='$row[nome]' required>
                            
                                <label for='name'>Cognome*:</label>
                                <input type='text' name='cognome' value='$row[cognome]' required>
                                
                                <label for='mail'>Email*:</label>
                                <input type='email' name='email' value='$row[email]' required>
                            </fieldset>
                            
                            <fieldset>
                                <legend><span class='number'>2</span>Informazioni del profilo</legend>
                                <label for='password'>Password:</label>
                                <input type='password' name='password' id='password' placeholder='Riempi per modificare la password'
                                pattern='(?=.*\d)(?=.*[A-Z]).{8,}' title='Almeno 8 caratteri, una maiuscola e un numero' onchange='validatePassword()'>
                            
                                <label for='password'>Ripeti password:</label>
                                <input type='password' name='ripeti_password' id='ripeti_password' placeholder='Conferma la password'
                                pattern='(?=.*\d)(?=.*[A-Z]).{8,}' title='Almeno 8 caratteri, una maiuscola e un numero'  onchange='validatePassword()'>
                            </fieldset>
                        
                            <fieldset>
                                <legend><span class='number'>3</span>Dati di fatturazione</legend>
                            
                                <label for='indirizzo'>Indirizzo di residenza:</label>
                                <input type='text' name='indirizzo' style='margin-bottom: 10px;' value='$row[indirizzo]'>
                    
                                <label class='obbligo'>*Campi obbligatori</label>                   
                            </fieldset>
                        
                            <button class='registrati' type='submit' id='submit'>Modifica account</button>
                    
                            <div class='linea'>
                            <div class='car_int'></div>
                            </div>
							
							<script>
							
								function cancella(){
									var sei_sicuro = confirm('Sei sicuro di voler eliminare il tuo account?');
									if (sei_sicuro){
										window.location.replace('EliminaAccount.php');
									}else{
										document.getElementById('1').value = '';
										window.location.href = 'ModificaUtente.php';
									}
								}
								
							</script>
                    
                            <button class='elimina' onclick='cancella()'>Elimina il tuo account</button>
							
							
							
							
							
							
							";
            }
        ?>

    </body>
</html>