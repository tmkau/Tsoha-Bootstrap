<?php

class Askare extends BaseModel {

    public $askare_id, $askare_nimi, $deadline, $kuvaus;

    public function __construct($attributes) {
        parent::__construct($attributes);
    }

    public static function all() {
        $query = DB::connection()->prepare('SELECT * FROM Askare');
        $query->execute();
        $rows = $query->fetchAll();
        $askareet = array();

        foreach ($rows as $row) {
            $askareet[] = new Askare(array(
                'askare_id' => $row['askare_id'],
                'askare_nimi' => $row['askare_nimi'],
                'deadline' => $row['deadline'],
                'kuvaus' => $row['kuvaus']
            ));
        }

        return $askareet;
    }

    public static function find($askare_id) {
        $query = DB::connection()->prepare('SELECT * FROM Askare WHERE askare_id = :askare_id LIMIT 1');
        $query->execute(array('askare_id' => $askare_id));
        $row = $query->fetch();

        if ($row) {
            $askare = new Askare(array(
            'askare_id' => $row['askare_id'],
            'askare_nimi' => $row['askare_nimi'],
            'deadline' => $row['deadline'],
            'kuvaus' => $row['kuvaus']
            ));
            return $askare;
        }
        return null;
    }
    
    public function save() {
        $query = DB::connection()->prepare('INSERT INTO Askare(askare_nimi, deadline, kuvaus) VALUES (:askare_nimi, :deadline, :kuvaus) RETURNING askare_id');
        $query->execute(array('askare_nimi' => $this->askare_nimi, 'deadline' => $this->
                deadline, 'kuvaus' =>$this->kuvaus));
        $row = $query->fetch();
        $this->askare_id = $row['askare_id'];
    }

}

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

