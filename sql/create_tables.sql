-- Lisää CREATE TABLE lauseet tähän tiedostoon
CREATE TABLE Kayttaja(
kayttaja_id SERIAL PRIMARY KEY,
kayttaja_nimi varchar(20) NOT NULL,
salasana varchar(50) NOT NULL);

CREATE TABLE Askare(
askare_id SERIAL PRIMARY KEY,
askare_nimi varchar(20) NOT NULL,
deadline DATE,
kuvaus varchar(100),
prioriteetti integer,
kayttaja_id integer REFERENCES Kayttaja);

CREATE TABLE Luokka(
luokka_id SERIAL PRIMARY KEY,
luokka_nimi varchar(20),
kayttaja_id integer REFERENCES Kayttaja);

CREATE TABLE Askareen_luokka(
luokka_id INTEGER REFERENCES Luokka,
askare_id INTEGER REFERENCES Askare);
