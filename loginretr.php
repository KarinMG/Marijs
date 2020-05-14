<?php
require_once 'config.php';
require_once 'lib/lib.php';

$conn = mysqli_connect($strServerName, $strUsername, $strPassword, $strDbName);
	// Check connection
	if (!$conn) {
		die("Connection failed: " . mysqli_connect_error());
	}

?>

<!DOCTYPE html>
<html>
<head>
	 <title>Scarlett Marijs - wachtoord vergeten</title>
	 <meta name="viewport" content="width=device-width, initial-scale=1.0" charset=utf-8>
	 <!-- Bootstrap -->
	 <link href="css/bootstrap.min.css" rel="stylesheet">
	 <link href="css/style.css" rel="stylesheet">
	 <link rel="shortcut icon" href="favicon.ico" type="image/x-icon"/>
	 <link href='http://fonts.googleapis.com/css?family=Handlee' rel='stylesheet' type='text/css'>
	 <!-- HTML5 Shiv and Respond.js IE8 support of HTML5 elements and media queries -->
	 <!--[if lt IE 9]>
		 <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
		 <script src="https://oss.maxcdn.com/libs/respond.js/1.3.0/respond.min.js"></script>
	 <![endif]-->
 </head>
 <body>
 <div class="container">
 <?php
require_once 'header.php';
?>
	 <div class="row">
	 	<section> 
	 	<div class="main col-xs-12 col-sm-12 col-md-9">
	 		<h2>Inloggegevens opvragen</h2>
<?php
	
if (isset($_POST["btnLogin"])) //knop ingedrukt
{
	// opvragen klantgegevens
$sql =  "SELECT klantID, wachtwoord, voornaam, tussenvoegsel, achternaam " .
			"FROM tblKlant " .
			"WHERE email = '" . mysqli_real_escape_string($conn, $_POST["txtEmail"]) . "'";
	$resultaat = mysqli_query($conn, $sql);
	if(mysqli_num_rows($resultaat) > 0)
	{
		// e-mailadres gevonden
		
		// nieuw wachtwoord genereren
		$aantaltekens = 8;
		$wachtwoord = wachtwoord($aantaltekens);
		
		/* // E-mail samenstellen en versturen
		$rs = mysqli_fetch_assoc($resultaat);
		
		require 'lib/class.phpmailer.php';
		$mail = new PHPMailer();
		$mail->From = "info@karingijssen.nl";
		$mail->FromName = "Scarlett Marijs";
		
		//html body
		$body = "<p style=\"font-family: Arial, Helvetica, sans-serif;\">Beste " . $rs["voornaam"] . " " . $rs["tussenvoegsel"] . " " . $rs["achternaam"] . ",</p>";
		$body .= "<p style=\"font-family: Arial, Helvetica, sans-serif;\">We hebben een nieuw wachtwoord voor u ingesteld voor onze website <a href=\"http:\/\/www.scarlettmarijs.nl\" title=\"Website Scarlett Marijs\">scarlettmarijs.nl</a>.</p>";
		$body .= "<p style=\"font-family: Arial, Helvetica, sans-serif;\">Uw inlognaam is : " . $_POST["txtEmail"] . "<br />";
		$body .= "Uw wachtwoord is : " . $wachtwoord . "</p><br />";
		$body .= "<p style=\"font-family: Arial, Helvetica, sans-serif;\">In verband met de veiligheid raden wij u aan om uw wachtwoord zo snel mogelijk te veranderen op onze website.</p>";
		$body .= "<p style=\"font-family: Arial, Helvetica, sans-serif;\">Met vriendelijke groet,</p>";
		$body .= "<p style=\"font-family: Arial, Helvetica, sans-serif;\">Mirella Marijs</p>";
		
		//plain text version
		$text_body = "Beste " . $rs["voornaam"] . " " . $rs["tussenvoegsel"] . " " . $rs["achternaam"] . "\n\n";
		$text_body .= "U heeft uw inloggegevens opgevraagd op onze website <a href=\"http:\/\/www.scarlettmarijs.nl\" title=\"Website Scarlett Marijs\">scarlettmarijs.nl</a>\n\n";
		$text_body .= "Uw inlognaam is : " . $_POST["txtEmail"] . "\n";
		$text_body .= "Uw wachtwoord is : " . $wachtwoord . "\n\n";
		$text_body .= "In verband met de veiligheid raden wij u aan om uw wachtwoord zo snel mogelijk te veranderen op onze website.\n\n";
		$text_body .= "Met vriendelijke groet,\n";
		$text_body .= "Mirella Marijs";
		
		$mail->Body = $body;
		$mail->AltBody = $text_body;
		$mail->Subject = "Nieuwe inloggegevens";
		$mail->AddAddress($_POST["txtEmail"], $rs["voornaam"] . " " . $rs["tussenvoegsel"] . " " . $rs["achternaam"]);
		//$mail->AddBCC($address);
		
		if(!$mail->Send())
			echo("<br /><br />Beste " . $rs["voornaam"] . " " . $rs["tussenvoegsel"] . " " . $rs["achternaam"] . ",<br /><br />Uw inloggegevens konden niet worden verstuurd naar " . $_POST["txtEmail"] . ". Neem contact met ons op.<br /><br />");
		else
			echo("<br /><br />Beste " . $rs["voornaam"] . " " . $rs["tussenvoegsel"] . " " . $rs["achternaam"] . ",<br /><br />Uw inloggegevens zijn verstuurd naar " . $_POST["txtEmail"] . "<br /><br />");
	
 */
	
		
	// wachtwoord updaten in database
		$salt = salt(); // salt genereren
		$sql = 	"UPDATE tblKlant " .
				"SET wachtwoord = '" . crypt($wachtwoord, $salt) . "' " .
				"WHERE klantID = " . $rs["klantID"];
		if (!mysqli_query($conn, $sql))
		{
		
			die("Iets is er niet goed gegaan " . $sql);
		}
		else {$strErrInlog = "wachtwoord is " . $wachtwoord . "."; }
	}
	else {
		// gebruiker niet gevonden
		$strErrInlog = "<span class=\"warning\">Dit e-mailadres komt niet<br /> voor in ons bestand</span><br /><br />";
		?>
		<div class="blokinlog">
		<form method="post" action="<?php echo $_SERVER["PHP_SELF"]; ?>">
		<p><?php
		echo($strErrInlog);
		?></p>
			Vul uw emailadres in:<br />
			<input type="text" name="txtEmail" id="txtEmail" ><br /> <!-- temp removed: value="<?php echo($_COOKIE["loginnaam"])?>"-->
			<input type="submit" name="btnLogin" value="Inlog opvragen" class="button">
			<p><a href="registreren.php">Nieuw account aanmaken</a></p>
		</form>
		</div>
		<?php
	}	
}
else 
{
	$strErrInlog = '';
?>
	<div class="blokinlog">
	<form method="post" action="<?php echo $_SERVER["PHP_SELF"]; ?>">
	<p><?php echo($strErrInlog); ?></p>
		Vul uw emailadres in:<br />
		<input type="text" name="txtEmail" id="txtEmail" ><br /> <!-- value="<?php echo($_COOKIE["loginnaam"])?>" temp removed -->
		<input type="submit" name="btnLogin" value="Inlog opvragen" class="btn btn-default">
		<p><a href="registreren.php">Nieuw account aanmaken</a></p>
	</form>
	</div>
<?php 
}
?>
		</div>
	 	</section>
	 	<aside class="col-xs-12 col-sm-12 col-md-3">
	        <?php
	        require_once 'loginstatus.php';
	        require_once 'servicemenu.php';
	        require_once 'wistjedat.php';
	        ?>
	 	</aside>
	 </div>
	 <?php require_once 'footer.php'; ?>
	 
</div> 
	 <!-- js scripts -->
		 <script src="https://code.jquery.com/jquery.js"></script>
		 <script src="js/bootstrap.min.js"></script>
	 <!-- end js scripts -->
 </body>
</html>
<?php mysqli_close($conn); ?>

