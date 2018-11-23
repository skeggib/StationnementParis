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
    places INTEGER NOT NULL,
    point_geographique VARCHAR,

    regime_principal VARCHAR NOT NULL,
    regime_particulier VARCHAR NOT NULL,
    voie INTEGER NOT NULL,
    secteur INTEGER NOT NULL,

    PRIMARY KEY(id),
    FOREIGN KEY(regime_principal) REFERENCES regime_principal(nom),
    FOREIGN KEY(regime_particulier) REFERENCES regime_particulier(nom),
    FOREIGN KEY(voie) REFERENCES voie(id),
    FOREIGN KEY(secteur) REFERENCES secteur(id)
);
