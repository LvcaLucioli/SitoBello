<?php

	require "config.inc.php";
	
	//connessione al db
	$conn = mysqli_connect($host, $username, $password, $name);
	
	//controllo connessione
	if (!$conn){
		echo "Impossibile collegarsi al database";
		exit();
	}
	
	//preparazione query di inserimento
	$query = "INSERT INTO Utenti (username, nome, cognome, email, password, codice_fiscale, indirizzo) VALUES ('$_POST[username]', '$_POST[nome]', '$_POST[cognome]', '$_POST[email]', '$_POST[password]', '$_POST[codice_fiscale]', '$_POST[indirizzo]')";

	//esecuzione query
	$result = mysqli_query($conn, $query);
	
	if (!$result){//se la query riporta un errore viene ripetuta la registrazione

		showPage($conn);

	}else{//altrimenti se effettua l'accesso con l'utente creato

		session_start();
		$_SESSION['user'] = $_POST['username'];
		echo "<script>
				window.location = '$_SESSION[previousPage]';
			  </script>";
	}
	
	mysqli_close($conn);


	//funzione di visualizzazione del form di registrazione nel caso di campi non validi
	function showPage($conn){
		
		//-- ricerca email --
		//preparazione query
		$query = "SELECT * FROM Utenti WHERE email = '$_POST[email]'";

		//esecuzione query
		$result = mysqli_query($conn, $query);
		
		if ( mysqli_num_rows($result) ){
			$err = "E-mail già utilizzata";
		}
		
		
		//-- ricerca username --
		//preparazione query
		$query = "SELECT * FROM Utenti WHERE username = '$_POST[username]'";

		//esecuzione query
		$result = mysqli_query($conn, $query);
		
		if ( mysqli_num_rows($result) ){
			$err = "Username già utilizzato";
		}
		
		
		//-- ricerca codice fiscale --
		//preparazione query
		$query = "SELECT * FROM Utenti WHERE codice_fiscale = '$_POST[codice_fiscale]'";

		//esecuzione query
		$result = mysqli_query($conn, $query);
		
		if ( mysqli_num_rows($result) ){
			$err = "Codice fiscale già utilizzato";
		}
				
		echo "<!DOCTYPE html>
				<html>
					<head>
						<meta charset='utf-8'>
						<link rel='shortout icon' href='favicon.ico'>
						<meta name='viewport' content='width=device-width, initial-scale=1.0'>
						<link rel='stylesheet' href='css\stile_registrazione.css'>
						<link href='https://fonts.googleapis.com/css?family=Nunito:400,300' rel='stylesheet' type='text/css'>
						<script src='js\Ripeti_password_script.js'></script>
						<title>Registrati</title>
				  </head>
				  <body>

					  <a href='Home.php'>
					  <div class='logo'>
						<img class='img' src='img\logo.png' alt='Logo'>
					  </div>
					  </a>

					  <form action='Conferma_reg.php' method='post'>
						  <h2>Crea il tuo account</h2>
						  <fieldset><center  style='color: red; background-color: #ffe6e6; border-radius: 15px;'>$err</center></fieldset>
						  
						  <fieldset>
							<legend><span class='number'>1</span>Informazioni personali</legend>
							<label for='name'>Nome*:</label>
							<input type='text' name='nome' required>
						
							<label for='name'>Cognome*:</label>
							<input type='text' name='cognome' required>
							
							<label for='mail'>Email*:</label>
							<input type='email' name='email' required>
						  </fieldset>
						  
						  <fieldset>
							<legend><span class='number'>2</span>Informazioni del profilo</legend>
							<label for='username'>Username*:</label>
							<input type='text' name='username' pattern='.{1,16}' title='Massimo 16 caratteri' required>
						
							<label for='password'>Password*:</label>
							<input type='password' name='password' id='password' placeholder='Almeno 8 caratteri, una maiuscola e un numero'
							pattern='(?=.*\d)(?=.*[A-Z]).{8,}' title='Almeno 8 caratteri, una maiuscola e un numero' onchange='validatePassword()' required>
						
							<label for='password'>Ripeti password*:</label>
							<input type='password' name='ripeti_password' id='ripeti_password' placeholder='Almeno 8 caratteri, una maiuscola e un numero'
							pattern='(?=.*\d)(?=.*[A-Z]).{8,}' title='Almeno 8 caratteri, una maiuscola e un numero'  onchange='validatePassword()' required>
						  </fieldset>
					  
						  <fieldset>
							<legend><span class='number'>3</span>Dati di fatturazione</legend>
							<label for='codice'>Codice fiscale*:</label>
							<input type='text' name='codice_fiscale' pattern='^[a-zA-Z]{6}[0-9]{2}[a-zA-Z][0-9]{2}[a-zA-Z][0-9]{3}[a-zA-Z]$' title='Inserisci un codice fiscale valido' required>
						
							<label for='indirizzo'>Indirizzo di residenza:</label>
							<input type='text' name='indirizzo' style='margin-bottom: 10px;'>

							<label class='obbligo'>*Campi obbligatori</label>

							<label class='container'>Acconsento al trattamento dei dati secondo quanto stabilito dal GDPR
							<input type='checkbox' required>
							<span class='checkmark'></span>
							</label>

						  </fieldset>
					  
						  <button class='registrati' type='submit' id='submit'>Registrati</button>

						  <div class='linea'>
						  <div class='car_int'><span style='background-color: white; padding: 6px;'>Sei gi&agrave registrato?</span></div>
						  </div>

						  <button class='accedi' onclick='window.location.href='Login.php''>Accedi al tuo account</button>
					  </form>
				  </body>
				</html>";
	}

?>