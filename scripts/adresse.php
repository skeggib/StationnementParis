<?php

/**
 * Récupère les coordonnées géographiques d'une adresse dans Paris.
 * @param pdo La connexion à la base de données.
 * @param numero Le numéro de l'adresse.
 * @param suffix Le suffix (par ex. BIS).
 * @param rue Le nombre de la rue.
 * @param arrondissement L'arrondissement.
 * @return array Un tableau où la valeur à l'index 0 correspond à la longitude et la valeur à l'index 1 à la latitude ou null si l'adresse n'existe pas.
 */
function coordonnees($pdo, $numero, $suffix, $rue, $arrondissement)
{
    $select = $pdo->prepare("SELECT longitude, latitude FROM adresse JOIN voie ON adresse.voie = voie.id WHERE adresse.numero = ? AND adresse.suffix = ? AND voie.nom = ? AND voie.arrondissement = ?;");
    $select->execute([$numero, $suffix, $rue, $arrondissement]);
    $result = $select->fetch();
    if (!$result)
        return null;
    return array($result['longitude'], $result['latitude']);
}