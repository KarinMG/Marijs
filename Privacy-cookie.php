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
	 		<div class="row">
		   		<div class="col-xs-12">
		   		<h2>Privacy- en cookiestatement</h2>
   				<div class="zakelijk">
   				<h3>Privacy statement</h3>
<p>Scarlett Marijs respecteert de privacy van alle gebruikers van haar site en draagt er zorg voor dat de persoonlijke informatie die u Scarlett Marijs verschaft vertrouwelijk wordt behandeld. Scarlett Marijs gebruikt uw gegevens om de bestellingen zo snel en gemakkelijk mogelijk te laten verlopen. Voor het overige zal zij deze gegevens uitsluitend gebruiken met uw toestemming. Scarlett Marijs zal uw persoonlijke gegevens niet aan derden verkopen.</p>
 
<p>Scarlett Marijs gebruikt de verzamelde gegevens om haar klanten de volgende diensten te leveren:</p>
<ul class="content">
	<li>Als u een bestelling plaatst, heeft Scarlett Marijs uw naam, e-mailadres, afleveradres en betaalgegevens nodig om uw bestelling uit te voeren en u van het verloop daarvan op de hoogte te houden.</li>
	<li>Om het winkelen bij Scarlett Marijs zo aangenaam mogelijk te laten zijn, worden  met uw toestemming uw persoonlijke gegevens en de gegevens met betrekking tot uw bestelling en het gebruik van onze diensten opgeslagen. Hierdoor kunnen wij de website personaliseren.</li>
	<li>U maakt een account aan bij Scarlett Marijs met een gebruikersnaam en wachtwoord, zodat u  uw naam, adres, telefoonnummer, e-mailadres, aflever- en betaalgegevens, niet bij iedere nieuwe bestelling hoeft in te vullen.</li>
</ul> 
<h3>Scarlett Marijs verkoopt uw gegevens niet</h3>
<p>Scarlett Marijs zal uw persoonlijke gegevens niet aan derden verkopen.</p>
 
<h3>Cookies</h3>
<p>Cookies zijn kleine stukjes informatie die door uw browser worden opgeslagen op uw computer. Scarlett Marijs gebruikt cookies om u te herkennen bij een volgend bezoek. Cookies stellen ons in staat om informatie te verzamelen over het gebruik van de diensten en deze te verbeteren en aan te passen aan de wensen van de bezoekers. Onze cookies geven informatie met betrekking tot persoonsidentificatie.</p>
 
<p>Indien u nog vragen mocht hebben over de Privacy statement van Scarlett Marijs, dan kunt u contact met mij opnemen.</p>
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