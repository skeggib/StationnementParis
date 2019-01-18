# StationnementParis

*Création de données concernant le stationnement à Paris.*

Nous utilisons des données open data de la ville de Paris pour créer un indicateur mettant en 
relation le nombre de places de parking et la densité de population. Nous utilisons pour cela un jeu
de données qui présente les emplacement de stationnement sur la voie publique, un jeu de données qui
présente les adresse de la ville et des données carroyées à 200 mètres de la population de Paris.

## Données utilisées

La description des données utilisées se trouve dans le fichier [data.md](data.md).

## Méthodologie

### Homogénéisation des données

Les sources de données étant issues de différents fournisseurs et utilisant plusieurs formats, nous
avons décidé de les homogénéiser en les important dans une base de données relationnelle. Ce choix
a aussi été motivé par une volonté de réduire le temps de calcul, en particulier lors des jointures
que nous réalisons.

<!-- TODO expliquer comment générer le CSV à partir de la carte carroyée. -->

Le dossier [database](database) contient les fichiers relatifs à la base de données :
- [erd.vpp](database/erd.vpp) le schéma relationnel au format Visual Paradigm et
  [erd.png](database/erd.png) l'image exportée du schéma.
- [create_database.sql](database/create_database.sql) le script de création de la base de données.

Le dossier [import](import) contient les scripts d'importation des données :
- [emplacement_import.php](import/emplacement_import.php) le script d'importation des places de 
  stationnement, son utilisation est la suivante :
  `php emplacement_import.php <fichier_csv> <login_bd> <mdp_bd>`
- [adresses_import.php](import/adresses_import.php) le script d'importation des adresses, son 
  utilisation est la suivante : 
  `php adresses_import.php <fichier_csv> <login_bd> <mdp_bd>`
- [population_import.php](import/population_import.php) le script d'importation des données de 
  population (générées à partir de la carte carroyée), son utilisation est la suivante : 
  `php population_import.php <fichier_csv> <login_bd> <mdp_bd>`

### Données calculées

<!-- TODO Combien de m pour le rayon ? -->

La donnée que nous créons est, pour chaque adresse, un indicateur mettant en relation le nombre de 
places existantes dans un rayon de $n$ mètres autour de cette adresse et la la population estimée
dans le cercle de rayon $n$.

<!-- TODO Equations. -->