<?php

if (!isset($argv) || count($argv) < 4)
{
    print("Usage: php " . $argv[0] . " <csv_file> <login> <password>\n");
    return;
}

$csv_path = $argv[1];
$login = $argv[2];
$password = $argv[3];

$pdo = new PDO("pgsql:host=localhost;dbname=StationnementParis", $login, $password);

$file = fopen($csv_path, "r");
if (!$file)
{
    print("Cannot open $csv_path\n");
    return;
}

$line_count = 0;
while (fgets($file) !== false)
    $line_count++;
    fclose($file);

$file = fopen($csv_path, "r");
$i = 1;
fgets($file);
while (($line = fgets($file)) !== false)
{
    $fields = str_getcsv($line, ';');
    
    $id = $fields[0];
    $regime_principal = $fields[1];
    $regime_particulier = $fields[2];
    $longueur = $fields[4];
    $arrondissement = $fields[6];
    $voie = $fields[16] . " " . $fields[7];
    $places = $fields[11];
    $secteur = $fields[42];
    $point_geographique = explode(',', $fields[48]);
    $latitude = str_replace(" ", "", $point_geographique[0]);
    $longitude = str_replace(" ", "", $point_geographique[1]);

    $select = $pdo->prepare("SELECT COUNT(nom) FROM regime_principal WHERE nom=?;");
    $select->execute([$regime_principal]);
    if ($select->fetch()['count'] <= 0)
    {
        $insert = $pdo->prepare("INSERT INTO regime_principal (nom) VALUES (?);");
        $insert->execute([$regime_principal]);
    }

    $select = $pdo->prepare("SELECT COUNT(nom) FROM regime_particulier WHERE nom=?;");
    $select->execute([$regime_particulier]);
    if ($select->fetch()['count'] <= 0)
    {
        $insert = $pdo->prepare("INSERT INTO regime_particulier (nom) VALUES (?);");
        $insert->execute([$regime_particulier]);
    }

    $select = $pdo->prepare("SELECT COUNT(id) FROM voie WHERE nom=? AND arrondissement=?;");
    $select->execute([$voie, $arrondissement]);
    if ($select->fetch()['count'] <= 0)
    {
        $insert = $pdo->prepare("INSERT INTO voie (nom, arrondissement) VALUES (?, ?);");
        $insert->execute([$voie, $arrondissement]);
        $voie_id = $pdo->lastInsertId();
    }
    else
    {
        $select = $pdo->prepare("SELECT id FROM voie WHERE nom=? AND arrondissement=?;");
        $select->execute([$voie, $arrondissement]);
        $voie_id = $select->fetch()['id'];
    }

    $insert = $pdo->prepare("INSERT INTO emplacement (id_csv, regime_principal, regime_particulier, longueur, voie, places, latitude, longitude) VALUES (?, ?,?,?,?,?,?,?);");
    $insert->execute([$id, $regime_principal, $regime_particulier, $longueur, $voie_id, $places, $latitude, $longitude]);

    $i++;
    print("\r$i / $line_count (". number_format($i*100/$line_count, 0) ." %)");
}
print("\n");

fclose($file);
$pdo = null;

?>
