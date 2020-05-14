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
        		$sql = "SELECT * FROM tblKlant WHERE klantID = " . $_SESSION["klantID"];
				$resultaat = mysqli_query($conn, $sql);

				$rij = mysqli_fetch_assoc($resultaat);
			?>
   				<h2>Mijn gegevens</h2>
                <table class="klantgegevens">
	              <tr>
	                <td class="tabLabel">Voornaam</td>
	                <td class="separator">:&nbsp;</td>
	                <td class="value"><?php echo($rij["voornaam"])?></td>
	              </tr>
	              <tr>
	                <td class="tabLabel">Achternaam</td>
	                <td>:&nbsp;</td>
	                <td><?php echo($rij["tussenvoegsel"]) . " "; ?><?php echo($rij["achternaam"]); ?></td>
	              </tr>
	              <tr>
	                <td class="tabLabel">Man/vrouw</td>
	                <td>:&nbsp;</td>
	                <td><?php if($rij["geslacht"] == "M") {echo("Man");} else{echo("Vrouw");} ?></td>
	              </tr>
	              <tr>
	                <td class="tabLabel">Adres</td>
	                <td>:&nbsp;</td>
	                <td><?php echo($rij["adres"]); ?></td>
	              </tr>
	              <tr>
	                <td class="tabLabel">Postcode</td>
	                <td>:&nbsp;</td>
	                <td><?php echo($rij["postcode"]); ?></td>
	              </tr>
	              <tr>
	                <td class="tabLabel">Woonplaats</td>
	                <td>:&nbsp;</td>
	                <td><?php echo($rij["plaats"]); ?></td>
	              </tr>
	              <tr>
	                <td class="tabLabel">E-mail</td>
	                <td>:&nbsp;</td>
	                <td><?php echo($rij["email"]); ?></td>
	              </tr>
	              <tr>
	                <td class="tabLabel">Telefoonnummer</td>
	                <td>:&nbsp;</td>
	                <td><?php echo($rij["telefoon"]); ?></td>
	              </tr>
	              <tr>
	                <td class="tabLabel">Geboortedatum</td>
	                <td>:&nbsp;</td>
	                <td><?php if($rij["geboortedatum"] != "0000-00-00") { echo(MysqlNlDate($rij["geboortedatum"])); }?></td>
	              </tr>
	              <tr>
	                <td class="tabLabel">Aanmelddatum</td>
	                <td>:&nbsp;</td>
	                <td><?php echo(MysqlNlDate($rij["aanmelddatum"])); ?></td>
	              </tr>
<!--  	              <tr> -->
<!--  	                <td class="tabLabel">Nieuwsbrief</td> -->
<!--  	                <td>:&nbsp;</td> -->
<!-- 	                <td> -->
	                <?php 
//  	                		if(!$rij["nieuwsbrief"]) 
//  							{
//  								echo("nee");
//  							} 
//  							else
//  							{
//  								echo("ja");
// 							} ?>
<!-- 					</td> -->
<!--  	            	</tr> -->
	              <tr>
	                <td>&nbsp;</td>
	                <td>&nbsp;</td>
	                <td>&nbsp;</td>
	              </tr>
	              <tr>
	                <td>&nbsp;</td>
	                <td>&nbsp;</td>
	                <td><a href="wijzigen.php" class="btn btn-default">Mijn gegevens wijzigen</a></td>
	              </tr>
            	</table>
            	<?php 
				mysqli_free_result($resultaat);
                ?>
              	<h2>Mijn bestellingen</h2>
              	<?php 
              	$sql =  "SELECT * " .
              			"FROM tblBestelling " .
              			"WHERE klantID = " . $_SESSION["klantID"] . " && bestelstatus != 'open' " .
              	"ORDER BY datum DESC"; 
                $bestellingen = mysqli_query($conn, $sql);
                if(mysqli_num_rows($bestellingen) > 0)
                {
                ?>
                <table class="zoekresultaat">
                  <tr>
                   <th>Ordernummer</th>
                   <th>Besteldatum</th>
                   <th>Bestelstatus</th>
                   <th></th>
                  </tr>
                <?php 
                while ($rij = mysqli_fetch_assoc($bestellingen))
                {
                	$bestelnummer = $_SESSION["klantID"] . "-" . ordernummer($rij["bestellingID"]);
                ?>
                  
                  <tr>
                    <td><?php echo($bestelnummer); ?></td>
                    <td><?php echo(MysqlNlDate($rij["datum"])); ?></td>
                    <td><?php echo($rij["bestelstatus"]); ?></td>
                    <td><a href="bestellingdetail.php?bestellingID=<?php echo($rij["bestellingID"]); ?>">Bekijk deze bestelling</a></td>
                  </tr>
                  
                  
                  <?php 
                }
                	mysqli_free_result($bestellingen);
                  ?>
                </table>
                <?php
                }
                else
                {
                	echo("<br />Er zijn geen bestellingen gevonden<br /><br /><br />");
                }
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

