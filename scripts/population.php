<?php

require_once("conversion.php");

/**
 * Récupère la population du carré de 200m de côté dans lequel se trouve la coordonnée.
 * @param pdo La connexion à la base de données.
 * @param lon La longitude.
 * @param lat La latitude.
 * @return int La population du carré.
 */
function populationCarre($pdo, $lon, $lat)
{
    $pos = WGS84_to_ETRS89($lon, $lat);

    $e = round($pos[0]);
    $e -= $e % 200;
    $n = round($pos[1]);
    $n -= $n % 200;
    
    $select = $pdo->prepare("SELECT population FROM population WHERE e = ? AND n = ?;");
    $select->execute([$e, $n]);
    return $select->fetch()['population'];
}

/**
 * Calcule la densité de population à une position géographique.
 * @param pdo La connexion à la base de données.
 * @param lon La longitude.
 * @param lat La latitude.
 * @return double La densité de population en hab/km2.
*/
function densite($pdo, $lon, $lat)
{
    return populationCarre($pdo, $lon, $lat) / (0.2 * 0.2);
}

/**
 * Calcule une estimation de la population dans un cercle.
 * @param pdo La connexion à la base de données.
 * @param lon La longitude du centre du cercle.
 * @param lat La latitude du centre du cercle.
 * @param rayon Le rayon du cercle en mètres.
 * @return double Une estimation de la population dans le cercle.
*/
function populationCercle($pdo, $lon, $lat, $rayon)
{
    $rayon_km = $rayon / 1000;
    return densite($pdo, $lon, $lat) * $rayon_km * $rayon_km;
}

?>