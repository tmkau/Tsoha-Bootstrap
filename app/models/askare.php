<?php

class Askare extends BaseModel {

    public $askare_id, $askare_nimi, $deadline, $kuvaus, $kayttaja_id, $luokat, $prioriteetti;

    public function __construct($attributes) {
        parent::__construct($attributes);
        $this->validators = array('nimen_validointi', 'deadline_validointi', 'kuvaus_validointi', 'prioriteetti_validointi');
    }

    public static function all($kayttaja_id) {
        $query = DB::connection()->prepare('SELECT * FROM Askare WHERE kayttaja_id = :kayttaja_id ORDER BY prioriteetti' );
        $query->execute(array('kayttaja_id' => $kayttaja_id));
        $rows = $query->fetchAll();
        $askareet = array();

        foreach ($rows as $row) {
            $kysely = DB::connection()->prepare('SELECT DISTINCT Luokka.luokka_nimi, Luokka.luokka_id, Luokka.kayttaja_id FROM'
                    . ' Askare, Askareen_luokka, Luokka WHERE Askare.askare_id'
                    . '=Askareen_luokka.askare_id AND Luokka.luokka_id'
                    . '=Askareen_luokka.luokka_id AND Askare.askare_id=:askare_id');
            $kysely->execute(array('askare_id' => $row['askare_id']));
            $rivit = $kysely->fetchAll();
            $luokat = array();

            foreach ($rivit as $rivi) {
                $luokat[] = new Luokka(array(
                    'luokka_id' => $rivi['luokka_id'],
                    'luokka_nimi' => $rivi['luokka_nimi'],
                    'kayttaja_id' => $rivi['kayttaja_id']
                ));
            }

            $askareet[] = new Askare(array(
                'askare_id' => $row['askare_id'],
                'askare_nimi' => $row['askare_nimi'],
                'deadline' => $row['deadline'],
                'kuvaus' => $row['kuvaus'],
                'prioriteetti' => $row['prioriteetti'],
                'kayttaja_id' => $row['kayttaja_id'],
                'luokat' => $luokat
            ));

            unset($luokat);
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
                'kuvaus' => $row['kuvaus'],
                'prioriteetti' => $row['prioriteetti']
            ));
            return $askare;
        }
        return null;
    }

    public function save() {
        $query = DB::connection()->prepare('INSERT INTO Askare(askare_nimi, deadline, kuvaus, kayttaja_id, prioriteetti) VALUES (:askare_nimi, :deadline, :kuvaus, :kayttaja_id, :prioriteetti) RETURNING askare_id');
        $query->execute(array('askare_nimi' => $this->askare_nimi, 'deadline' => $this->
            deadline, 'kuvaus' => $this->kuvaus, 'kayttaja_id' => $this->kayttaja_id, 'prioriteetti' => $this->prioriteetti));
        $row = $query->fetch();
        $this->askare_id = $row['askare_id'];

        if ($this->luokat !== null) {
            foreach ($this->luokat as $luokka) {
                $kysely = DB::connection()->prepare('INSERT INTO 
         Askareen_luokka(luokka_id, askare_id) VALUES (:luokka, :askare_id)');
                $kysely->execute(array('luokka' => $luokka, 'askare_id' => $this->askare_id));
                $rivi = $kysely->fetch();
            }
        }
    }

    public function update() {
        $query = DB::connection()->prepare('UPDATE Askare SET askare_nimi = :askare_nimi, deadline = :deadline, kuvaus = :kuvaus, prioriteetti = :prioriteetti WHERE askare_id = :askare_id');
        $query->execute(array('askare_id' => $this->askare_id, 'askare_nimi' => $this->askare_nimi, 'deadline' => $this->
            deadline, 'kuvaus' => $this->kuvaus, 'prioriteetti' => $this->prioriteetti));
        $row = $query->fetch();


        $tyhjennys = DB::connection()->prepare('DELETE FROM Askareen_luokka WHERE askare_id = :askare_id');
        $tyhjennys->execute(array('askare_id' => $this->askare_id));
        $tyhjennysrivi = $tyhjennys->fetch();

        if ($this->luokat !== null) {
            foreach ($this->luokat as $luokka) {
                $kysely = DB::connection()->prepare('INSERT INTO Askareen_luokka(luokka_id, askare_id) VALUES (:luokka_id, :askare_id)');
                $kysely->execute(array('askare_id' => $this->askare_id, 'luokka_id' => $luokka));
                $rivi = $kysely->fetch();
            }
        }
    }

    public function delete() {
        $kysely = DB::connection()->prepare('DELETE FROM Askareen_luokka WHERE askare_id = :askare_id');
        $kysely->execute(array('askare_id' => $this->askare_id));
        $rivi = $kysely->fetch();

        $query = DB::connection()->prepare('DELETE FROM Askare WHERE askare_id = :askare_id');
        $query->execute(array('askare_id' => $this->askare_id));
        $row = $query->fetch();
    }

    public function nimen_validointi() {
        $errors = array();
        if ($this->askare_nimi == '' || $this->askare_nimi == null) {
            $errors[] = 'Nimi ei saa olla tyhjä!';
        }
        if (strlen($this->askare_nimi) < 2 || strlen($this->askare_nimi) > 20) {
            $errors[] = 'Nimen pituuden  on oltava 2-20 merkkiä!';
        }

        return $errors;
    }

    public function deadline_validointi() {
        $errors = array();
        if (!preg_match("/^([0-9]{4})-(0[1-9]|1[0-2])-(0[1-9]|[1-2][0-9]|3[0-1])$/", $this->deadline)) {
            $errors[] = 'Päiväyksen muodon pitää olla vvvv-kk-pp!';
        }

        return $errors;
    }

    public function kuvaus_validointi() {
        $errors = array();
        if ($this->kuvaus == '' || $this->kuvaus == null) {
            $errors[] = 'Kuvaus ei saa olla tyhjä!';
        }
        if (strlen($this->kuvaus) < 2 || strlen($this->kuvaus) > 100) {
            $errors[] = 'Kuvauksen pituuden on oltava 2-100 merkkiä!';
        }

        return $errors;
    }

    public function prioriteetti_validointi() {
        $errors = array();
        if ($this->prioriteetti < 0 || $this->prioriteetti > 100) {
            $errors[] = 'Prioriteetti ei saa olla ainakaan negatiivinen!';
        }
        if ($this->prioriteetti == '' || $this->prioriteetti == null) {
            $errors[] = 'Prioriteetti ei saa olla tyhjä!';
        } if (!is_numeric($this->prioriteetti)) {
            $errors[] = 'Prioriteetin pitää olla numero!';
        }

        return $errors;
    }

}
