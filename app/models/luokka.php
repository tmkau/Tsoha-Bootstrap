<?php

class Luokka extends BaseModel {

    public $luokka_id, $luokka_nimi, $kayttaja_id;

    public function __construct($attributes) {
        parent::__construct($attributes);
        $this->validators = array('luokan_nimen_validointi');
    }

    public static function all($kayttaja_id) {
        $query = DB::connection()->prepare('SELECT * FROM Luokka WHERE kayttaja_id = :kayttaja_id');
        $query->execute(array('kayttaja_id' => $kayttaja_id));
        $rows = $query->fetchAll();
        $luokat = array();

        foreach ($rows as $row) {
            $luokat[] = new Luokka(array(
                'luokka_id' => $row['luokka_id'],
                'luokka_nimi' => $row['luokka_nimi'],
                'kayttaja_id' => $row['kayttaja_id']
            ));
        }
        return $luokat;
    }

    public static function find($luokka_id) {
        $query = DB::connection()->prepare('SELECT * FROM Luokka WHERE luokka_id = :luokka_id LIMIT 1');
        $query->execute(array('luokka_id' => $luokka_id));
        $row = $query->fetch();

        if ($row) {
            $luokka = new Luokka(array(
                'luokka_id' => $row['luokka_id'],
                'luokka_nimi' => $row['luokka_nimi'],
            ));
            return $luokka;
        }
        return null;
    }

    public static function find_by_askare_id($askare_id) {
        $query = DB::connection()->prepare('SELECT Luokka.luokka_nimi, Luokka.luokka_id, Luokka.kayttaja_id FROM Luokka, Askareen_luokka WHERE Askareen_luokka.luokka_id = Luokka.luokka_id AND Askareen_luokka.askare_id = :askare_id');
        $query->execute(array('askare_id' => $askare_id));
        $rows = $query->fetchAll();
        $luokat = array();
        if ($rows) {
            foreach ($rows as $row) {
                $luokat[] = new Luokka(array(
                    'luokka_id' => $row['luokka_id'],
                    'luokka_nimi' => $row['luokka_nimi'],
                    'kayttaja_id' => $row['kayttaja_id']
                ));
            }
            return $luokat;
        } 
        return null;
    }

    public function save() {
        $query = DB::connection()->prepare('INSERT INTO Luokka(luokka_nimi, kayttaja_id) VALUES (:luokka_nimi, :kayttaja_id) RETURNING luokka_id');
        $query->execute(array('luokka_nimi' => $this->luokka_nimi, 'kayttaja_id' => $this->kayttaja_id));
        $row = $query->fetch();
        $this->luokka_id = $row['luokka_id'];
    }

    public function luokan_nimen_validointi() {
        $errors = array();
        if ($this->luokka_nimi == '' || $this->luokka_nimi == null) {
            $errors[] = 'Nimi ei saa olla tyhjä!';
        }
        if (strlen($this->luokka_nimi) > 20) {
            $errors[] = 'Nimen pitää olla alle 20 merkkiä!';
        }
        return $errors;
    }

    public function delete() {
        $kysely = DB::connection()->prepare('DELETE FROM Askareen_luokka WHERE luokka_id = :luokka_id');
        $kysely->execute(array('luokka_id' => $this->luokka_id));
        $rivi = $kysely->fetch();

        $query = DB::connection()->prepare('DELETE FROM Luokka WHERE luokka_id = :luokka_id');
        $query->execute(array('luokka_id' => $this->luokka_id));
        $row = $query->fetch();
    }

    public function edit() {
        $query = DB::connection()->prepare('UPDATE Luokka SET luokka_nimi = :luokka_nimi WHERE luokka_id = :luokka_id');
        $query->execute(array('luokka_nimi' => $this->luokka_nimi, 'luokka_id' => $this->luokka_id));
        $row = $query->fetch();
    }

}
