DROP TABLE adresse;

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
