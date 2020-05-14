<?php
require_once 'config.php';

if (!isset($_SESSION["ingelogd"])) 
{
	$_SESSION["redirect"] = $_SERVER["PHP_SELF"];
	header("location: inloggen.php");
}
require_once 'lib/lib.php';

$db = mysql_connect($strServerName, $strUsername, $strPassword)
or die("Kan niet verbinden: " . mysql_error());
mysql_select_db($strDbName, $db);

// laatste factuurnummer bepalen (tijdelijk uitgeschakeld)
// $sql = "SELECT max(factuurID) FROM tblFactuur";
// $resultaat = mysql_query($sql);
// $rij = mysql_fetch_row($resultaat);
// $factuurID = $rij[0] + 1;

// bestellingID ophalen op basis van sessieid
$session_id = session_id();
$sql = "SELECT bestellingID, datum FROM tblBestelling WHERE sessionID = '" . mysql_real_escape_string($session_id) . "'";
$bestelling = mysql_query($sql);

if(mysql_num_rows($bestelling) > 0)
{
	// bestelling aanwezig, bestelnummer maken
	$rij = mysql_fetch_array($bestelling);
	$bestellingID = $rij["bestellingID"];
	$bestelnummer = $_SESSION["klantID"] . "-" . ordernummer($factuurID);
	$besteldatum = MysqlNlDateLang($rij["datum"]);
	mysql_free_result($bestelling);
}
// ophalen klantgegevens en in variabelen zetten
$sql = "SELECT * FROM tblKlant WHERE klantID = " . mysql_real_escape_string($_SESSION["klantID"]);
$klant = mysql_query($sql);

$rij = mysql_fetch_array($klant);
$voornaam = $rij["voornaam"];
$tussenvoegsel = $rij["tussenvoegsel"];
$achternaam = $rij["achternaam"];
$adres = $rij["adres"];
$postcode = $rij["postcode"];
$plaats = $rij["plaats"];
$email = $rij["email"];
mysql_free_result($klant);


if (isset($_POST["cmdBevestig"]))
{
// bestelling verwerken
	
	// Mail aanmaken
	require 'lib/class.phpmailer.php';
	$mail = new PHPMailer();
	$mail->From = "info@scarlettmarijs.nl";
	$mail->FromName = "Scarlett Marijs";
	
	//html body
	$body = "Beste " . $voornaam . " " . $tussenvoegsel . " " . $achternaam . " ,<br /><br />";
	$body .= "Hierbij bevestigen we uw bestelling met bestelnummer " . $bestelnummer . "<br /><br />";
	$body .= "In de bijlage van deze e-mail treft u de orderbevestiging aan voor uw bestelling. Wij sturen u binnen twee werkdagen een factuur. Zodra het bedrag van de factuur op onze rekening is bijgeschreven, worden uw artikelen verzonden.<br /><br />";
	$body .= "Kunt u de orderbevestiging niet openen, of heeft u andere vragen of opmerkingen over uw bestelling, neem dan contact met ons op. U kunt uw bestellingen ook bekijken op de website onder Mijn account. Daar kunt u ook uw persoonlijke gegevens aanpassen.<br /><br /><br />";
	$body .= "Met vriendelijke groet, <br /><br />";
	$body .= "Mirella Marijs<br /><br /><br />";
	$body .= "Frans Campmanweg 8<br />";
	$body .= "6817 XT  Renkum<br />";
	$body .= "06 21712945<br />";
	$body .= "<a href=\"http://www.scarlettmarijs.nl\" title=\"Website Scarlett Marijs\">http://www.scarlettmarijs.nl</a>";
	
	//plain text version
	$text_body = "Beste " . $voornaam . " " . $tussenvoegsel . " " . $achternaam . " ,\n\n";
	$text_body .= "Hierbij bevestigen we uw bestelling met bestelnummer " . $bestelnummer . "\n\n";
	$text_body .= "In de bijlage van deze e-mail treft u de orderbevestiging aan voor uw bestelling. Wij sturen u binnen twee werkdagen een factuur. Zodra het bedrag van de factuur op onze rekening is bijgeschreven, worden uw artikelen verzonden.\n\n";
	$text_body .= "Kunt u de orderbevestiging niet openen, of heeft u andere vragen of opmerkingen over uw bestelling, neem dan contact met ons op. U kunt uw bestellingen ook bekijken op de website onder Mijn account. Daar kunt u ook uw persoonlijke gegevens aanpassen.\n\n";
	$text_body .= "Met vriendelijke groet, \n\n";
	$text_body .= "Mirella Marijs\n\n\n";
	$text_body .= "Frans Campmanweg 8\n";
	$text_body .= "6817 XT  Renkum\n";
	$text_body .= "06 21712945\n";
	$text_body .= "<a href=\"http://www.scarlettmarijs.nl\" title=\"Website Scarlett Marijs\">http://www.scarlettmarijs.nl</a>";
	
	$mail->Body = $body;
	$mail->AltBody = $text_body;
	$mail->Subject = "Bevestiging van uw bestelling met bestelnummer " . $bestelnummer;
	$mail->AddAddress($email, $voornaam . " " . $tussenvoegsel . " " . $achternaam);
	//$mail->AddBCC("info@scarlettmarijs.nl); // adres beheerder
	
	
	// pdf aanmaken
	require_once 'lib/fpdf.php';
	
	class PDF extends FPDF
	{
		//Page header
		function Header()
		{
			$this->Image("images/briefheader.png", 0, 0, 210, 56);
			$this->Cell(0,35,'',0,1,'L');
		}
		//Page footer
		function Footer()
		{
			$this->SetY(-15);
			$this->SetFont('helvetica', 'I', 10 );
			$this->Cell(0, 10, 'Scarlett Marijs - Frans Campmanweg 8 - 6817 XT Renkum - 06 21712945 - info@scarlettmarijs.nl',0,0, 'C');
		}
	}
	
	$pdf=new PDF('P', 'mm', 'A4');
	$pdf->AddPage();
	$pdf->SetFont('helvetica', 'B', 16);
	$pdf->SetTextColor(180,31,115);
	$pdf->Cell(10,10);
	$pdf->Cell(40,10, 'ORDERBEVESTIGING',0, 1);
	$pdf->Ln();
	$pdf->SetFont('helvetica', '', 11);
	$pdf->SetTextColor(0);
	$pdf->Cell(20,6);
	$pdf->Cell(40,6, $voornaam . " " . $achternaam, 0, 1);
	$pdf->Cell(20,6, '', 0, 0);
	$pdf->Cell(40,6, $adres, 0, 1);
	$pdf->Cell(20,6, '', 0, 0);
	$pdf->Cell(40,6, $postcode . "  " . $plaats, 0, 1);
	$pdf->Ln(15);
	$pdf->SetTextColor(0);
	$pdf->SetFont('helvetica', 'B', 10);
	$pdf->Cell(10,6, '', 0, 0);
	$pdf->Cell(30,6, 'Ordernummer', 0, 0);
	$pdf->SetFont('helvetica', '', 10);
	$pdf->Cell(40,6, ': ' . $bestelnummer, 0, 1);
	$pdf->SetFont('helvetica', 'B', 10);
	$pdf->Cell(10,6, '', 0, 0);
	$pdf->Cell(30,6, 'Besteldatum', 0, 0);
	$pdf->SetFont('helvetica', '', 10);
	$pdf->Cell(40,6, ': ' . $besteldatum, 0, 1);
	$pdf->Ln(15);
	
	$totaalPrijs = 0;
	$verzendkosten = 0;
	$sql = 	"SELECT tblArtikel.artikelID, naam, tblOrderregel.orderaantal, prijs, brievenbus " .
			"FROM tblArtikel " .
			"JOIN tblOrderregel " .
			"ON tblArtikel.artikelID = tblOrderregel.artikelID " .
			"WHERE bestellingID = '" . $bestellingID . "'";
	$artikelen = mysql_query($sql);
	if(mysql_num_rows($artikelen) > 0) //artikelen aanwezig in de bestelling
	{
		// tabelheaders toevoegen
		$pdf->SetFont('helvetica', 'B', 10);
		$pdf->Cell(10,6, '', 0, 0);
		$pdf->Cell(20,6, 'art.nr.', 0, 0);
		$pdf->Cell(70,6, 'Titel', 0, 0);
		$pdf->Cell(10,6, 'aantal', 0, 0);
		$pdf->Cell(26,6, 'prijs p.st.', 0, 0, 'R');
		$pdf->Cell(26,6, 'Totaal', 0, 1, 'R');
		$pdf->Ln(10);
		while ($rij = mysql_fetch_array($artikelen))
		{
			$regeltotaal = $rij["orderaantal"] * $rij["prijs"];
			$pdf->SetFont('helvetica', '', 10);
			$pdf->Cell(10,6, '', 0, 0);
			$pdf->Cell(20,6, artikelnummer($rij["artikelID"]), 0, 0);
			$pdf->Cell(70,6, $rij["naam"], 0, 0);
			$pdf->Cell(10,6, $rij["orderaantal"], 0, 0);
			$pdf->Cell(12,6, '€', 0, 0, 'R');
			$pdf->Cell(14,6, number_format($rij["prijs"], 2, ',', '.'), 0, 0, 'R');
			$pdf->Cell(12,6, '€', 0, 0, 'R');
			$pdf->Cell(14,6, number_format($regeltotaal, 2, ',', '.'), 0, 1, 'R');
			$totaalPrijs = $totaalPrijs + $regeltotaal;
			
			if ($rij["brievenbus"] == 'on') {
				$verzendkosten = 1.75;
			}
			else {
				$verzendkosten = 5;
			}
		}
		// Kijken wat de uiteindelijke verzendkosten zijn
		if(mysql_num_rows($artikelen) > 1) //bij meerdere artikelen geen brievenbuspost meer
		{
			$verzendkosten = 5;
		}
		if($totaalPrijs >= 50) //bij meerdere artikelen geen brievenbuspost meer
		{
			$verzendkosten = 0;
		}
		mysql_free_result($artikelen);
		
		// verzendkosten bij de totaalprijs optellen
		$totaalPrijs = $totaalPrijs + $verzendkosten;
		
		$pdf->Ln(10);
		$pdf->SetFont('helvetica', '', 10);
		$pdf->Cell(30,6, '', 0, 0);
		$pdf->Cell(70,6, 'Verzendkosten', 0, 0);
		$pdf->Cell(36,6, '', 0, 0, 'R');
		$pdf->Cell(12,6, '€', 0, 0, 'R');
		$pdf->Cell(14,6, number_format($verzendkosten, 2, ',', '.'), 0, 1, 'R');
		$pdf->Ln(8);
		$pdf->SetFont('helvetica', 'B', 10);
		$pdf->Cell(30,6, '', 0, 0);
		$pdf->Cell(70,6, 'Totaal van deze bestelling', 0, 0);
		$pdf->Cell(36,6, '', 0, 0, 'R');
		$pdf->Cell(12,6, '€', 0, 0, 'R');
		$pdf->Cell(14,6, number_format($totaalPrijs, 2, ',', '.'), 0, 1, 'R');
// 		$pdf->Ln(30);
// 		$pdf->SetFont('helvetica', '', 10);
// 		$pdf->Cell(30,6, '', 0, 0);
// 		$pdf->Cell(70,6, 'Totaal bedrag excl. BTW', 0, 0);
// 		$pdf->Cell(36,6, '', 0, 0, 'R');
// 		$pdf->Cell(12,6, '€', 0, 0, 'R');
// 		$pdf->Cell(14,6, number_format(totaalExBTW($totaalPrijs), 2, ',', '.'), 0, 1, 'R');
// 		$pdf->Cell(30,6, '', 0, 0);
// 		$pdf->Cell(70,6, '21% BTW', 0, 0);
// 		$pdf->Cell(36,6, '', 0, 0, 'R');
// 		$pdf->Cell(12,6, '€', 0, 0, 'R');
// 		$pdf->Cell(14,6, number_format(BTW($totaalPrijs), 2, ',', '.'), 0, 1, 'R');
	}
	
	$tmpfname = "H764fis/" . uniqid() . ".pdf";
	$pdf->Output($tmpfname, 'F');
	
	// attachement aan mail toevoegen
	$mail->AddAttachment($_SERVER["DOCUMENT_ROOT"] . "/testsite/$tmpfname", "ordernummer_" . $bestelnummer . ".pdf");
	// melding na verzenden klaarzetten
	if(!$mail->Send()) // niet gelukt om email te verzenden, bestelling blijft open
		$strMessage = "De bestelling kon niet worden voltooid. Controleer uw persoonlijke gegevens en probeer het opnieuw of neem contact met ons op.";
	else
	{
	// mail verstuurd, bestelling afronden
		// factuur in database plaatsen
		$sql = "INSERT INTO tblFactuur (bestand, bestellingID) VALUES ('" . mysql_real_escape_string($tmpfname) . "' , '" . $bestellingID . "')";
		if(!mysql_query($sql))
		{
			echo("orderbevestiging kon niet worden toegevoegd");
		}
		$factuurID = mysql_insert_id();
		// status van de bestelling op 'in behandeling' zetten en bestelnummer toevoegen aan database. Sessieid wissen en factuur koppelen
		$sql = 	"UPDATE tblBestelling " .
				"SET bestelstatus = 'In behandeling', sessionID = NULL, bestelnummer = '$bestelnummer' " .
				"WHERE bestellingID	= " . $bestellingID;
		if (!mysql_query($sql))
		{
			die("De status van de bestelling kon niet worden aangepast" . $sql);
		}
		
		// voorraad bijwerken
		$sql = "SELECT tblOrderregel.artikelID, orderaantal, aantal FROM tblOrderregel " .
		"JOIN tblArtikel " .
		"ON tblArtikel.artikelID = tblOrderregel.artikelID " .
		"WHERE bestellingID	= " . $bestellingID;
		$orderregels = mysql_query($sql);
		while($rij = mysql_fetch_array($orderregels))
		{
			$voorraad = $rij["aantal"] - $rij["orderaantal"];
			$sql = 	"UPDATE tblArtikel " .
					"SET aantal = $voorraad " .
					"WHERE artikelID	= " . $rij[artikelID];
			if (!mysql_query($sql))
			{
				die("De voorraad kon niet worden aangepast" . $sql);
			}
			if ($voorraad < 1) // laatste artikel verkocht
			{
				// verkoopdatum vullen
				$strVerkoopDatum = date("Y-m-d");
				$sql = 	"UPDATE tblArtikel " .
						"SET verkoopDatum = '" . mysql_real_escape_string($strVerkoopDatum) . "' " .
						"WHERE artikelID	= " . $rij[artikelID];
				//die($sql);
				if (!mysql_query($sql))
				{
					die("De verkoopdatum kon niet worden toegevoegd" . $sql);
				}
			}
		}
			
		
		// melding op scherm
		$strMessage = "Beste " . $voornaam . " " . $tussenvoegsel . " " . $achternaam . "<br /><br />Dank voor uw bestelling!<br /><br />U ontvangt de bevestigings e-mail en de orderbevestiging op het volgende e-mailadres: " . $email ."<br /><br />Wij sturen u binnen twee werkdagen een factuur. Na betaling van de factuur sturen wij uw artikelen op.<br /><br />";
	}
		
}
else 
{
	// klantID toevoegen aan de bestelling
	$sql = 	"UPDATE tblBestelling " .
			"SET klantID = " . $_SESSION["klantID"] . " " .
			"WHERE bestellingID	= " . $bestellingID;
	if (!mysql_query($sql))
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
                $sql = 	"SELECT tblArtikel.artikelID, naam, tblOrderregel.orderaantal, prijs, brievenbus " .
                		"FROM tblArtikel " .
                		"JOIN tblOrderregel " .
                		"ON tblArtikel.artikelID = tblOrderregel.artikelID " .
                		"WHERE bestellingID = '" . $bestellingID . "'";
				$artikelen = mysql_query($sql);
				if(mysql_num_rows($artikelen) > 0) // artikelen aanwezig in de bestelling
				{
				?>
				<form action="<?php echo $_SERVER["PHP_SELF"] ?>" method="post">
				<table class="winkelmandje" border="0" cellspacing="0" cellpadding="0">
				<?php
					while($rij = mysql_fetch_array($artikelen))
					{
					?>
					<!-- begin artikelrij -->
	                  <tr class="artikelrij">
	                    <td><a href="artikel.php?artikelID=<?php echo($rij["artikelID"]); ?>"><?php echo($rij["naam"]); ?></a><br /><span class="artnr">art.nr. <?php echo(artikelnummer($rij["artikelID"])); ?></span></td>
	                    <td><?php echo($rij["orderaantal"]); ?></td>
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
						if(mysql_num_rows($artikelen) > 1) //bij meerdere artikelen geen brievenbuspost meer
						{
							$verzendkosten = 5;
						}
						if($totaalPrijs >= 50) //bij meerdere artikelen geen brievenbuspost meer
						{
							$verzendkosten = 0;
						}
						mysql_free_result($artikelen);
						// verzendkosten bij totaal optellen
						$totaalPrijs = $totaalPrijs + $verzendkosten;
	                  ?>
	                  <tr>
	                    <td colspan="4">&nbsp;</td>
	                  </tr>
	                  <tr>
	                    <td>Indicatie verzendkosten<br />&nbsp;</td>
	                    <td></td>
	                    <td class="bedrag">&euro;&nbsp;</td>
	                    <td class="bedrag"><?php echo(number_format($verzendkosten, 2, ',', '.')); ?></td>
	                  </tr>
	                  <tr class="totaalregel">
	                    <td>Totaalbedrag inclusief BTW<br />&nbsp;</td>
	                    <td></td>
	                    <td class="bedrag">&euro;&nbsp;</td>
	                    <td class="bedrag"><?php echo(number_format($totaalPrijs, 2, ',', '.')); ?></td>
					  </tr>
<!--  				  <tr>
	                    <td>Totaalbedrag exclusief BTW</td>
	                    <td></td>
	                    <td class="bedrag">&euro;&nbsp;</td>
	                    <td class="bedrag">
	                    	<?php // echo(number_format(totaalExBTW($totaalPrijs), 2, ',', '.')); ?>
	                    </td>
	                  </tr>
	                  <tr>
	                    <td>21% BTW</td>
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
		        	$klant = mysql_query($sql);
		        	$rij = mysql_fetch_array($klant);
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
	        		mysql_free_result($klant);
	        	?>
	        	<p>Als dit niet juist is, kunt u uw <a href= "wijzigen.php" title="gegevens wijzigen">gegevens aanpassen</a>.</p>
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
<?php mysql_close($db); ?>
