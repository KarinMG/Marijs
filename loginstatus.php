<?php 
require_once 'config.php';
?>

<div id="loginstatus">
<?php
if (isset($_SESSION["ingelogd"])) 
{
?>
	<span class="welkom">Welkom <?php echo($_SESSION["voornaam"]); ?></span>  |  <a href="logout.php" title="Uitloggen">Uitloggen</a>	
<?php
} 
else 
{
?>
	<span class="welkom">Je bent niet ingelogd</span>  |  <a href="inloggen.php" title="Inloggen">Inloggen</a>
<?php 
}
?>
</div>