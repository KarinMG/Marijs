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
		        <h2>Betaling en verzending</h2>
		<h3>Betaling</h3>
		<p>Binnen twee werkdagen na uw bestelling ontvangt u per e-mail een factuur. Deze factuur moet u binnen 7 dagen betalen. Artikelen worden gedurende deze periode voor u gereserveerd.</p>
		<h3>Verzending</h3>
		<p>Als de betaling binnen is, worden de artikelen zo snel mogelijk verzonden. U ontvangt hiervan een bevestiging per mail.</p>
		<p>De bestelling wordt, indien op voorraad, binnen twee werkdagen na ontvangst van je betaling verzonden. <br />
		Voor handgemaakte gepersonaliseerde producten is de levertijd 7 werkdagen.</p>
		<h3>Verzendkosten</h3> 
		<p>Voor brievenbuspost bestellingen wordt  1,75 euro berekend. Voor alle andere bestellingen zijn de verzendkosten 5 euro. Bij bestellingen boven 50 euro betaal je geen verzendkosten!</p>
		<h3>Bestelling annuleren</h3>
		<p>Een bestelling kan binnen 7 werkdagen na bevestiging per e-mail geannuleerd worden.</p>
		
		<h3>Algemene voorwaarden</h3>
		<p>Lees alle details over betaling, verzending, annulering en retourzending in de <a href="algemene-voorwaarden.php" title="Lees de algemene voorwaarden">algemene voorwaarden</a>.</p>
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
