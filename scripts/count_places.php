<?php

if (!isset($argv) || count($argv) < 3)
{
    print("Usage: php " . $argv[0] . "  <login> <password>\n");
    return;
}
$login = $argv[1];
$password = $argv[2];

$pdo = new PDO("pgsql:host=skeggib.com;dbname=StationnementParis", "stationnementparispublic", "public");
selection_places(48.8659650324,2.34922409941,200,$pdo);
$pdo = null;


//Recherche des places autour de l'adresse
function selection_places($latitude,$longitude,$rayon_recherche,$pdo){
	$regime_principal=array('PAYANT MIXTE','PAYANT ROTATIF','LOCATION','AUTRE REGIME','GRATUIT'); //Type de places prises en compte

	$coef=$rayon_recherche* 0.0000089; //Rayon de la recherche

	//Modification de la longitude et latitude a l aide du coefficient de recherche
	$lat_min=$latitude-$coef;
	$lat_max=$latitude+$coef;
	$long_min=$longitude-($coef/cos($latitude * 0.018));
	$long_max=$longitude+($coef/cos($latitude * 0.018));

	//Requete de recuperation des places
	$select = $pdo->prepare("SELECT id,places,latitude,longitude FROM emplacement WHERE (latitude BETWEEN ? AND ?) AND (longitude BETWEEN ? AND ?) AND (regime_principal=? OR regime_principal=? OR regime_principal=? OR regime_principal=? OR regime_principal=? );");
	$select->execute([$lat_min,$lat_max,$long_min,$long_max,$regime_principal[0],$regime_principal[1],$regime_principal[2],$regime_principal[3],$regime_principal[4]]);


	$nombre_places=0;
	//Parcours des donnees recuperees
	while ($donnees = $select->fetch())
	{
		//Verification que la donnee se trouve dans le perimetre demande
		if (distance($latitude,$longitude,$donnees['latitude'],$donnees['longitude'])<=$rayon_recherche){
			//Ajout des places presentes dans le perimetre
			$nombre_places+=$donnees['places'];
			//print("\n".$donnees['id']." ".$donnees['places']);
		}
	}
	//print("\n".$nombre_places);
	//Nombre de place presente autour de l adresse demandee
	return $nombre_places;
}

//Calcul de la distance entre deux points
function distance($lat_a_degre,$lon_a_degre,$lat_b_degre,$lon_b_degre){
     
    $R = 6378000; //Rayon de la terre en mètre
 
    $lat_a = convertRad($lat_a_degre);
    $lon_a = convertRad($lon_a_degre);
    $lat_b = convertRad($lat_b_degre);
    $lon_b = convertRad($lon_b_degre);
     
    $d = $R * (pi()/2 - asin(sin($lat_b) * sin($lat_a) + cos($lon_b - $lon_a) * cos($lat_b) * cos($lat_a)));
    //print("\n".$d);
    return $d;
}

//Conversion en radian
function convertRad($input){
        return (pi() * $input)/180;
}

?>