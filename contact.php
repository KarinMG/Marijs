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
   	                <h2>Contact</h2>
                    <p>Contactgegevens en meer over de kunstenares</p>
                </div>
            </section>
            <aside class="col-xs-12 col-sm-12 col-md-3">
            	<?php 
            	require_once 'loginstatus.php';
            	require_once 'zoekform.php';
            	require_once 'catMenu.php';
            	?>
            </aside>
        </div>
        <?php require_once 'footer.php';?>
   	</div>
</body>
</html>
<?php 
	mysqli_close($conn);
?>
