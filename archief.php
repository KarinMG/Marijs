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
	 <title>Eerder werk</title>
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
			   	<h2 class="artikel">Eerder werk</h2>
			   	
	        	<?php 
	        	//indexen zetten voor de clearfix na 2 items(sm) of 3 items(md)
	        	$index_sm = 1;
	        	$index_md = 1;
	        	
	        	    $sql = 	"SELECT * " .
							"FROM tblArtikel " .
 							"WHERE archief = 'on' " .
 							"ORDER BY artikelID";
	        		$resultaat = mysqli_query($conn, $sql);
			   		
			   		while ($rij = mysqli_fetch_assoc($resultaat))
			   		{   		
				   	?>		
				   	<div class="artikel col-xs-12 col-sm-6 col-md-4">
				   		<a href="artikel.php?artikelID=<?php echo($rij["artikelID"]); ?>"><img src="artikelafb/<?php echo($rij["afbeelding"]); ?>" class="thumbnail" alt="<?php echo($rij["naam"]); ?>" /></a><div class=artikeltitel><h3 class="titel"><a href="artikel.php?artikelID=<?php echo($rij["artikelID"]); ?>"><?php echo($rij["naam"]); ?></a></h3></div>
				    	<?php
	
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
