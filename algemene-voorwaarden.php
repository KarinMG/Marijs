<?php
require_once 'config.php';
require_once 'lib/lib.php';

// Create connection
$conn = mysqli_connect($strServerName, $strUsername, $strPassword, $strDbName);
// Check connection
if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}
?>

<!DOCTYPE html>
<html>
<head>
	 <title>Algemene voorwaarden</title>
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
	 		<div class="row">
		   		<div class="col-xs-12">
		        <h2>Algemene voorwaarden</h2>
   			<div class="zakelijk">
			<h3>Voorwaarden</h3>

<p>Deze Algemene Voorwaarden zijn van toepassing op alle overeenkomsten die u afsluit met Scarlett Marijs. 
Door te bestellen geeft u aan met de Algemene Voorwaarden akkoord te gaan.</p>
<h3>Prijzen</h3>
<p>De prijzen worden vermeld in euro's, inclusief BTW. Verzendkosten (zie Algemene Voorwaarde, verzending) zijn niet bij de genoemde prijzen inbegrepen. Aanbiedingen gelden zolang de voorraad strekt. Scarlett Marijs kan niet gehouden worden aan prijsvermeldingen die evident onjuist zijn, bijvoorbeeld als gevolg van kennelijke invoerfouten. Aan onrechtmatige prijsinformatie kunnen geen rechten worden ontleend. </p>
<h3>Bestelling en totstandkoming overeenkomst</h3>
<p>U kunt uw bestelling plaatsen via de bestelpagina's. U dient volledig en op waarheid berust, het gehele bestelformulier in te vullen en onze algemene voorwaarden te accepteren. Een overeenkomst komt tot stand na acceptatie van de bestelling door Scarlett Marijs.</p>
<h3>Annulering van een bestelling</h3>
<p>Een bestelling kan binnen 7 werkdagen na bevestiging geannuleerd worden. Hierna is de koop gesloten en wordt betaling verwacht. Dit om onnodig reserveren van artikelen te voorkomen. Graag ontvangen wij bericht per e-mail met reden van annulering indien u afziet van de koop.</p>
<h3>Betaling</h3>
<p>Bij een bestelling dient u altijd, binnen 7 werkdagen, vooruit te betalen door middel van een overschrijving, orderbevestiging/factuur ontvangt u na het plaatsen van de bestelling. Artikelen worden gedurende deze periode voor de klant gereserveerd. Na deze periode komt de reservering automatisch te vervallen.</p>
<h3>Levering</h3>
<p>Als de betaling binnen is, worden de artikelen zo snel mogelijk verzonden. Er wordt hiervan een bevestiging verstuurd per mail. Scarlett Marijs draagt zorg voor een goede levering van de bestelde artikelen. Scarlett Marijs behoudt zich het recht voor de koopovereenkomst te ontbinden als de klant zich niet aan de voorwaarden houdt. De gestelde levertijd is een indicatie, hieraan kunnen geen rechten worden ontleend. Overschrijden van genoemde leveringstermijn geeft u geen recht op schadevergoeding. Indien echter de leveringstermijn de termijn van 30 dagen overschrijdt bent u gerechtigd de bestelling te annuleren, dan wel de overeenkomst te ontbinden voor zover dat noodzakelijk is. Reeds ge&iuml;nde bedragen zullen in dit geval binnen 14 dagen door ons worden teruggestort.</p>
<h3>Verzending</h3>
<p>Artikelen worden verzonden via TNT post als de betaling ontvangen is. Scarlett Marijs is niet aansprakelijk voor verlies of beschadiging door TNT post. Voor brievenbuspost berekenen wij 1,75 euro (let op: bij brievenbuspost zit geen track en trace). Voor alle andere pakketten  berekenen wij 5 euro. Scarlett Marijs is niet aansprakelijk voor extra verzendkosten die voortvloeien uit een foutief ingevoerd verzendadres. Bestellingen boven de 50 euro worden gratis verzonden met de Standaard Bezorgdienst van TNT Post.</p>
<h3>Retourzending</h3>
<p>Artikelen (met uitzondering van handbeschilderde- en op maat gemaakte producten) kunnen retour gezonden worden binnen 7 werkdagen na ontvangst. Graag ontvangen wij hierover binnen 7 werkdagen na ontvangst van de zending een bericht per e-mail. Vermeld hierbij het bestelnummer (te vinden op de orderbevestiging die per e-mail is ontvangen). Artikelen worden retour genomen als ze teruggezonden worden in de oorspronkelijke staat en in dezelfde onbeschadigde verpakking. Alleen als aan al deze voorwaarden is voldaan wordt de zending gecrediteerd en/of geruild.</p>
<p>Het door u reeds betaalde bedrag inclusief de verzendkosten zal, bij creditering, binnen 30 dagen gerestitueerd worden. Artikelen die op bestelling zijn ingekocht en afgeprijsde artikelen kunnen niet retour genomen of geruild worden. Ongefrankeerde of onvoldoende gefrankeerde zendingen worden niet aangenomen of gecrediteerd. Kosten voor retourzending komen voor rekening van de klant. In geval van een fout van de kant van Scarlett Marijs zal Scarlett Marijs de kosten dragen voor retourzending. Klant dient de zending dan voldoende gefrankeerd te retourneren. De portokosten worden dan aan de klant terugbetaald.</p>
            </div>
		    </div>
		</div>
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
