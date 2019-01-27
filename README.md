# StationnementParis

*Création de données concernant le stationnement à Paris.*

Nous utilisons des données open data de la ville de Paris pour créer un indicateur mettant en relation le nombre de places de parking et la densité de population. Nous utilisons pour cela un jeu de données qui présente les emplacements de stationnement sur la voie publique, un jeu de données qui présente les adresses de la ville et des données carroyées à 200 mètres de la population de Paris.

Les données au format XML que nous avons généré peuvent être téléchargées à l'adresse suivante : [http://skeggib.com/stationnement_paris/indicateurs.xml](http://skeggib.com/stationnement_paris/indicateurs.xml) (38Mo). Ainsi que le fichier XSD : [http://skeggib.com/stationnement_paris/registor.xsd](http://skeggib.com/stationnement_paris/registor.xsd).

## Données utilisées

La description des données utilisées se trouve dans le fichier [data.md](data.md).

## Méthodologie

### Homogénéisation des données

Les sources de données étant issues de différents fournisseurs et utilisant plusieurs formats, nous avons décidé de les homogénéiser en les important dans une base de données relationnelle. Ce choix a aussi été motivé par une volonté de réduire le temps de calcul, en particulier lors des jointures que nous réalisons.

<!-- TODO expliquer comment générer le CSV à partir de la carte carroyée ? -->

Le dossier [database](database) contient les fichiers relatifs à la base de données :
- [erd.vpp](database/erd.vpp) le schéma relationnel au format Visual Paradigm et [erd.png](database/erd.png) l'image exportée du schéma.
- [create_database.sql](database/create_database.sql) le script de création de la base de données.

Le dossier [import](import) contient les scripts d'importation des données :
- [emplacement_import.php](import/emplacement_import.php) le script d'importation des places de stationnement, son utilisation est la suivante : `php emplacement_import.php <fichier_csv> <login_bd> <mdp_bd>`
- [adresses_import.php](import/adresses_import.php) le script d'importation des adresses, son utilisation est la suivante : `php adresses_import.php <fichier_csv> <login_bd> <mdp_bd>`
- [population_import.php](import/population_import.php) le script d'importation des données de population (générées à partir de la carte carroyée), son utilisation est la suivante : `php population_import.php <fichier_csv> <login_bd> <mdp_bd>`

### Données calculées

Les données que nous créons sont, pour chaque adresse, des indicateurs mettant en relation le nombre de places existantes dans un rayon de n mètres autour de cette adresse et la population estimée dans le cercle de rayon n. Le fichier XML que nous avons généré contient les indicateurs pour des rayons de 100, 200 et 500 mètres. L'indicateur est calculé en divisant le nombre de places dans le cercle par la population du cercle.

## Format des données

### Description du fichier XML

Le fichier XML est structuré de la manière suivante :
- La balise `<record></record>` est la racine du ficher, c'est elle qui contient les adresses.
- Les adresses `<address></address>` contiennent les indicateurs et possèdent les attributs suivants:
    - `number` : Le numéro de l'adresse.
    - `suffix` : Le suffixe du numéro (bis, ter, ...).
    - `street` : Le nom de la rue.
    - `district` : Le numéro d'arrondissement.
    - `longitude` : La longitude de la position géographique de l'adresse
    - `latitude` : La latitude de la position géographique de l'adresse
- Trois indicateurs `<indicator></indicator>`. Ils correspondent au ratio nombre de place / population dans le rayon `radius` indiqué en attribut. Les trois rayons ont pour valeur 100, 200 et 500 mètres.

Une entrée dans le fichier XML pourrait par exemple être :

```xml
<address number="17"
         suffix=""
         street="RUE DE L ARBRE SEC"
         district="1"
         longitude="2.3420196846832"
         latitude="48.8597510056521">
    <indicator radius="100">0.84</indicator>
    <indicator radius="200">0.56</indicator>
    <indicator radius="500">0.78</indicator>
</address>
```

### Validation

Les données XML dont vérifiées grâce à un fichier XSD. La vérification est effectuée à la fin de la création du fichier XML. 
Le fichier XSD est à transmettre avec le XML afin que les personnes souhaitant utiliser nos données puissent le vérifier à leur tour avant utilisation.

## Précautions d'utilisation

Les données utilisées n'étant pas parfaitement adaptées à notre application, mais aussi par soucis de temps, nous avons fait certaines approximations pour le calcul de nos indicateurs.

### Position des places de stationnement

Les données des places de stationnement ne recensent pas les places individuellement mais par groupes de places consécutives. Cela veut dire que si une rue comporte 10 places adjacentes elles seront représentées par une seule entrée d'une capacité de 10 voitures avec une seule position géographique (généralement le centre du groupe de places).

Cela a un impact sur nos données parce qu'une adresse se trouvant proche du centre du groupe de places (de leur position géographique) comptabilisera beaucoup plus de places qu'une adresse dans la même rue mais plus loin du centre du groupe, même si ces places d'étendent jusqu'à cette deuxième adresse.

Nos données contiennent ainsi des valeurs aberrantes dans le cas où beaucoup de places consécutives constituent un groupes (plus de 50 places). Ce genre de cas se présente assez rarement (112 entrées sur 59579) et généralement en périphérie de Paris. Nous avons donc décidé d'ignorer ce problème car la plupart des groupes de places peuvent accueillir 10 voitures ou moins (90%).

### Distance entre l'adresse et les places

Pour calculer le nombre de place en dessous d'une certaine distance n d'une adresse nous prenons en compte les places dans le cercle de rayon n. Cela peut être faussé par le géométrie de certaines rues. Par exemple, une personne pourrait devoir contourner un bâtiment pour accéder à une place, rendant le trajet plus long que prévu. Une amélioration possible de cet aspect pourrait être le calcul de la distance réelle entre une adresse et une place (par exemple avec du pathfinding).

## Formulaire web

Nous avons créé une page web exploitant les données du fichier XML. Cette page web propose un formulaire permettant d'entrer l'adresse à rechercher et le rayon souhaité. Les données entrées dans le formulaire permettent d'obtenir l'indicateur pour le rayon souhaité ainsi qu'une carte indiquant la position géographique de l'adresse et un dessin du cercle permettant de visualiser la zone concernée par l'indicateur. 