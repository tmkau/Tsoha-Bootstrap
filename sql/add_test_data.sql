-- Lisää INSERT INTO lauseet tähän tiedostoon
INSERT INTO Kayttaja (kayttaja_nimi, salasana) VALUES ('Heikki', 'Heikki123');
INSERT INTO Kayttaja (kayttaja_nimi, salasana) VALUES ('Kirka', 'Kirka123');
INSERT INTO Askare (askare_nimi, deadline, kuvaus) VALUES ('Hammaslääkäri', '2016-06-06', 'huone xxx, lääkäri yyy');
INSERT INTO Askare (askare_nimi, deadline, kuvaus) VALUES ('Laskarit', '02-02-2016', 'logiikka');
INSERT INTO Kayttajan_askare (kayttaja_id, askare_id) VALUES (1, 1);
INSERT INTO Kayttajan_askare (kayttaja_id, askare_id) VALUES (2, 2);
INSERT INTO Tarkeysluokka (prioriteetti, askare_id) VALUES (1, 1);
INSERT INTO Tarkeysluokka (prioriteetti, askare_id) VALUES (4, 1);
INSERT INTO Luokka (luokka_nimi) VALUES ('Terveys');
INSERT INTO Luokka (luokka_nimi) VALUES ('Koulu');
INSERT INTO Luokka (luokka_nimi) VALUES ('Laitos');
INSERT INTO Askareen_luokka (luokka_id, askare_id) VALUES (1, 1);
INSERT INTO Askareen_luokka (luokka_id, askare_id) VALUES (1, 2);
INSERT INTO Askareen_luokka (luokka_id, askare_id) VALUES (2, 1);
INSERT INTO Askareen_luokka (luokka_id, askare_id) VALUES (2, 2);