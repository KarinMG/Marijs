<header>
  <div class="row">
  <div class="draakje hidden-xs col-sm-push-9 col-md-push-8 col-lg-push-8 col-xs-12 col-sm-3 col-md-4"><img class="img-responsive" src="images/header_draakjes.png" alt="Draakje" /></div>
	  <div class="payoff col-sm-pull-3 col-md-pull-4 col-lg-pull-4 col-xs-12 col-sm-9 col-md-8">
	  	<a href="index.php" title="Scarlett Marijs - homepage"><img class="img-responsive" src="images/logo2.png" alt="Scarlett Marijs" /></a>
	  	<img class="img-responsive" src="images/payoff.png" alt="Kinderkamerdeco - Handmade with love!" />
	  </div>
  </div>
  

   </header>
	<div class="row">
	<div class="navbar-header"> 
		<button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#mainmenu"></button>
	</div>
	<div class="collapse navbar-collapse" id="mainmenu">
		<nav class="navbar navbar-default" role="navigation">
	       <ul class="nav navbar-nav">
	         <li class="dropdown"><a class="dropdown-toggle" data-toggle="dropdown" href="index.php">Winkelen  <span class="caret"></span></a>
	         	<ul class = "dropdown-menu">
		         	<h2><a href="index.php" title="Categorieoverzicht">Categori&euml;n</a></h2>
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
					
				    ?>
				    <li class="divider"></li>
				    <li><a href="alles.php" title="Alles">Alles</a></li>
				    <li class="divider"></li>
				    <li><a href="archief.php" title="Eerder werk">Eerder werk</a></li>
	         	</ul>
	         </li>
	         <li><a href="maatwerk.php">Op maat of op naam</a></li>
	         <li class="dropdown"><a href="overons.php" class="dropdown-toggle" data-toggle="dropdown" >Over Scarlett Marijs  <span class="caret"></span></a>
	         	<ul class = "dropdown-menu">
	         		<li><a href="about.php">Over de maker</a></li>
	         		<li><a href="informatie.php">Betaling en verzending</a></li>
	         	</ul>
	         </li>
	       </ul>
	       <form class="navbar-form navbar-right" role="search" action="zoekresultaat.php" method="get">
	       		<div class="form-group"> <input type="text" class="zoeken form-control" placeholder="Vul een zoekterm in..." name="txtZoek" id="txtZoek"></div>
	       		<button type="submit" class="btn btn-default" name="btnZoeken" id="btnZoeken">Zoeken</button>
	       	</form>
	       <div class="navbar-right">
	       	<div class="navbar-btn socmed">
	       	<a href="https://www.facebook.com/pages/Scarlett-Marijs-Kinderkamer-Deco/350648788445268" title="Volg ons op Facebook" target="_blank"><img src="images/fb_icon.png" alt="Volg ons op Facebook" /></a>
	       	<a href="http://www.pinterest.com/scarlettmarijs/" title="Volg ons op Pinterest" target="_blank"><img src="images/pinterest_icon.png" alt="Volg ons op Pinterest" /></a></div>
	       </div>
	    </nav>
	 </div>    
     </div>
