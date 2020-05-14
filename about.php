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
	 	<h2>Over de maker</h2>
	 		<div class="img-content"><img class="img-thumbnail" src="images/MirellaMarijs.jpeg" alt="Mirella Marijs" /></div>
			<p>Ik heb altijd al veel interesse gehad in ontwerpen en cre&euml;ren. Al vroeg was ik bezig om sieraden te maken, kettingen te ontwerpen, 3D kaarten te versturen of te schilderen. Deze hobby - nee: passie - heb ik verder ontwikkeld en ik probeer nieuwe trends op te pakken en mee te nemen in mijn eigen creatieve wereld.</p>

			<p>Voor de verjaardag van mijn oudste nichtje, heb ik een persoonlijk schilderij gemaakt voor haar slaapkamer. Het plezier van het geven en ontvangen van een uniek en persoonlijk cadeau is me bijgebleven en dat wil ik dan ook blijven delen.</p>
			
			<p>Inmiddels al weer meer dan een jaar geleden ben ik mijn webwinkel begonnen. Ik had al vrij snel een gevarieerd aanbod. Te denken valt aan schilderijtjes, dromenvangers en  zelfs handgemaakte Tutu&#39;s.</p>
			
			<p>In mijn winkel vind je een vast aanbod met gemaakte schilderijen, maar mocht je een schilderij nog persoonlijker willen maken, dan kan er op het schilderij naar keuze een naam - of boodschap - komen te staan, het moet wel passen natuurlijk.</p>
			<p>Valt je keuze op een eerder gemaakt schilderij, dan kan ik deze in opdracht weer maken. Let wel; omdat het  handgemaakt is, kan het altijd iets verschillen, dat maakt het juist uniek.</p>
			
			<p>Iedere opdracht krijgt nog een persoonlijk tintje. Wat dat is? Dat blijft tot het eind een verassing.</p> 
			<p>Ik hoop dat ik in de toekomst door enthousiaste mond op mond reclame mijn klantenkring zie groeien en dat bestaande klanten vaker bij me zullen aankloppen. Kwaliteit en plezier staan voor mij voorop in wat ik doe, waarbij ik hoop dat iedereen die een cadeautje krijgt van Scarlett Marijs, meteen doorheeft wat het is: Handmade, with love.</p>
			
			<p>Mirella Marijs - Eigenaresse Scarlett Marijs Webwinkel</p>
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
