<?php

include_once("conversion.php");

/**
 * Compte le nombre place de parking existantes autour d'une position géographique.
 * @param pdo La connexion à la base de données.
 * @param latitude La latitude.
 * @param longitude La longitude.
 * @param rayon La distance maximale entre la place et la position géographique.
 * @return int Le nombre de place autour de la position.
 */
function places($pdo, $latitude, $longitude, $rayon){
	$regime_principal=array('PAYANT MIXTE','PAYANT ROTATIF','LOCATION','AUTRE REGIME','GRATUIT'); //Type de places prises en compte

	$coef=$rayon* 0.0000089; //Rayon de la recherche

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
		if (distance($latitude,$longitude,$donnees['latitude'],$donnees['longitude'])<=$rayon){
			//Ajout des places presentes dans le perimetre
			$nombre_places+=$donnees['places'];
			//print("\n".$donnees['id']." ".$donnees['places']);
		}
	}
	//print("\n".$nombre_places);
	//Nombre de place presente autour de l adresse demandee
	return $nombre_places;
}

/**
 * Calcul la distance entre deux position géographiques.
 * @param lat_a Latitude de la première coordonnée.
 * @param lon_a Longitude de la première coordonnée.
 * @param lat_b Latitude de la deuxième coordonnée.
 * @param lon_b Longitude de la deuxième coordonnée.
 * @return double La distance calculée.
 */
function distance($lat_a, $lon_a, $lat_b, $lon_b){
     
    $R = 6378000; //Rayon de la terre en mètre
 
    $lat_a = rad($lat_a);
    $lon_a = rad($lon_a);
    $lat_b = rad($lat_b);
    $lon_b = rad($lon_b);
     
    $d = $R * (pi()/2 - asin(sin($lat_b) * sin($lat_a) + cos($lon_b - $lon_a) * cos($lat_b) * cos($lat_a)));
    //print("\n".$d);
    return $d;
}

?>