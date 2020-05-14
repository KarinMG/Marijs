<?php
require_once 'config.php';
require_once 'lib/lib.php';

// Create connection
$conn = mysqli_connect($strServerName, $strUsername, $strPassword, $strDbName);
// Check connection
if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}

// categorienaam ophalen voor paginatitel en -kop
$sql = "SELECT naam FROM tblCategorie WHERE categorieID = " . $_GET["categorieID"];
$categorie = mysqli_query($conn, $sql);
$rs = mysqli_fetch_assoc($categorie);
$catnaam = $rs["naam"];
mysqli_free_result($categorie);
?>

<!DOCTYPE html>
<html>
<head>
	 <title><?php echo($catnaam); ?></title>
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
			   	<h2 class="artikel"><?php echo($catnaam); ?></h2>
			   	
	        	<?php 
	        	//indexen zetten voor de clearfix na 2 items(sm) of 3 items(md)
	        	$index_sm = 1;
	        	$index_md = 1;
	        	
	        	    $sql = 	"SELECT * " .
							"FROM tblArtikel " .
							"INNER JOIN tblCategorieArtikel " .
							"ON tblArtikel.artikelID = tblCategorieArtikel.artikelID " .
							"WHERE tblCategorieArtikel.categorieID = " . $_GET["categorieID"] . " && tblArtikel.archief != 'on' " .
							"ORDER BY tblArtikel.artikelID";

	        		$resultaat = mysqli_query($conn, $sql);

			   		while ($rij = mysqli_fetch_assoc($resultaat))
			   		{   		
			   	?>		
			   	<div class="artikel col-xs-12 col-sm-6 col-md-4">
			   		<a href="artikel.php?artikelID=<?php echo($rij["artikelID"]); ?>"><img src="artikelafb/<?php echo($rij["afbeelding"]); ?>" class="thumbnail" alt="<?php echo($rij["naam"]); ?>" /></a><div class=artikeltitel><h3 class="titel"><a href="artikel.php?artikelID=<?php echo($rij["artikelID"]); ?>"><?php echo($rij["naam"]); ?></a></h3></div>
			   		<p class="prijs">&euro; <?php echo(number_format($rij["prijs"], 2, ',', '.')); ?></p>
			   		<?php 
				   		if($rij["aantal"] < 1) // artikel niet op voorraad
				   		{
				   			echo("<p>niet op voorraad</p>");
				   		?>
				   			<a href="bestellen.php?artikelID=<?php echo($rij["artikelID"]); ?>" class="btn btn-default">Bestellen</a>
				   		<?php
				   		}
				   		else
						{
							echo("<p>" . $rij["aantal"] . " op voorraad</p>");
				   		?>
				   		<a href="winkelmandje.php?artikelID=<?php echo($rij["artikelID"]); ?>" class="btn btn-default">Bestellen</a>
				    	<?php
						}
						
						echo("</div>");  
					
					// clearfix toevoegen indien nodig en index ophogen of resetten
					if($index_sm == 2){
						echo "<div class=\"clearfix visible-sm\"></div>";
						$index_sm = 1;
					}
					else {
						$index_sm++;
					}
					if($index_md == 3){
						echo "<div class=\"clearfix visible-md visible-lg\"></div>";
						$index_md = 1;
					}
					else {
						$index_md++;
					}
			   	}
			   	mysqli_free_result($resultaat);
			    ?>
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
