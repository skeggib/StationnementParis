DROP TABLE emplacement;
DROP TABLE secteur;
DROP TABLE voie;
DROP TABLE IF EXISTS regime_particulier;
DROP TABLE IF EXISTS regime_principal;

CREATE TABLE regime_principal (
    nom VARCHAR,

    PRIMARY KEY(nom)
);

CREATE TABLE regime_particulier (
    nom VARCHAR,

    PRIMARY KEY(nom)
);

CREATE TABLE voie (
    id INTEGER,
    nom VARCHAR,
    arrondissement INTEGER,

    PRIMARY KEY(id)
);

CREATE TABLE secteur (
    id INTEGER,
    arrondissement INTEGER,
    lettre VARCHAR,

    PRIMARY KEY(id)
);

CREATE TABLE emplacement (
    id INTEGER,
    id_csv VARCHAR UNIQUE,
    longueur REAL,
    places INTEGER,
    point_geographique VARCHAR,

    regime_principal VARCHAR,
    regime_particulier VARCHAR,
    voie INTEGER,
    secteur INTEGER,

    PRIMARY KEY(id),
    FOREIGN KEY regime_principal REFERENCES regime_principal(nom),
    FOREIGN KEY regime_particulier REFERENCES regime_particulier(nom),
    FOREIGN KEY void REFERENCES void(id),
    FOREIGN KEY secteur REFERENCES secteur(id)
);