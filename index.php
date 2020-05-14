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
		   		<?php
		   		//indexen zetten voor de clearfix na 2 items(sm), 3 items(md) of 4 items (lg)
		   		$index_sm = 1;
		   		$index_md = 1;
		   		//$index_lg = 1;
		
		   		$sql = "SELECT * FROM tblCategorie";
		   		$resultaat = mysqli_query($conn, $sql);
		   		
		   		while ($rij = mysqli_fetch_assoc($resultaat))
		   		{ 
		   			
		   		?>		
		   		  <div class="caption col-xs-12 col-sm-6 col-md-4">
		            <h3><a href="categorie.php?categorieID=<?php echo($rij["categorieID"]); ?>" title="<?php echo($rij["naam"]); ?>"><?php echo($rij["naam"]) ?></a></h3>
		            <a href="categorie.php?categorieID=<?php echo($rij["categorieID"]); ?>"><img src="artikelafb/<?php echo($rij["afbeelding"]); ?>" class="thumbnail" alt="<?php echo($rij["naam"]); ?>" /></a>
		            <div><?php echo($rij["omschrijving"]); ?></div>
		          </div>
		         <?php 
		         
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
// 		         if($index_lg == 4){
// 		         	echo "<div class=\"clearfix visible-lg\"></div>";
// 		         	$index_lg = 1;
// 		         }
// 		         else {
// 		         	$index_lg++;
// 		         }
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
