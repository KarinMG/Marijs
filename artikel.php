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
			<?php 
        		$sql = 	"SELECT * " .
          			 	"FROM tblArtikel " .
          		  		"WHERE artikelID = " . mysqli_real_escape_string($conn, $_GET["artikelID"]);
        		$resultaat = mysqli_query($conn, $sql);
        		  
        		while ($rij = mysqli_fetch_assoc($resultaat))
        		{
	        ?>
	        	<h2><?php echo($rij["naam"]); ?></h2>
            <img class="thumbnail" src="artikelafb/<?php echo($rij["afbeelding"]); ?>" alt="<?php echo($rij["naam"]); ?>" />
                  
            <?php 
            	if($rij["archief"] != 'on'){
            ?>      
                  <table class="artikelinfo" border="0" cellspacing="0" cellpadding="0">
   				    <tr>
                      <td class="artLabel">Titel</td>
                      <td><?php echo($rij["naam"]); ?></td>
                    </tr>
                    <tr>
                      <td class="artLabel">Art.nr.</td>
                      <td class="artValue"><?php echo artikelnummer($rij["artikelID"]); ?></td>
                    </tr>
                    <tr>
                      <td class="artLabel">Voorraad</td>
                      <?php 
                      if($rij["aantal"] < 1) {
						?>
                      	<td>Niet op voorraad</td>
                      	<?php
                      }
                      else {
					  ?>
                        <td><?php echo($rij["aantal"]); ?> op voorraad</td>
                      <?php 
                      }
                        ?>
                    </tr>
                    <tr>
                      <td class="artLabel">Afmetingen</td>
                      <td><?php echo($rij["formaat"]); ?></td>
                    </tr>
                    <tr>
                      <td class="artLabel">Materiaal</td>
                      <td><?php echo($rij["materiaal"]); ?></td>
                    </tr>
                    <tr>
                      <td class="artLabel">Prijs</td>
                      <td>&euro; <?php echo(number_format($rij["prijs"], 2, ',', '.')); ?></td>
                    </tr>
                    <tr>
                      <td class="artLabel">Omschrijving</td>
                      <td><?php echo ($rij["omschrijving"]); ?></td>
                    </tr>
                    <tr> 
                    <td></td> 
                      <td>
                      <?php 
                      if($rij["aantal"] < 1) // artikel niet meer te koop
                      	echo("<a href=\"bestellen.php?artikelID=" . $rij["artikelID"] . "\" class=\"btn btn-default\">Bestellen</a>");
                      else
                      	echo("<a href=\"winkelmandje.php?artikelID=" . $rij["artikelID"] . "\" class=\"btn btn-default\">Bestellen</a>");
                      ?>
                      </td>
                    </tr>
                    <?php 
                    if($rij["persoonlijk"] == 'on') // artikel kan gepersonaliseerd worden
                    {
                    ?>
                    <tr> 
                    <td></td> 
                      <td>
                      	<a href="personaliseren.php?artikelID=<?php echo $rij["artikelID"] ?>" class="btn btn-default" title="bestellen met persoonlijke tekst">Bestellen met persoonlijke tekst</a>
                      </td>
                    </tr>
                    <?php 
                    }
                    ?>
                 </table>
                 <?php 
                 }
                 else {
                 ?>
                 <table class="artikelinfo" border="0" cellspacing="0" cellpadding="0">
   				    <tr>
                      <td class="artLabel">Titel</td>
                      <td><?php echo($rij["naam"]); ?></td>
                    </tr>
                    <tr>
                      <td class="artLabel">Afmetingen</td>
                      <td><?php echo($rij["formaat"]); ?></td>
                    </tr>
                    <tr>
                      <td class="artLabel">Materiaal</td>
                      <td><?php echo($rij["materiaal"]); ?></td>
                    </tr>
                    <tr>
                      <td class="artLabel">Omschrijving</td>
                      <td><?php echo ($rij["omschrijving"]); ?></td>
                    </tr>
                    
                 </table>
                 
                 
                 <?php 
                 }
		   		   }
		   		   mysqli_free_result($resultaat);
		           ?>
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

