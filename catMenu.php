<div class="catmenu">
  <h3>In de winkel</h3>
    <ul>
    
    <?php 
    $sql = "SELECT categorieID, naam FROM tblCategorie";
	$resultaat = mysqli_query($conn, $sql);
	
	while ($rij = mysqli_fetch_assoc($resultaat))
	{
    ?>
      <li><a href="categorie.php?categorieID=<?php echo($rij["categorieID"]); ?>" title="<?php echo($rij["naam"]); ?>"><?php echo($rij["naam"]); ?></a></li>
    <?php 
	}
	mysqli_free_result($resultaat);
	
	// geen database openen en sluiten want dat gebeurt altijd al in de hoofdpagina
	// geeft een warning als je dat wel doet
	
    ?>  
    </ul>
</div>

