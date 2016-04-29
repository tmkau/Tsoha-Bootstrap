<?php

class Kayttaja extends BaseModel {

    public $kayttaja_id, $kayttaja_nimi, $salasana;

    public function __construct($attributes) {
        parent::__construct($attributes);
        $this->validators = array('kayttajanimen_validointi', 'pituusvalidointi', 'kayttajanimi_varattu', 'salasanan_validointi');
    }

    public static function loyda($kayttaja_id) {
        $query = DB::connection()->prepare('SELECT * FROM Kayttaja WHERE kayttaja_id = :kayttaja_id LIMIT 1');
        $query->execute(array('kayttaja_id' => $kayttaja_id));
        $row = $query->fetch();

        if ($row) {
            $kayttaja = new Kayttaja(array(
                'kayttaja_id' => $row['kayttaja_id'],
                'kayttaja_nimi' => $row['kayttaja_nimi'],
                'salasana' => $row['salasana'],
            ));
            return $kayttaja;
        }
        return null;
    }

    public static function tarkista($kayttaja_nimi, $salasana) {
        $query = DB::connection()->prepare('SELECT * FROM Kayttaja where kayttaja_nimi '
                . '= :kayttaja_nimi and salasana = :salasana limit 1');
        $query->execute(array('kayttaja_nimi' => $kayttaja_nimi, 'salasana' => $salasana));
        $row = $query->fetch();
        if ($row) {
            return new Kayttaja(array(
                'kayttaja_id' => $row['kayttaja_id'],
                'kayttaja_nimi' => $row['kayttaja_nimi'],
                'salasana' => $row['salasana']
            ));
        } else {
            return null;
        }
    }

    public static function uusi($kayttaja_nimi, $salasana) {
        $kysely = DB::connection()->prepare('INSERT INTO Kayttaja (kayttaja_nimi, salasana) values (:kayttaja_nimi, :salasana) RETURNING kayttaja_id');
        $kysely->execute(array('kayttaja_nimi' => $kayttaja_nimi, 'salasana' => $salasana));
    }

    public function kayttajanimen_validointi() {
        $errors = array();
        if ($this->kayttaja_nimi == '' || $this->kayttaja_nimi == null) {
            $errors[] = 'Kayttäjänimi ei saa olla tyhjä!';
        }
        return $errors;
    }

    public function pituusvalidointi() {
        $errors = array();
        if (strlen($this->kayttaja_nimi) > 20 || strlen($this->kayttaja_nimi) < 2) {
            $errors[] = 'Käyttäjänimen pituuden on oltava 2-20 merkkiä!';
        }
        return $errors;
    }

    public function kayttajanimi_varattu() {
        $query = DB::connection()->prepare('SELECT * FROM Kayttaja');
        $query->execute();
        $rows = $query->fetchAll();
        $errors = array();
        foreach ($rows as $row) {
            if ($this->kayttaja_nimi == $row['kayttaja_id']) {
                $errors[] = 'Käyttäjänimi on varattu';
            }
        }
        return $errors;
    }

    public function salasanan_validointi() {
        $errors = array();
        if (strlen($this->salasana) == 0 || $this->salasana == null) {
            $errors[] = 'Salasana ei voi olla tyhjä';
        } if (strlen($this->salasana) > 50 || strlen($this->salasana) < 4){
           $errors[] = 'Salsanan pituuden on oltava 4-50 merkkiä';          
        }
        return $errors;
        }
    }
