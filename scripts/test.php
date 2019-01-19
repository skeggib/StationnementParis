<?php

include_once("adresse.php");
include_once("population.php");
include_once("places.php");

if (!isset($argv) || count($argv) < 5)
{
    print("Usage: php " . $argv[0] . " <numero> [suffix] <rue> <arrondissement> <rayon>\n");
    return;
}

$numero = $argv[1];
$suffix = count($argv) >= 6 ? $argv[2] : "";
$rue = $argv[count($argv) - 3];
$arrondissement = $argv[count($argv) - 2];
$rayon = $argv[count($argv) - 1];

$pdo = new PDO("pgsql:host=skeggib.com;dbname=StationnementParis", "stationnementparispublic", "public");
$coordonnes = coordonnees($pdo, $numero, $suffix, $rue, $arrondissement);
if (is_null($coordonnes))
{
    print("Adresse non trouvée.\n");
    return -1;
}
$population = population_cercle($pdo, $coordonnes[0], $coordonnes[1], $rayon);
$places = places($pdo, $coordonnes[0], $coordonnes[1], $rayon);

print($places . " places pour " . $population . " habitants dans un rayon de " . $rayon . " mètres.\n");
return 0;

?>