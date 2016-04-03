-- Lisää CREATE TABLE lauseet tähän tiedostoon
CREATE TABLE Kayttaja(
kayttaja_id SERIAL PRIMARY KEY,
kayttaja_nimi varchar(20) NOT NULL,
salasana varchar(50) NOT NULL);

CREATE TABLE Askare(
askare_id SERIAL PRIMARY KEY,
askare_nimi varchar(20) NOT NULL,
deadline DATE,
kuvaus varchar(100));

CREATE TABLE Kayttajan_askare(
kayttaja_id INTEGER REFERENCES Kayttaja(kayttaja_id),
askare_id INTEGER REFERENCES Askare(askare_id));

CREATE TABLE Tarkeysluokka(
prioriteetti INTEGER NOT NULL,
askare_id INTEGER REFERENCES Askare);

CREATE TABLE Luokka(
luokka_id SERIAL PRIMARY KEY,
luokka_nimi varchar(20));

CREATE TABLE Askareen_luokka(
luokka_id INTEGER REFERENCES Luokka,
askare_id INTEGER REFERENCES Askare);
