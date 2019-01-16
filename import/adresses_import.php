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
    $numero = str_replace("\"", "", $fields[3]);
    $suffix = str_replace("\"", "", $fields[4]);
    $voie = $fields[9];
    $longitude = $fields[13];
    $latitude = $fields[14];
    $arrondissement = preg_replace("/e.*/", "", str_replace("Paris ", "", $fields[15]));
    
    if (empty($numero))
        continue;

    $select = $pdo->prepare("SELECT COUNT(id) FROM voie WHERE nom=? AND arrondissement=?;");
    $select->execute([$voie, $arrondissement]);
    $voie_id = -1;
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
    if ($voie_id == -1)
    {
        print("\nError voie\n");
        return -1;
    }

    $insert = $pdo->prepare("INSERT INTO adresse (numero, suffix, longitude, latitude, voie) VALUES (?,?,?,?,?);");
    $insert->execute([$numero, $suffix, $longitude, $latitude, $voie_id]);

    $i++;
    print("\r$i / $line_count (". number_format($i*100/$line_count, 0) ." %)");

    //print($numero . " " . $suffix . " " . $voie . " " . $arrondissement . "\n");
}
print("\n");

fclose($file);
$pdo = null;

?>
