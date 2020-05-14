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

$bestellingID = $_GET["bestellingID"];

// ophalen klantgegevens en in variabelen zetten
$klantID = $_SESSION["klantID"];
$sql = "SELECT * FROM tblKlant WHERE klantID = " . mysqli_real_escape_string($conn, $klantID);
$klant = mysqli_query($conn, $sql);
	
$rij = mysqli_fetch_assoc($klant);
$voornaam = $rij["voornaam"];
$tussenvoegsel = $rij["tussenvoegsel"];
$achternaam = $rij["achternaam"];
$adres = $rij["adres"];
$postcode = $rij["postcode"];
$plaats = $rij["plaats"];
mysqli_free_result($klant);


?>

<!DOCTYPE html>
<html>
<head>
	 <title>Scarlett Marijs - Bestellinggegevens</title>
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
	 		<h2>Bestellinggegevens</h2>
        	<?php 
			$sql = "SELECT * FROM tblBestelling WHERE bestellingID = '" . mysqli_real_escape_string($conn, $bestellingID) . "'";
			
			if($bestelling = mysqli_query($conn, $sql))
			{
				// controleren of deze bestelling idd bij deze klant hoort
				$rij = mysqli_fetch_assoc($bestelling);
				if($rij["klantID"] != $klantID) { //deze bestelling behoort niet bij deze klant
					die("U heeft geen rechten om deze bestelling te bekijken.");
				}
				else {
					$besteldatum = MysqlNlDateLang($rij["datum"]);
					$bestelnummer = $rij["bestelnummer"];
					$bestelstatus = $rij["bestelstatus"];
					mysqli_free_result($bestelling);
				}
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
        	  <tr>
        	    <td>Bestelstatus</td>
        	    <td>: </td>
        	    <td><?php echo($bestelstatus); ?></td>
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
				
				<table class="winkelmandje" border="0" cellspacing="0" cellpadding="0">
				<?php
					while($rij = mysqli_fetch_assoc($artikelen))
					{
					?>
					<!-- begin artikelrij -->
	                  <tr class="artikelrij">
	                    <td>
	                    	<a href="artikel.php?artikelID=<?php echo($rij["artikelID"]); ?>"><?php echo($rij["naam"]); ?></a><br />
	                    	<span class="artnr">art.nr. <?php echo(artikelnummer($rij["artikelID"])); ?></span><br />
	                    </td>
	                    <td><?php echo($rij["orderaantal"]); ?></td>
						<td class="bedrag">&euro;&nbsp;</td>
						<td class="bedrag"><?php echo(number_format($rij["orderaantal"] * $rij["prijs"], 2, ',', '.')); ?></td>
	                  </tr>
	                  
	                  
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
                <h3>Verzendadres</h3>
        		<?php echo($voornaam . " " . $tussenvoegsel . " " . $achternaam); ?><br />
	        	<?php echo($adres); ?><br />
	        	<?php echo($postcode). "  " . $plaats; ?><br /><br />
	        	<a href="account.php" class="btn btn-default">Terug naar mijn account</a>          
              <?php 
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
