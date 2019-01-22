<?php

/**
 * Créé le PDO connecté à la base de données.
 * @return PDO Le PDO créé.
 */
function createPDO()
{
    return new PDO("pgsql:host=skeggib.com;dbname=StationnementParis", "stationnementparispublic", "public");
}

function secondsToTimestampString($seconds)
{
    $sec = $seconds % 60;
    $seconds /= 60;
    
    $min = $seconds % 60;
    $seconds /= 60;
    
    $hours = $seconds % 24;
    $seconds /= 24;

    $days = floor($seconds);

    return "" . $days . "d " . $hours . "h " . $min . "m " . $sec . "s";
}

?>
