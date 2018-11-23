# Données utilisées dans ce projet

## Sources de données

Les données utilisées sont issues du site internet [Open Data Paris (https://opendata.paris.fr/)](https://opendata.paris.fr/) :

- [Stationnement sur voie publique - emplacements](https://opendata.paris.fr/explore/dataset/stationnement-voie-publique-emplacements/table/?disjunctive.regpri&disjunctive.regpar&disjunctive.typsta&disjunctive.arrond)
- [Stationnement sur voie publique - secteurs résidentiels](https://opendata.paris.fr/explore/dataset/stationnement-sur-voie-publique-secteurs-residentiels/export/)
- [Addresses](https://opendata.paris.fr/explore/dataset/adresse_paris/table/)
- [Nomenclature des voies publiques](https://opendata.paris.fr/explore/dataset/noms_voies_actuelles_paris/table/)
- [Volumes Bâtis](https://opendata.paris.fr/explore/dataset/volumesbatisparis2011/table/?location=17,48.86576,2.33848&basemap=jawg.streets)
- [Arrondissements](https://opendata.paris.fr/explore/dataset/arrondissements/table/?location=12,48.85889,2.34692&basemap=jawg.streets)

## Description des datasets

### Stationnement sur voie publique - emplacements

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