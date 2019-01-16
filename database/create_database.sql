DROP TABLE adresse;
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
    id SERIAL,
    nom VARCHAR,
    arrondissement INTEGER,

    PRIMARY KEY(id)
);

CREATE TABLE secteur (
    id SERIAL,
    arrondissement INTEGER,
    lettre VARCHAR,

    PRIMARY KEY(id)
);

CREATE TABLE emplacement (
    id SERIAL,
    id_csv VARCHAR UNIQUE,
    longueur REAL,
    places INTEGER NOT NULL,
    longitude DECIMAL NOT NULL,
    latitude DECIMAL NOT NULL,

    regime_principal VARCHAR NOT NULL,
    regime_particulier VARCHAR NOT NULL,
    voie INTEGER NOT NULL,
    secteur INTEGER,

    PRIMARY KEY(id),
    FOREIGN KEY(regime_principal) REFERENCES regime_principal(nom),
    FOREIGN KEY(regime_particulier) REFERENCES regime_particulier(nom),
    FOREIGN KEY(voie) REFERENCES voie(id),
    FOREIGN KEY(secteur) REFERENCES secteur(id)
);

CREATE TABLE adresse (
    id SERIAL,
    numero INTEGER NOT NULL,
    suffix VARCHAR,
    voie INTEGER NOT NULL,
    longitude DECIMAL NOT NULL,
    latitude DECIMAL NOT NULL,

    PRIMARY KEY(id),
    
    FOREIGN KEY(voie) REFERENCES voie(id)
);
