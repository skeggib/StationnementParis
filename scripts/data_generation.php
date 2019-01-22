<?php

require_once("adresse.php");
require_once("population.php");
require_once("places.php");
require_once("helpers.php");
require_once("xml.php");

// Arguments CLI
if (!isset($argv) || count($argv) < 3)
{
    print("Usage: php " . $argv[0] . " <xml_path> <xsd_path>\n");
    return;
}
$xml_path = $argv[1];
$xsd_path = $argv[2];

// Connexion PDO
$pdo = createPDO();

// Création DOM
$doc = createxml();

// Requête adresses
$result = $pdo->query("SELECT COUNT(adresse.id) FROM adresse JOIN voie ON adresse.voie = voie.id");
$count = $result->fetch()['count'];
$result = $pdo->query("SELECT adresse.numero AS numero, adresse.suffix AS suffix, adresse.longitude AS longitude, adresse.latitude AS latitude, voie.nom AS voie, voie.arrondissement AS arrondissement FROM adresse JOIN voie ON adresse.voie = voie.id");
if (!$result)
{
    print("Query error.\n");
    return;
}

pcntl_signal(SIGTERM, "sig_handler");
pcntl_signal(SIGINT, "sig_handler");
pcntl_signal(SIGHUP, "sig_handler");

// Boucle principale
$i = 0;
$start = microtime(true);
while ($adresse = $result->fetch())
{
    // Données de la requête
    $numero = $adresse['numero'];
    $suffix = $adresse['suffix'];
    $voie = $adresse['voie'];
    $arrondissement = $adresse['arrondissement'];
    $lon = $adresse['longitude'];
    $lat = $adresse['latitude'];

    try
    {
        // Calcul des nouvelles données
        $indicateur100 = indicateur($pdo, $lon, $lat, 100);
        $indicateur200 = -1;//indicateur($pdo, $lon, $lat, 200);
        $indicateur500 = -1;//indicateur($pdo, $lon, $lat, 500);

        pcntl_signal_dispatch();
        $doc = addAddresse($doc, $numero, $suffix, $voie, $arrondissement, $lon, $lat, $indicateur100, $indicateur200, $indicateur500);

    } catch(Exception $e) {}
        
    $time = microtime(true);
    $elapsed_seconds = $time - $start;
    $remaining_seconds = (($count - $i) / $i) * $elapsed_seconds;

    print($i . " / " . $count . " " . secondsToTimestampString($remaining_seconds) . " remaining" . "\n");
    $i++;
}
print(secondsToTimestampString($elapsed_seconds) . " elapsed.\n").
$pdo = null;

save();

function sig_handler($signo)
{
    save();
    exit;
}

function save()
{
    global $doc, $xml_path, $xsd_path;
    saveXMLDocument($doc, $xml_path);
    if (!validate($doc, $xsd_path))
        print("Document invalide.\n");
    else
        print("Document valide.\n");
}


?>
