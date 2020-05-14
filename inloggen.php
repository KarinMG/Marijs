<?php
require_once 'config.php';
require_once 'lib/lib.php';



// Create connection

$conn = mysqli_connect($strServerName, $strUsername, $strPassword, $strDbName);
	// Check connection
	if (!$conn) {
		die("Connection failed: " . mysqli_connect_error());
	}

if (isset($_POST["btnLogin"])) //button clicked
{
	
	// check login data
	$sql =  "SELECT klantID, wachtwoord, voornaam " .
			"FROM tblKlant " .
			"WHERE email = '" . mysqli_real_escape_string($conn, $_POST["txtEmail"]) . "'";
	$resultaat = mysqli_query($conn, $sql);
	if(mysqli_num_rows($resultaat) > 0)
	{
		// emailaddress found. check password.
		$rs = mysqli_fetch_assoc($resultaat);
		if($rs["wachtwoord"] == crypt($_POST["txtPassword"], $rs['wachtwoord'])) // password correct
		{
			setcookie("loginnaam", $_POST["txtEmail"], time() + (60*60*24*365));
			$_SESSION["ingelogd"] = true;
			$_SESSION["klantID"] = $rs["klantID"];
			$_SESSION["voornaam"] = $rs["voornaam"];
			// password correct: redirect to account page
			mysqli_free_result($resultaat);
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
				header("Location: index.php");
			}
		}
		else
		{
			// password incorrect
			$strErrInlog = "<span class=\"warning\">De combinatie van gebruikersnaam en wachtwoord is niet juist.</span><br /><br />";
		}
	}
	else {
		// user not found
		$strErrInlog = "<span class=\"warning\">De combinatie van gebruikersnaam en wachtwoord is niet juist.</span><br /><br />";
	}
}
else {
	$strErrInlog = "";
}
?>

<!DOCTYPE html>
<html>
<head>
	 <title>Scarlett Marijs - inloggen</title>
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
	 		<h2>Inloggen</h2>
	 		<p>Om uw account te bekijken of een bestelling te doen, moet u ingelogd zijn.<br />Log hieronder in met uw gebruikersnaam en wachtwoord of maak een account aan.</p>
			<div class="blokinlog">
				<form method="post" action="<?php echo $_SERVER["PHP_SELF"]; ?>">
					<p><?php 
				   	echo($strErrInlog); 
				   	?></p> 
			        Uw emailadres:<br />
			        <input type="text" name="txtEmail" id="txtEmail" ><br />
					<!-- value="<?php echo($_COOKIE["loginnaam"])?>" temporarily removed -->
			        Uw wachtwoord:<br />
			        <input type="password" name="txtPassword" id="txtPassword"><br />
			        <input type="submit" name="btnLogin" value="Inloggen" class="btn btn-default">
				</form>
			    <p><a href="loginretr.php">Ik ben mijn inloggegevens kwijt</a></p>
			    <p><a href="registreren.php">Ik wil een account aanmaken</a></p>
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

