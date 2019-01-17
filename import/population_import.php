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
    $fields = str_getcsv($line, ',');
    
    $id = $fields[0];
    $population = intval($fields[4]);
    $ne = str_replace("CRS3035RES200mN", "", $id);
    $ne_table = explode('E', $ne);
    $n = $ne_table[0];
    $e = $ne_table[1];

    $insert = $pdo->prepare("INSERT INTO population (n, e, population) VALUES (?,?,?);");
    $insert->execute([$n, $e, $population]);

    $i++;
    print("\r$i / $line_count (". number_format($i*100/$line_count, 0) ." %)");
}
print("\n");

fclose($file);
$pdo = null;

?>
