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
			<h2>Op maat of op naam</h2>
			<div class="img-content"><img class="img-responsive" src="images/opnaam.png" alt="Op naam gemaakt werk" /></div>
			<p>In de winkel vind je ons aanbod met gemaakte schilderijen. Zit wat je zoekt er net niet bij? Dan kun je werk in opdracht laten maken, zodat het nog persoonlijker wordt en helemaal past bij de kamer van je kind.</p>
			<h3>Schilderij op naam of met een boodschap?</h3>
			<p>Mocht je een schilderij nog persoonlijker willen maken, dan kan er op het schilderij naar keuze een naam - of boodschap - komen te staan. Het moet wel passen natuurlijk. Stuur me in dat geval even een e-mail.'.</p>
			<h3>Al verkocht?</h3>
			<p>Valt je keuze op een schilderij dat niet op vooraad is, dan kan deze in opdracht opnieuw worden gemaakt. Let op; omdat het handgemaakt is, is het schilderij nooit precies hetzelfde. Dat maakt het juist uniek.</p>
			<h3>Interesse in eerder werk?</h3>
			<p>Zie je een schilderij in de rubriek <a href="archief.php" title="Eerder werk">Eerder werk</a> dat je interessant vindt? Neem dan even contact met ons op door een <a href="mailto:info@scarlettmarijs.nl?subject=Interesse in eerder werk" title="Stuur een e-mail naar Scarlett Marijs">mail</a> te sturen of te bellen.</p>
			<h3>Helemaal op maat?</h3>
			<p>Wil je een schilderij letterlijk op maat laten maken (afmetingen) of heb je een speciaal onderwerp of een eigen kleurstelling voor de kinderkamer? <a href="mailto:info@scarlettmarijs.nl?subject=Verzoek maatwerk" title="Stuur een e-mail naar Scarlett Marijs">Stuur een email met uw wensen</a> en in overleg krijgt u een persoonlijk aanbod.</p>
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
