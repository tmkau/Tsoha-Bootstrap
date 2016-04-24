<?php

class Kayttaja extends BaseModel {

    public $kayttaja_id, $kayttaja_nimi, $salasana;

    public function __construct($attributes) {
        parent::__construct($attributes);
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

}
