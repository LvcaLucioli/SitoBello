<!DOCTYPE html>
<html>
	<head>
        <meta charset="utf-8">
        <link rel="shortout icon" href="favicon.ico">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Conferma registrazione</title>
        <link rel="stylesheet" href="css\stile_conferma.css">
        <link href='https://fonts.googleapis.com/css?family=Nunito:400,300' rel='stylesheet' type='text/css'>
  </head>
  <body>
  
    <a href="Home.php">
    <div class="logo">
      <img class="img" src="img\logo.png" alt="Logo">
    </div>
    </a>

    <form action="SalvataggioUtente.php" method="post">
      <h2>Conferma i dati del tuo account</h2>
    
      <fieldset>
        <legend><span class="number">1</span>Informazioni personali</legend>
        <label for="name">Nome: 
          <span style="color: #384047;">
          <?php
              echo $_POST["nome"];
          ?>
          </span>
        </label>
  
        <label for="name">Cognome: 
          <span style="color: #384047;">
          <?php
              echo $_POST["cognome"];
          ?>
          </span>
        </label>
      
        <label for="mail">Email: 
          <span style="color: #384047;">
          <?php
              echo $_POST["email"];
          ?>
          </span>
        </label>
      </fieldset>
        
      <fieldset>
        <legend><span class="number">2</span>Informazioni del profilo</legend>
		    <label for="password">Username: 
          <span style="color: #384047;">
          <?php
              echo $_POST["username"];
          ?>
          </span>
        </label>
		  
		    <label for="password">Password: 
          <span style="color: #384047;">
          <?php
              echo $_POST["password"];
          ?>
          </span>
        </label>
      </fieldset>
		
      <fieldset>
		    <legend><span class="number">3</span>Dati di fatturazione</legend>
	      <label for="password">Codice fiscale: 
          <span style="color: #384047;">
          <?php
              echo $_POST["codice_fiscale"];
          ?>
          </span>
        </label>
		  
		    <label for="password">Indirizzo di residenza: 
          <span style="color: #384047;">
          <?php
              if($_POST["indirizzo"] != ""){
                  echo $_POST["indirizzo"];
              }else{
                  echo "<span style='color: #bfbfbf;'>indirizzo non specificato</span>";
              }
          ?>
          </span>
        </label>
      </fieldset>
		
      <input type="text" name="nome" value="<?php echo $_POST["nome"] ?>" hidden>
      <input type="text" name="cognome" value="<?php echo $_POST["cognome"] ?>" hidden>
      <input type="text" name="email" value="<?php echo $_POST["email"] ?>" hidden>          
      <input type="text" name="username" value="<?php echo $_POST["username"] ?>" hidden>
      <input type="text" name="password" value="<?php echo $_POST["password"] ?>" hidden>
      <input type="text" name="ripeti_password" value="<?php echo $_POST["ripeti_password"] ?>" hidden>
      <input type="text" name="codice_fiscale" value="<?php echo $_POST["codice_fiscale"] ?>" hidden>
	    <input type="text" name="indirizzo" value="<?php echo $_POST["indirizzo"] ?>" hidden>
		
      <button class="registrati" type="submit">Termina registrazione</button>
      <br><br>
      <button class="annulla" formaction="Registrazione.php">Annulla</button>
    </form>
  </body>
</html>