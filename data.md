# Données utilisées dans ce projet

## Sources de données

Les données utilisées sont issues du site internet [Open Data Paris](https://opendata.paris.fr/) et [data.gouv.fr](https://www.data.gouv.fr/fr/) :

- [Stationnement sur voie publique - emplacements](https://opendata.paris.fr/explore/dataset/stationnement-voie-publique-emplacements/table/?disjunctive.regpri&disjunctive.regpar&disjunctive.typsta&disjunctive.arrond)
- [Adresses de Paris](https://adresse.data.gouv.fr/data/)
- [Données de population carroyées](https://www.insee.fr/fr/statistiques/2520034#consulter)

## Description des datasets

### Stationnement sur voie publique - emplacements

[https://opendata.paris.fr/explore/dataset/stationnement-voie-publique-emplacements/table/?disjunctive.regpri&disjunctive.regpar&disjunctive.typsta&disjunctive.arrond](https://opendata.paris.fr/explore/dataset/stationnement-voie-publique-emplacements/table/?disjunctive.regpri&disjunctive.regpar&disjunctive.typsta&disjunctive.arrond)

Ce fichier énumère les places de stationnement sur voie publique à Paris.

En gras les champs qui nous intéressent :

- **OBJECTID** : Identifiant du stationnement
- **Régime prioritaire** : Régime principal (2 roues, livraison, GIG-GIC, payant, location, autre régime)
- **Régime particulier** : Régime particulier, sous-catégorie du régime principal (emplacement motos, vélos, mixte, rotatif...)
- Type de stationnement
- **Longueur** : Longueur en mètre du stationnement
- Largeur
- **Arrondissement** : Arrondissement du stationnement
- **Nom de voie** : Nom de voie du stationnement
- ID_OLD
- **PLACAL** : Nombre de places calculées ?
- **PLAREL** : Nombre de places réelles ?
- DATERELEVE
- LOCSTA
- NUMVOIE
- COMPNUMVOIE
- TYPEVOIE
- LOCNUM
- TYPEMOB
- NUMMOB
- SIGNHOR
- SIGNVERT
- CONFSIGN
- NUMSSVP
- PARITE
- LONGUEUR_CALCULEE
- SURFACE_CALCULEE
- **ZONERES** : Secteur de stationnement résidentiel du stationnement
- TAR
- ZONEASP
- STV
- geo_shape
- **geo_point_2d** : Position géographique du stationnement

### Adresses de Paris

[https://adresse.data.gouv.fr/data/](https://adresse.data.gouv.fr/data/)

Ce fichier énumère les adresse de Paris.

En gras les champs qui nous intéressent :

- id
- nom_voie
- id_fantoir
- **numero** : Numéro de l'adresse
- **rep** : Suffix du numéro (par ex. BIS)
- code_insee
- code_post
- alias
- nom_ld
- **nom_afnor** : Nom de la rue (en capitales comme pour les emplacements)
- libelle_acheminement
- x
- y
- **lon** : Longitude
- **lat** : Latitude
- **nom_commune** : Arrondissement (à parser)

### Données de population carroyées

[https://www.insee.fr/fr/statistiques/2520034#consulter](https://www.insee.fr/fr/statistiques/2520034#consulter)

Ici l'INSEE fournit une carte carroyée à 200 mètres de données sur la population. Pour créer nos données, nous utilisons le nombre d'habitants dans un carré.