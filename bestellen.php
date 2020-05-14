<?php
require_once 'config.php';
require_once 'lib/lib.php';

// Create connection
$conn = mysqli_connect($strServerName, $strUsername, $strPassword, $strDbName);
// Check connection
if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}

$artikelID = $_GET["artikelID"];


?>

<!DOCTYPE html>
<html>
<head>
	 <title>bestellen</title>
	 <meta name="viewport" content="width=device-width, initial-scale=1.0"  charset=utf-8>
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
			<h2>Artikel bestellen</h2>
			<?php 
        		$sql = 	"SELECT artikelID, naam, afbeelding " .
						"FROM tblArtikel " .
						"WHERE artikelID = " . mysql_real_escape_string($artikelID);
				$resultaat = mysql_query($sql);
				$rij = mysql_fetch_array($resultaat);
	        ?>
					
			<table class="winkelmandje">
	            <tr class="artikelrij">
		          <td class="afbKlein"><img src="artikelafb/<?php echo($rij["afbeelding"]); ?>" class="thumb_small" /></td>
		          <td class="artnaam"><?php echo($rij["naam"]); ?><br /><span class="artnr">art.nr. <?php echo(artikelnummer($artikelID)); ?></span></td>
		        </tr>
          	</table>
          	<p><br />Dit artikel is niet op voorraad, maar je kunt het wel bestellen. Houd er wel rekening mee dat het schilderij nooit helemaal hetzelfde is als op het plaatje; het is tenslotte handwerk.</p>
          	<br /><a href="winkelmandje.php?artikelID=<?php echo $artikelID; ?>" class="btn btn-default" title="bestellen">Aan bestelling toevoegen</a>
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
