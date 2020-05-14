<?php
require_once 'config.php';

if (!isset($_SESSION["ingelogd"])) 
{
	$_SESSION["redirect"] = $_SERVER["PHP_SELF"];
	header("location: inloggen.php");
}
require_once 'lib/lib.php';

$conn = mysqli_connect($strServerName, $strUsername, $strPassword, $strDbName);
	// Check connection
	if (!$conn) {
		die("Connection failed: " . mysqli_connect_error());
	}

// laatste factuurnummer bepalen 
$sql = "SELECT max(factuurID) FROM tblFactuur";
$resultaat = mysqli_query($conn, $sql);
$rij = mysqli_fetch_row($resultaat);
$factuurID = $rij[0] + 1;

// bestellingID ophalen op basis van sessieid
$session_id = session_id();
$sql = "SELECT bestellingID, datum FROM tblBestelling WHERE sessionID = '" . mysqli_real_escape_string($conn, $session_id) . "'";


if($bestelling = mysqli_query($conn, $sql))
{
	// bestelling aanwezig, bestelnummer maken
	$rij = mysqli_fetch_assoc($bestelling);
	$bestellingID = $rij["bestellingID"];
	$bestelnummer = $_SESSION["klantID"] . "-" . ordernummer($factuurID);
	$besteldatum = MysqlNlDateLang($rij["datum"]);
	mysqli_free_result($bestelling);
}
// ophalen klantgegevens en in variabelen zetten
$sql = "SELECT * FROM tblKlant WHERE klantID = " . mysqli_real_escape_string($conn, $_SESSION["klantID"]);
$klant = mysqli_query($conn, $sql);

$rij = mysqli_fetch_assoc($klant);
$voornaam = $rij["voornaam"];
$tussenvoegsel = $rij["tussenvoegsel"];
$achternaam = $rij["achternaam"];
$adres = $rij["adres"];
$postcode = $rij["postcode"];
$plaats = $rij["plaats"];
$email = $rij["email"];
mysqli_free_result($klant);


if (isset($_POST["cmdBevestig"]))
{
// bestelling verwerken
	
	// Mail aanmaken
	require 'lib/class.phpmailer.php';
	$mail = new PHPMailer();
	$mail->From = "info@karingijssen.nl"; //testadres
	$mail->FromName = "Scarlett Marijs";
	// alleen voor localhost
	$mail->Host = "mail230.sohosted.com";
	$mail->Port = "25";
	$mail->Mailer = "smtp";

	// einde alleen voor localhost
	
	//html body
	$body = "<h1 style=\"font-family: verdana;\">Orderbevestiging</h1><br /><br /><br />";
	$body .= "<span style=\"font-family: verdana; font-size: 12px;\">Beste " . $voornaam . " " . $tussenvoegsel . " " . $achternaam . ",<br /><br />";
	$body .= "Hierbij bevestigen we je bestelling bij ScarlettMarijs.nl<br /><br />";
	$body .= "Hieronder tref je een overzicht aan van de bestelling. Eventuele acties en kortingen zijn hier niet altijd verwerkt. Deze vind je wel terug op de factuur. Wij sturen deze factuur binnen twee werkdagen per e-mail. Zodra het bedrag van de factuur op onze rekening is bijgeschreven, worden de artikelen (indien op voorraad) verzonden naar het volgende adres:<br /><br />";
	$body .= $adres ."<br />";
	$body .= $postcode . "  " . $plaats . "<br /><br /><br />&nbsp;</span>";
	$body .= "<table style=\"font-family: verdana; font-size: 12px;\" width=\"100%\" border=\"0\" cellspacing=\"0\" cellpadding=\"5\">";
	
	$totaalPrijs = 0;
	$verzendkosten = 0;
	$sql = 	"SELECT tblArtikel.artikelID, naam, aantal, prijs, brievenbus , tblOrderregel.orderaantal " .
			"FROM tblArtikel " .
			"JOIN tblOrderregel " .
			"ON tblArtikel.artikelID = tblOrderregel.artikelID " .
			"WHERE bestellingID = '" . $bestellingID . "'";

	if($artikelen = mysqli_query($conn, $sql)) //artikelen aanwezig in de bestelling
	{
		
		// tabelheaders toevoegen
		$body .= "<tr><td style=\"font-weight: bold;\">Art.nr.</td><td style=\"font-weight: bold;\">Artikel</td><td style=\"font-weight: bold;\">Aantal</td><td style=\"font-weight: bold;\">Prijs per stuk</td><td style=\"font-weight: bold;\">Totaal</td></tr>";
		while ($rij = mysqli_fetch_assoc($artikelen))
		{
			$regeltotaal = $rij["orderaantal"] * $rij["prijs"];
			$body .= "<tr><td style=\"border-top: 1px solid #cccccc;\">" . artikelnummer($rij["artikelID"]) . "</td><td style=\"border-top: 1px solid #cccccc;\">" . $rij["naam"] . "</td><td style=\"border-top: 1px solid #cccccc;\">" . $rij["orderaantal"] . "</td><td style=\"border-top: 1px solid #cccccc;\">� " . number_format($rij["prijs"], 2, ',', '.') . "</td><td style=\"border-top: 1px solid #cccccc;\">� " . number_format($regeltotaal, 2, ',', '.') . "</td></tr>";
			
			// kijken of het uit de voorraad komt of gemaakt moet worden
			if ($rij["aantal"] < 1){
				$voorraad = "<span class=\"voorraad\">Niet op voorraad</span>";
			}
			else {
				$voorraad = "<span class=\"voorraad\">Op voorraad</span>";
			}
			
			$body .= "<tr><td>&nbsp;</td><td>" . $voorraad . "</td><td>&nbsp;</td><td>&nbsp;</td><td>&nbsp;</td></tr>";
			$totaalPrijs = $totaalPrijs + $regeltotaal;
				
			if ($rij["brievenbus"] == 'on') {
				$verzendkosten = 1.75;
			}
			else {
				$verzendkosten = 5;
			}
		}
		// Kijken wat de uiteindelijke verzendkosten zijn
		if(mysqli_num_rows($artikelen) > 1) //bij meerdere artikelen geen brievenbuspost meer
		{
			$verzendkosten = 5;
		}
		if($totaalPrijs >= 50) //boven de 50 geen verzendkosten meer
		{
			$verzendkosten = 0;
		}
		mysqli_free_result($artikelen);
	
		// verzendkosten bij de totaalprijs optellen
		$totaalPrijs = $totaalPrijs + $verzendkosten;
	
	
	
	$body .= "<tr><td colspan=\"5\">&nbsp; </td></tr>";
	$body .= "<tr><td colspan=\"4\" style=\"border-top: 1px solid #cccccc;\">Indicatie van de verzendkosten</td><td style=\"border-top: 1px solid #cccccc;\">� " . number_format($verzendkosten, 2, ',', '.') . "</td></tr>";
	$body .= "<tr><td colspan=\"5\">&nbsp; </td></tr>";
	$body .= "<tr><td colspan=\"4\" style=\"border-top: 1px solid #cccccc;\">Totaalbedrag voor deze bestelling</td><td style=\"border-top: 1px solid #cccccc;\">� " . number_format($totaalPrijs, 2, ',', '.') . "</td></tr>";
	$body .= "</table><br /><br />";
	
	$body .= "<span style=\"font-family: verdana; font-size: 12px;\">Met vriendelijke groet, <br /><br />";
	$body .= "Mirella Marijs<br /><br /><br />";
	$body .= "Scarlett Marijs - Kinderkamerdeco<br />";
	$body .= "Frans Campmanweg 8<br />";
	$body .= "6817 XT  Renkum<br />";
	$body .= "06 21712945<br />";
	$body .= "<a href=\"http://www.scarlettmarijs.nl\" title=\"Website Scarlett Marijs\">http://www.scarlettmarijs.nl</a></span>";
	
	//plain text version
	$text_body = "Orderbevestiging\n\n";
	$text_body = "Beste " . $voornaam . " " . $tussenvoegsel . " " . $achternaam . " ,\n\n";
	$text_body .= "Hierbij bevestigen we je bestelling bij ScarlettMarijs.nl\n\n";
	$text_body .= "Bekijk de bestelling op <a href=\"http://www.scarlettmarijs.nl\" title=\"Website Scarlett Marijs\">onze website</a> onder \'account\'\n\n";
	$text_body .= "Wij sturen je binnen twee werkdagen een factuur. Daarop zijn ook eventuele acties en kortingen verwerkt. Zodra het bedrag van de factuur op onze rekening is bijgeschreven, worden de artikelen verzonden.\n\n";
	$text_body .= "Met vriendelijke groet, \n\n";
	$text_body .= "Mirella Marijs\n\n\n";
	$text_body .= "Scarlett Marijs - Kinderkamerdeco\n";
	$text_body .= "Frans Campmanweg 8\n";
	$text_body .= "6817 XT  Renkum\n";
	$text_body .= "06 21712945\n";
	$text_body .= "<a href=\"http://www.scarlettmarijs.nl\" title=\"Website Scarlett Marijs\">http://www.scarlettmarijs.nl</a>";
	
	$mail->Body = $body;
	$mail->AltBody = $text_body;
	$mail->Subject = "Bevestiging van uw bestelling met ordernummer " . $bestelnummer;
	$mail->AddAddress($email);
	//$mail->AddBCC("info@karingijssen.nl"); // adres beheerder voor testdoeleinden
	}
	
	
	// melding na verzenden klaarzetten
	if(!$mail->Send()) // niet gelukt om email te verzenden, bestelling blijft open
		$strMessage = "De bestelling kon niet worden voltooid. Controleer uw persoonlijke gegevens en probeer het opnieuw of neem <a href=\"http://www.scarlettmarijs.nl/contact.php\" title=\"Contactgegevens Scarlett Marijs\">contact met ons op.</a>";
	else
	{
	// mail verstuurd, bestelling afronden
		
		// status van de bestelling op 'in behandeling' zetten en bestelnummer toevoegen aan database. Sessieid wissen en factuur koppelen
		$sql = 	"UPDATE tblBestelling " .
				"SET bestelstatus = 'In behandeling', sessionID = NULL, bestelnummer = '$bestelnummer' " .
				"WHERE bestellingID	= " . $bestellingID;
		if (!mysqli_query($conn, $sql))
		{
			die("De status van de bestelling kon niet worden aangepast" . $sql);
		}
		
		// voorraad bijwerken als die er is en als er geen persoonlijke tekst is gevuld
		$sql = "SELECT tblOrderregel.artikelID, orderaantal, aantal FROM tblOrderregel " .
				"JOIN tblArtikel " .
				"ON tblArtikel.artikelID = tblOrderregel.artikelID " .
				"WHERE bestellingID	= " . $bestellingID;
		$orderregels = mysqli_query($conn, $sql);
		while($rij = mysqli_fetch_assoc($orderregels))
		{
			if ($rij["aantal"] > 0){
				$voorraad = $rij["aantal"] - $rij["orderaantal"];
				$sql = 	"UPDATE tblArtikel " .
						"SET aantal = $voorraad " .
						"WHERE artikelID	= " . $rij['artikelID'];
				if (!mysqli_query($conn, $sql))
				{
					die("De voorraad kon niet worden aangepast" . $sql);
				}
				if ($voorraad < 1) // laatste artikel verkocht
				{
					// verkoopdatum vullen
					$strVerkoopDatum = date("Y-m-d");
					$sql = 	"UPDATE tblArtikel " .
							"SET verkoopDatum = '" . mysqli_real_escape_string($conn, $strVerkoopDatum) . "' " .
							"WHERE artikelID	= " . $rij['artikelID'];
					if (!mysqli_query($conn, $sql))
					{
						die("De verkoopdatum kon niet worden toegevoegd" . $sql);
					}
				}
			}
		}
			
		
		// melding op scherm
		$strMessage = "Beste " . $voornaam . " " . $tussenvoegsel . " " . $achternaam . "<br /><br />Bedankt voor je bestelling!<br /><br />Je ontvangt de orderbevestiging op het volgende e-mailadres: " . $email ."<br /><br />Wij sturen binnen twee werkdagen een factuur. Na betaling van de factuur sturen wij je artikelen op.<br /><br />";
	}
		
}
else 
{
	// klantID toevoegen aan de bestelling
	$sql = 	"UPDATE tblBestelling " .
			"SET klantID = " . $_SESSION["klantID"] . " " .
			"WHERE bestellingID	= " . $bestellingID;
	if (!mysqli_query($conn, $sql))
	{
		die("De klant kon niet aan de bestelling gekoppeld worden" . $sql);
	}
}


?>

<!DOCTYPE html>
<html>
<head>
	 <title>Scarlett Marijs - Kinderkamer kunst en deco</title>
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
	 		<h2>Bestellingoverzicht</h2>
        	<?php 
        	if (isset($strMessage))
        	{
        		echo $strMessage;
        	}
        	else 
			{

        	?>
        	<table class="winkelmandje">
        	  <tr>
        	    <td>Bestelnummer</td>
        	    <td>: </td>
        	    <td><?php echo($bestelnummer); ?></td>
        	  </tr>
        	  <tr>
        	    <td>Besteldatum</td>
        	    <td>: </td>
        	    <td><?php echo($besteldatum); ?></td>
        	  </tr>
        	</table>
        	<h3>Bestelde artikel(en)</h3>
        	<?php  
   				$totaalPrijs = 0;
   				$verzendkosten =0;
                $sql = 	"SELECT tblArtikel.artikelID, naam, aantal, tblOrderregel.orderaantal, prijs, brievenbus " .
                		"FROM tblArtikel " .
                		"JOIN tblOrderregel " .
                		"ON tblArtikel.artikelID = tblOrderregel.artikelID " .
                		"WHERE bestellingID = '" . $bestellingID . "'";
				if($artikelen = mysqli_query($conn, $sql)) // artikelen aanwezig in de bestelling
				{
				?>
				<form action="<?php echo $_SERVER["PHP_SELF"] ?>" method="post">
				<table class="winkelmandje" border="0" cellspacing="0" cellpadding="0">
				<?php
					while($rij = mysqli_fetch_assoc($artikelen))
					{
							if ($rij["aantal"] < 1){
								$voorraad = "<span class=\"voorraad\">Niet op voorraad</span>";
							}
							else {
								$voorraad = "<span class=\"voorraad\">Op voorraad</span>";
							}
					?>
					<!-- begin artikelrij -->
	                  <tr class="artikelrij">
	                    <td><a href="artikel.php?artikelID=<?php echo($rij["artikelID"]); ?>"><?php echo($rij["naam"]); ?></a><br /><span class="artnr">art.nr. <?php echo(artikelnummer($rij["artikelID"])); ?></span></td>
	                    <td><?php echo($voorraad); ?></td>
	                    <td><?php echo($rij["orderaantal"]); ?> stuk(s)</td>
						<td class="bedrag">&euro;&nbsp;</td>
						<td class="bedrag"><?php echo(number_format($rij["orderaantal"] * $rij["prijs"], 2, ',', '.')); ?></td>
	                  </tr>

	                  
	                  <!-- einde artikelrij -->
	                  <?php 
	                  	$totaalPrijs = $totaalPrijs + ($rij["orderaantal"] * $rij["prijs"]);
	                  	// Kijken of het brievenbuspost is
	                  		if ($rij["brievenbus"] == 'on') {
	                  			$verzendkosten = 1.75;
	                  		}
	                  		else {
	                  			$verzendkosten = 5;
	                  		}
						}
						// Uiteindelijke verzendkosten
						if(mysqli_num_rows($artikelen) > 1) //bij meerdere artikelen geen brievenbuspost meer
						{
							$verzendkosten = 5;
						}
						if($totaalPrijs >= 50) //bij meerdere artikelen geen brievenbuspost meer
						{
							$verzendkosten = 0;
						}
						mysqli_free_result($artikelen);
						// verzendkosten bij totaal optellen
						$totaalPrijs = $totaalPrijs + $verzendkosten;
	                  ?>
	                  <tr>
	                    <td colspan="4">&nbsp;</td>
	                  </tr>
	                  <tr>
	                    <td>Indicatie verzendkosten<br />&nbsp;</td>
	                    <td></td>
	                    <td></td>
	                    <td class="bedrag">&euro;&nbsp;</td>
	                    <td class="bedrag"><?php echo(number_format($verzendkosten, 2, ',', '.')); ?></td>
	                  </tr>
	                  <tr class="totaalregel">
	                    <td>Totaalbedrag inclusief BTW<br />&nbsp;</td>
	                    <td></td>
	                    <td></td>
	                    <td class="bedrag">&euro;&nbsp;</td>
	                    <td class="bedrag"><?php echo(number_format($totaalPrijs, 2, ',', '.')); ?></td>
					  </tr>
<!--  				  <tr>
	                    <td>Totaalbedrag exclusief BTW</td>
	                    <td></td>
	                    <td></td>
	                    <td class="bedrag">&euro;&nbsp;</td>
	                    <td class="bedrag">
	                    	<?php // echo(number_format(totaalExBTW($totaalPrijs), 2, ',', '.')); ?>
	                    </td>
	                  </tr>
	                  <tr>
	                    <td>21% BTW</td>
	                    <td></td>
	                    <td></td>
	                    <td class="bedrag">&euro;&nbsp;</td>
	                    <td class="bedrag">
	                    	<?php // echo(number_format(BTW($totaalPrijs), 2, ',', '.')); ?>
	                    </td>
	                  </tr> -->
                </table>
                <?php 
        			//klantgegevens ophalen
        			$sql = 	"SELECT voornaam, tussenvoegsel, achternaam, adres, postcode, plaats, email, telefoon " . 
          					"FROM tblKlant " .
        					"WHERE klantID = " . $_SESSION["klantID"];
		        	$klant = mysqli_query($conn, $sql);
		        	$rij = mysqli_fetch_assoc($klant);
		        ?>
                <h3>Klantgegevens</h3>
        		<p>De bevestiging van de bestelling en de orderbevestiging worden verzonden naar het volgende e-mailadres:<br /><br /><span class="email"><?php echo($rij["email"]); ?></span><br /><br />
   				Uw aankopen worden gestuurd naar het volgende adres:</p>
	   			<table class="data">
	        	  <tr>
	        	    <td class="tabLabel">Naam</td>
	        	    <td>: </td>
	        	    <td><?php echo($rij["voornaam"] . " " . $rij["tussenvoegsel"] . " " . $rij["achternaam"]); ?></td>
	        	  </tr>
	        	  <tr>
	        	    <td  class="tabLabel">Adres</td>
	        	    <td>: </td>
	        	    <td><?php echo($rij["adres"]); ?></td>
	        	  </tr>
	        	  <tr>
	        	    <td  class="tabLabel">Postcode</td>
	        	    <td>: </td>
	        	    <td><?php echo($rij["postcode"] . "  " . $rij["plaats"]); ?></td>
	        	  </tr>
	        	</table>
	        	<?php 
	        		mysqli_free_result($klant);
	        	?>
	        	<p>Als dit niet juist is, kunt u uw <a href= "wijzigen.php" title="gegevens wijzigen">gegevens aanpassen</a>.</p><p>&nbsp;</p>
	        	<p>Door op 'Bestelling bevestigen' te klikken, gaat u akkoord met de <a href= "algemene-voorwaarden.php" target= "_blank" title="Algemene voorwaarden">algemene voorwaarden</a>.</p>
	                <a href="winkelmandje.php" class="btn btn-default">Terug</a>
	                <input type="submit" action="<?php echo $_SERVER["PHP_SELF"]; ?>" class="btn btn-default" name="cmdBevestig" value="bestelling bevestigen">   
              </form>
              
              <?php 
				}
				else {
              		die("Er is geen bestelling gevonden");
              }
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
