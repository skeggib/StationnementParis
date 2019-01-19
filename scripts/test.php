<?php

include_once("adresse.php");

$pdo = new PDO("pgsql:host=skeggib.com;dbname=StationnementParis", "stationnementparispublic", "public");
$numero = 4;
$suffix = "";
$rue = "RUE FEROU";
$arrondissement = 6;

$coord = coordonnees($pdo, $numero, $suffix, $rue, $arrondissement);

print($coord[1] . " " . $coord[0] . "\n");