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
		   		<h2>Disclaimer</h2>
   			<div class="zakelijk">
<p>Hoewel wij ernaar streven om correcte informatie te verschaffen, kunnen wij niet garanderen dat de content op deze website juist en volledig is.</p>
<p>Verwijzingen naar andere sites zijn enkel opgenomen ter informatie van de gebruikers van de site. wij zijn niet verantwoordelijk voor de inhoud of beschikbaarheid van deze sites of bronnen. Wij zijn niet aansprakelijk voor schade als gevolg van onjuistheden, onvolledigheden die getoond zijn op deze website.</p>
<p>Scarlett Marijs behoudt zich het recht voor om de informatie op deze site te wijzigen zonder enige aanmelding of bekendmaking vooraf.</p>
   			
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