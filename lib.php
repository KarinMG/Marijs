<?php



// Artikelnummer berekenen

function artikelnummer($artikelID)
{
	$strArtikelnummer = $artikelID + 13000;
	return ($strArtikelnummer);
}
function ordernummer($factuurID)
{
	$strOrdernummer = date('Y') . "-" . ($factuurID + 123);
	return ($strOrdernummer);
}
// random wachtwoord genereren
function wachtwoord($aantaltekens)
{
    // wachtwoord mag bestaan uit grote letters, kleine letters, tekens en cijfers. 0 en O I en l doen niet mee
    $kleineletters = array("a", "b", "c", "d", "e", "f", "g", "h", "j", "k", "m", "n", "p", "q", "r", "s", "t", "u", "v", "w", "x", "y", "z");
    $groteletters = array("A", "B", "C", "D", "E", "F", "G", "H", "J", "K", "L", "M", "N", "P", "Q", "R", "S", "T", "U", "V", "W", "X", "Y", "Z");
    $tekens = array("$", "#", "&"); 
    $cijfers = range(2,9);
        
    //arrays achter elkaar plaatsen en tellen hoeveel er zijn
    $karakters     = array_merge($kleineletters, $groteletters, $tekens, $cijfers);
    $aantal     = count($karakters)-1;
    $random     = null;
          
    //Voor het aantal gekozen tekens selecteren er random.
    for($i=0; $i < $aantaltekens; $i++) {
        $random .= $karakters[mt_rand(0, $aantal)];
    }
    return $random;
}

// random salt genereren
function salt()
{
	// Salt mag bestaan uit grote letters, kleine letters, cijfers en de . en de /.
	$kleineletters = array("a", "b", "c", "d", "e", "f", "g", "h", "j", "k", "m", "n", "p", "q", "r", "s", "t", "u", "v", "w", "x", "y", "z");
	$groteletters = array("A", "B", "C", "D", "E", "F", "G", "H", "J", "K", "L", "M", "N", "P", "Q", "R", "S", "T", "U", "V", "W", "X", "Y", "Z");
	$tekens = array(".", "/");
	$cijfers = range(0,9);

	//arrays achter elkaar plaatsen en tellen hoeveel er zijn
	$karakters  = array_merge($kleineletters, $groteletters, $tekens, $cijfers);
	$aantal     = count($karakters)-1;
	$rnd_salt   = "$2a$12$";

	//Voor het aantal gekozen tekens selecteren er random.
	for($i=0; $i < 22; $i++) {
		$rnd_salt .= $karakters[mt_rand(0, $aantal)];
	}
	$rnd_salt .= "$";
	return $rnd_salt;
}

// Nederlandse datum tonen
  
function MysqlNlDate($strMysqlDatum)
{
	$intMysqlDatum = strtotime($strMysqlDatum);
  	$strDatumNl = date("d-m-Y", $intMysqlDatum);
  	return ($strDatumNl);
}

// Nederlandse datum tonen met maand uitgeschreven

function MysqlNlDateLang($strMysqlDatum)
{
	$strDag = substr($strMysqlDatum, 8, 2);
	$strMaand = MaandTekst(substr($strMysqlDatum, 5, 2));
	$strJaar = substr($strMysqlDatum, 0, 4);
	
	$strDatumLangNl = $strDag . " " . $strMaand . " " . $strJaar;
	return $strDatumLangNl;
}

function MaandTekst($intMaand)
{
	$arraymaand = array(
			"januari",
			"februari",
			"maart",
			"april",
			"mei",
			"juni",
			"juli",
			"augustus",
			"september",
			"oktober",
			"november",
			"december"
	);
	 
	$strMaand = $arraymaand [$intMaand -1];
	return ($strMaand);
}
 
function totaalExBTW ($totaalPrijs)
{
	$totExBTW = ($totaalPrijs / 121) * 100;
	return $totExBTW;
}

function BTW ($totaalPrijs)
{
	$BTW = ($totaalPrijs / 121) * 21;
	return $BTW;
}

?>
