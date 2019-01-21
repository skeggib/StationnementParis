<?php

require_once("adresse.php");
require_once("population.php");
require_once("places.php");
require_once("helpers.php");

// Arguments CLI
if (!isset($argv) || count($argv) < 2)
{
    print("Usage: php " . $argv[0] . " <path>\n");
    return;
}

// Connexion PDO
$pdo = new PDO("pgsql:host=localhost;dbname=StationnementParis", "stationnementparispublic", "public");

// Requête adresses
$result = $pdo->query("SELECT COUNT(adresse.id) FROM adresse JOIN voie ON adresse.voie = voie.id");
$count = $result->fetch()['count'];
$result = $pdo->query("SELECT adresse.numero AS numero, adresse.suffix AS suffix, adresse.longitude AS longitude, adresse.latitude AS latitude, voie.nom AS voie, voie.arrondissement AS arrondissement FROM adresse JOIN voie ON adresse.voie = voie.id");
if (!$result)
{
    print("Query error.\n");
    return;
}

// Boucle principale
$i = 0;
while ($adresse = $result->fetch())
{
    // Données de la requête
    $numero = $adresse['numero'];
    $suffix = $adresse['suffix'];
    $voie = $adresse['voie'];
    $arrondissement = $adresse['arrondissement'];
    $lon = $adresse['longitude'];
    $lat = $adresse['latitude'];

    // Calcul des nouvelles données
    $population = populationCercle($pdo, $lon, $lat, 200);
    $places = places($pdo, $lon, $lat, 200);
    $indicateur = $population / $places;

    // TODO Ecriture XML

    print($i . " / " . $count . "\n");
    $i++;
}
$pdo = null;

?>
