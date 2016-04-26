<?php

class Luokka extends BaseModel {

    public $luokka_id, $luokka_nimi;

    public function __construct($attributes) {
        parent::__construct($attributes);
    }

    public static function all($kayttaja_id) {
        $query = DB::connection()->prepare('SELECT * FROM Luokka WHERE kayttaja_id = :kayttaja_id');
        $query->execute(array('kayttaja_id' =>$kayttaja_id));
        $rows = $query->fetchAll();
        $luokat = array();

        foreach ($rows as $row) {
            $luokat[] = new Luokka (array(
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

}
