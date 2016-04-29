<?php

require 'app/models/luokka.php';

class LuokkaController extends BaseController {

    public static function luokkalista() {
        self::check_logged_in();
        $kayttaja_id = self::get_user_logged_in()->kayttaja_id;
        $luokat = Luokka::all($kayttaja_id);
        View::make('luokka/luokkalista.html', array('luokat' => $luokat));
    }

    public function uusi() {
        self::check_logged_in();
        $params = $_POST;
        $kayttaja_id = self::get_user_logged_in()->kayttaja_id;
        $attributes = array(
            'luokka_nimi' => $params['luokka_nimi'],
            'kayttaja_id' => $kayttaja_id
        );
        $luokka = new Luokka($attributes);
        $errors = $luokka->errors();
        if (count($errors) == 0) {
            $luokka->save();
            Redirect::to('/luokka/luokkalista', array('message' => 'Luokka lisätty!'));
        } else {
            $errors_luokat = Luokka::all($kayttaja_id);
            View::make('luokka/luokkalista.html', array('errors' => $errors, 'luokat' => $errors_luokat, 'attributes' => $attributes));
        }
    }

    public function muokkaa($luokka_id) {
        self::check_logged_in();
        $luokka = Luokka::find($luokka_id);
        View::make('/luokka/lmuokkaus.html', array('luokka' => $luokka));
    }

    public function paivita($luokka_id) {
        self::check_logged_in();
        $params = $_POST;
        $kayttaja_id = self::get_user_logged_in()->kayttaja_id;
        $attributes = array(
            'luokka_id' => $luokka_id,
            'luokka_nimi' => $params['luokka_nimi'],
            'kayttaja_id' => $kayttaja_id
        );
        $luokka = new Luokka($attributes);
        $errors = $luokka->errors();
        if (count($errors) == 0) {
            $luokka->edit();
            Redirect::to('/luokka/luokkalista', array('message' => 'Luokkaa on nyt muokattu!'));
        } else {
        //   $errors_luokat = Luokka::all($kayttaja_id);
            View::make('luokka/lmuokkaus.html', array('errors' => $errors,'attributes' => $attributes));
        }
    }

    public static function poista($luokka_id) {
        self::check_logged_in();
        $luokka = new Luokka(array('luokka_id' => $luokka_id));
        $luokka->delete();
        Redirect::to('/luokka/luokkalista', array('message' => 'Luokka on nyt poistettu!'));
    }

}
