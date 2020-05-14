<?php
require_once 'config.php';
require_once 'lib/lib.php';

$conn = mysqli_connect($strServerName, $strUsername, $strPassword, $strDbName);
	// Check connection
	if (!$conn) {
		die("Connection failed: " . mysqli_connect_error());
	}

if (isset($_POST["btnAanmelden"])) //knop ingedrukt
{
// validatie
$blnStop = false;

// voornaam gevuld?
if (!($_POST["txtVoornaam"]))
	{
	 	$blnStop = true;
	 	$strErrVoornaam = "<span class=\"warning\">Vul hier uw voornaam in</span><br />";
	}
// achternaam gevuld?
if (!($_POST["txtAchternaam"]))
	{
		$blnStop = true;
		$strErrAchternaam = "<span class=\"warning\">Vul hier uw achternaam in</span><br />";
	}
// geslacht valideren
if (!($_POST["blnGeslacht"]))
	{
		$blnStop = true;
		$strErrGeslacht = "<span class=\"warning\">Geef aan of u man of vrouw bent</span><br />";
	}
// adres valideren
if (!($_POST["txtAdres"]))
	{
		$blnStop = true;
		$strErrAdres = "<span class=\"warning\">Vul hier uw adres in</span><br />";
	}
// postcode valideren
if (!preg_match("/^[1-9][0-9]{3}[ ]?[a-zA-z]{2}$/", $_POST["txtPostcode"]))
	{
		$blnStop = true;
		$strErrPostcode = "<span class=\"warning\">Vul hier een geldige postcode in</span><br />";
	}
// plaats valideren
if (!($_POST["txtPlaats"]))
	{
		$blnStop = true;
		$strErrPlaats = "<span class=\"warning\">Vul hier uw woonplaats in</span><br />";
	}
// email valideren
if (!preg_match("/^((\"[^\"\f\n\r\t\v\b]+\")|([\w\!\#\$\%\&\'\*\+\-\~\/\^\`\|\{\}]+(\.[\w\!\#\$\%\&\'\*\+\-\~\/\^\`\|\{\}]+)*))@((\[(((25[0-5])|(2[0-4][0-9])|([0-1]?[0-9]?[0-9]))\.((25[0-5])|(2[0-4][0-9])|([0-1]?[0-9]?[0-9]))\.((25[0-5])|(2[0-4][0-9])|([0-1]?[0-9]?[0-9]))\.((25[0-5])|(2[0-4][0-9])|([0-1]?[0-9]?[0-9])))\])|(((25[0-5])|(2[0-4][0-9])|([0-1]?[0-9]?[0-9]))\.((25[0-5])|(2[0-4][0-9])|([0-1]?[0-9]?[0-9]))\.((25[0-5])|(2[0-4][0-9])|([0-1]?[0-9]?[0-9]))\.((25[0-5])|(2[0-4][0-9])|([0-1]?[0-9]?[0-9])))|((([A-Za-z0-9\-])+\.)+[A-Za-z\-]+))$/", $_POST["txtEmail"]))
	{
 		$blnStop = true;
 		$strErrEmail = "<span class=\"warning\">Vul een geldig e-mailadres in</span><br />";
 	}
 	else // controleren of het emailadres al in de database aan wezig is
 	{
 		$sql = 	"SELECT * ".
 				"FROM tblKlant ".
 				"WHERE email = '" . mysqli_real_escape_string($conn, $_POST["txtEmail"]) . "'";
 		$resultaat = mysqli_query($conn, $sql);
 		if(mysqli_num_rows($resultaat) > 0) // adres al in database
 		{
 			$blnStop = true;
 			while($rs = mysql_fetch_assoc($resultaat))
 			{
 				$strErrEmail = "<span class=\"warning\">Dit e-mailadres is al in gebruik.</span><br />";
 			}
 		}
 	}
// Wachtwoord valideren
 	if(preg_match("/^(?=.*\d).{8,16}$/", $_POST["txtWachtwoord"]))
 	{
 		if($_POST["txtWachtwoord"] != $_POST["txtWachtwoordRep"])
 		{
 		$blnStop = true;
 		$strErrWachtwoord = "<span class=\"warning\">De wachtwoorden komen niet overeen</span><br />";
 		}
 	}
 	else
 	{
 		$blnStop = true;
 		$strErrWachtwoord = "<span class=\"warning\">Het ingevulde wachtwoord is ongeldig</span><br />";
 	}
// telefoonnummer valideren
if (!preg_match("/^0[0-9]{9}$/", $_POST["txtTelefoon"]))
 	{
 		$blnStop = true;
 		$strErrTelefoon = "<span class=\"warning\">Vul de tien cijfers van uw telefoonnummer in</span><br />";
 	}

// 	Klant toevoegen aan database
if(!$blnStop)
	{
 		if(isset($_POST["txtGebDatum"])) 
 		{
			$mysqlDatum = preg_replace("/^([0-9]{2})-([0-9]{2})-([0-9]{4})$/", "\\3-\\2-\\1" ,$_POST["txtGebDatum"]);
		}
 		$datAanmelddatum = date("Y-m-d");
 		$salt = salt();
 		$sql = "INSERT INTO tblKlant (voornaam, tussenvoegsel, achternaam, geslacht, adres, postcode, plaats, email, wachtwoord, telefoon, nieuwsbrief, geboortedatum , aanmelddatum) VALUES ('" . mysqli_real_escape_string($conn, $_POST["txtVoornaam"]) . "' , '" . mysqli_real_escape_string($conn, $_POST["txtTussenvoegsel"]) . "'  , '" . mysqli_real_escape_string($conn, $_POST["txtAchternaam"]) . "' , '" . mysqli_real_escape_string($conn, $_POST["blnGeslacht"]) . "' , '" . mysqli_real_escape_string($conn, $_POST["txtAdres"]) . "' , '" . mysqli_real_escape_string($conn, $_POST["txtPostcode"]) . "' , '" . mysqli_real_escape_string($conn, $_POST["txtPlaats"]) . "' , '" . mysqli_real_escape_string($conn, $_POST["txtEmail"]) . "' , '" . crypt(mysqli_real_escape_string($conn, $_POST["txtWachtwoord"]), $salt) . "' , '" . mysqli_real_escape_string($conn, $_POST["txtTelefoon"]) . "' , '" . mysqli_real_escape_string($conn, $_POST["txtNieuwsbrief"]) . "' ,'" . mysqli_real_escape_string($conn, $mysqlDatum) . "', '" . mysqli_real_escape_string($conn, $datAanmelddatum) . "')";

 		if (!mysqli_query($conn, $sql))
 		{
			die("Iets is er niet goed gegaan " . $sql);
 		}
 		else //klant toegevoegd. Automatisch inloggen en doorsturen naar redirectpagina �f aangemeldpagina
 		{
 			//inloggen
 			setcookie("loginnaam", $_POST["txtEmail"], time() + (60*60*24*365));
 			$_SESSION["ingelogd"] = true;
 			$_SESSION["klantID"] = mysqli_insert_id();
 			$_SESSION["voornaam"] = $_POST["txtVoornaam"];
 			// doorsturen naar juiste pagina
 			if(isset($_SESSION["redirect"]))
 			{
 				$strRedirect = $_SESSION["redirect"];
 				unset($_SESSION["redirect"]);
 				mysqli_close($conn);
 				header("Location: ". $strRedirect);
 			}
 			else
 			{
 				mysqli_close($conn);
 				header("Location: aangemeld.php");
 			}
 			
 		}
 	}
} else {
	// Om undefined warnings te voorkomen:
	$strErrVoornaam = '';
	$strErrAchternaam = '';
	$strErrGeslacht = '';
	$strErrAdres = '';
	$strErrPostcode = '';
	$strErrPlaats = '';
	$strErrEmail = '';
	$strErrWachtwoord = '';
	$strErrTelefoon = '';
}
?>

<!DOCTYPE html>
<html>
<head>
	 <title>Scarlett Marijs - Account aanmaken</title>
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
	 <link rel="stylesheet" href="css/jquery-ui.css" />
	<script src="js/jquery-1.10.1.js"></script>
	<script src="js/jquery-ui-1.10.3/ui/jquery-ui.js"></script>
	<script src="js/jquery.ui.datepicker-nl.js"></script>
	<script>
	$(function() 
		{
        $('#txtGebDatum').datepicker({dateFormat: 'dd-mm-yy', changeMonth: true, changeYear: true, yearRange: "-100:+0" }, $.datepicker.regional['nl']);} // # omdat jquery met id werkt en niet met naam!!
        );
</script>
 </head>
 <body>
 <div class="container">
 <?php
require_once 'header.php';
?>
	 <div class="row">
	 	<section> 
	 	<div class="main col-xs-12 col-sm-12 col-md-9">
			<h2>Mijn gegegevens</h2>
            <p>Velden met een * zijn verplicht.</p>
            <p>&nbsp;</p>
            <form method="post" action="<?php echo($_SERVER["PHP_SELF"]); ?>"><table class="registreren">
              <tr>
                <td>Voornaam *</td>
                <td>:&nbsp;</td>
                <td><?php echo($strErrVoornaam); ?><input type="text" name="txtVoornaam" id="txtVoornaam" value="<?php echo($_POST["txtVoornaam"]) ?>"></td>
              </tr>
              <tr>
                <td>Tussenvoegsel</td>
                <td>:&nbsp;</td>
                <td><input type="text" name="txtTussenvoegsel" id="txtTussenvoegsel" value="<?php echo($_POST["txtTussenvoegsel"]) ?>"></td>
              </tr>
              <tr>
                <td>Achternaam *</td>
                <td>:&nbsp;</td>
                <td><?php echo($strErrAchternaam); ?><input type="text" name="txtAchternaam" id="txtAchternaam" value="<?php echo($_POST["txtAchternaam"]) ?>"></td>
              </tr>
              <tr>
                <td>Man/vrouw *</td>
                <td>&nbsp;</td>
                <td>
                	<label>
                        <?php echo($strErrGeslacht); ?><input class="radio" type="radio" name="blnGeslacht" value="M" <?php if($_POST['blnGeslacht'] == "M") {echo("checked=\"checked\"");} ?> id="Geslacht_0">
                        Man</label>
                        <label><input class="radio" type="radio" name="blnGeslacht" value="V" <?php if($_POST['blnGeslacht'] == "V") {echo("checked=\"checked\"");} ?>id="Geslacht_1">
                        Vrouw</label></td>
              </tr>
              <tr>
                <td>Adres *</td>
                <td>:&nbsp;</td>
                <td><?php echo($strErrAdres); ?><input type="text" name="txtAdres" id="txtAdres" value="<?php echo($_POST["txtAdres"]) ?>"></td>
              </tr>
              <tr>
                <td>Postcode *</td>
                <td>:&nbsp;</td>
                <td><?php echo($strErrPostcode); ?><input type="text" name="txtPostcode" id="txtPostcode" value="<?php echo($_POST["txtPostcode"]); ?>"></td>
              </tr>
              <tr>
                <td>Woonplaats *</td>
                <td>:&nbsp;</td>
                <td><?php echo($strErrPlaats); ?><input type="text" name="txtPlaats" id="txtPlaats" value="<?php echo($_POST["txtPlaats"]); ?>"></td>
              </tr>
              <tr>
                <td>E-mail *</td>
                <td>:&nbsp;</td>
                <td><?php echo($strErrEmail); ?><input type="text" name="txtEmail" id="txtEmail" value="<?php echo($_POST["txtEmail"]) ?>"></td>
              </tr>
              <tr>
                <td></td>
                <td></td>
                <td><span class="tip">Het wachtwoord moet minimaal 8 tekens lang zijn en minimaal &eacute;&eacute;n cijfer bevatten</span></td>
              </tr>
              <tr>
                <td>Wachtwoord *</td>
                <td>:&nbsp;</td>
                <td><?php echo($strErrWachtwoord); ?><input type="password" name="txtWachtwoord" id="txtWachtwoord" value="<?php echo($_POST["txtWachtwoord"]) ?>"></td>
              </tr>
              <tr>
                <td>Herhaal wachtwoord *</td>
                <td>:&nbsp;</td>
                <td><input type="password" name="txtWachtwoordRep" id="txtWachtwoordRep" value="<?php echo($_POST["txtWachtwoordRep"]) ?>"></td>
              </tr>
              <tr>
                <td>Telefoonnummer *</td>
                <td>:&nbsp;</td>
                <td><?php echo($strErrTelefoon); ?><input type="text" name="txtTelefoon" id="txtTelefoon" value="<?php echo($_POST["txtTelefoon"]) ?>"></td>
              </tr>
              <tr>
                <td>Geboortedatum</td>
                <td>:&nbsp;</td>
                <td><input type="text" name="txtGebDatum" id="txtGebDatum" readonly="true" value="<?php echo($_POST["txtGebDatum"]) ?>"></td>
              </tr>
<!--               <tr> -->
<!--                 <td>&nbsp;</td> -->
<!--                 <td>&nbsp;</td> -->
<!--                 <td><label> -->
<!-- 				<input type="checkbox" class="checkbox" name="txtNieuwsbrief" id="txtNieuwsbrief" <?php if($_POST['txtNieuwsbrief'] == "on") {echo("checked=\"checked\"");} ?>> -->
<!-- Ik ontvang graag de nieuwsbrief</label></td> -->
<!--               </tr> -->
              <tr>
                <td>&nbsp;</td>
                <td>&nbsp;</td>
                <td>&nbsp;</td>
              </tr>
              <tr>
                <td>&nbsp;</td>
                <td>&nbsp;</td>
                <td><input type="submit" name="btnAanmelden" value="Aanmelden" class="btn btn-default"></td>
              </tr>
            </table>
          </form>
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
		 <script src="js/bootstrap.min.js"></script>
	 <!-- end js scripts -->
 </body>
</html>
<?php mysqli_close($conn); ?>

