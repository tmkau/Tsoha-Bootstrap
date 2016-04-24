<?php

class Askare extends BaseModel {

    public $askare_id, $askare_nimi, $deadline, $kuvaus;

    public function __construct($attributes) {
        parent::__construct($attributes);
        $this->validators = array('nimen_validointi', 'deadline_validointi');
        
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
            deadline, 'kuvaus' => $this->kuvaus));
        $row = $query->fetch();
        $this->askare_id = $row['askare_id'];
    }
    
    public function update() {
        $query = DB::connection()->prepare('UPDATE Askare SET askare_nimi = :askare_nimi, deadline = :deadline, kuvaus = :kuvaus WHERE askare_id = :askare_id');
        $query-> execute(array('askare_id' => $this-> askare_id, 'askare_nimi' => $this->askare_nimi, 'deadline' => $this->
            deadline, 'kuvaus' => $this->kuvaus));
        $row = $query->fetch();
        
    }
      
	public function delete() {
	  $query = DB::connection()->prepare('DELETE FROM Askare WHERE askare_id = :askare_id');
	  $query->execute(array('askare_id' => $this->askare_id));
	  $row = $query->fetch();
	}

    public function nimen_validointi() {
        $errors = array();
        if ($this->askare_nimi == '' || $this->askare_nimi == null) {
            $errors[] = 'Nimi ei saa olla tyhjä!';
        }
        if (strlen($this->askare_nimi) < 2) {
            $errors[] = 'Nimen pituuden tulee olla vähintään yksi merkki!';
        }

        return $errors;
    }

    public function deadline_validointi() {
        $errors = array();
        // $date = $this->deadline;
        if (!preg_match("/^([0-9]{4})-(0[1-9]|1[0-2])-(0[1-9]|[1-2][0-9]|3[0-1])$/", $this->deadline)) {
            $errors[] = 'Päiväyksen muodon pitää olla vvvv-kk-pp!';
        }

        return $errors;
    }



}

