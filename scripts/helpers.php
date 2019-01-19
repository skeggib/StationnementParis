<?php

/**
 * Créé le PDO connecté à la base de données.
 * @return PDO Le PDO créé.
 */
function createPDO()
{
    return new PDO("pgsql:host=skeggib.com;dbname=StationnementParis", "stationnementparispublic", "public");
}

?>