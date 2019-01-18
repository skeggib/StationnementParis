<?php

include_once("conversion.php");

/**
 * Récupère la population du carré de 200m de côté dans lequel se trouve la coordonnée.
 * @param pdo La connection à la base de données.
 * @param lon La longitude.
 * @param lat La latitude.
 * @return int La population du carré.
 */
function getPopulation($pdo, $lon, $lat)
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

?>