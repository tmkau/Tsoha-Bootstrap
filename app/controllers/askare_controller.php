<?php

require 'app/models/askare.php';
require 'app/models/luokka.php';

class AskareController extends BaseController {

    public static function askarenakyma($askare_id) {
        self::check_logged_in();
        $askare = Askare::find($askare_id);
        View::make('askare/askarenakyma.html', array('askare' => $askare));
    }

    public static function askarelista() {
        self::check_logged_in();
        $kayttaja_id = self::get_user_logged_in()->kayttaja_id;
        $askareet = Askare::all($kayttaja_id);
        View::make('askare/askarelista.html', array('askareet' => $askareet));
    }

    public static function uusi() {
        self::check_logged_in();
        $kayttaja_id = self::get_user_logged_in()->kayttaja_id;
        $luokat = Luokka::all($kayttaja_id);
        Kint::dump($luokat);
        View::make('askare/uusi.html', array('luokat' => $luokat));
    }

    public function tallenna() {
        self::check_logged_in();
        $kayttaja_id = self::get_user_logged_in()->kayttaja_id;


        $params = $_POST;

        if (!array_key_exists('luokat', $params)) {
            $attributes = array(
                'askare_nimi' => $params['askare_nimi'],
                'deadline' => $params['deadline'],
                'kuvaus' => $params['kuvaus'],
                'kayttaja_id' => $kayttaja_id
            );
        } else {
        $luokat = $params['luokat'];

        $attributes = array(
            'askare_nimi' => $params['askare_nimi'],
            'deadline' => $params['deadline'],
            'kuvaus' => $params['kuvaus'],
            'kayttaja_id' => $kayttaja_id,
            'luokat' => array()
        );

        foreach ($luokat as $luokka) {
            $attributes['luokat'][] = $luokka;
        }
        
        }
        $askare = new Askare($attributes);
        $errors = $askare->errors();
        if (count($errors) == 0) {
            $askare->save();
            Redirect::to('/askare/askarenakyma/' . $askare->askare_id, array('message' => 'Askare on nyt muistilistalla!'));
        } else {
            $errors_luokat = Luokka::all($kayttaja_id);
            Kint::dump($luokat);
            View::make('askare/uusi.html', array('errors' => $errors, 'luokat' => $errors_luokat, 'attributes' => $attributes));
        }
    }

    public static function muokkaa($askare_id) {
        self::check_logged_in();
        $askare = Askare::find($askare_id);
        $kayttaja_id = self::get_user_logged_in()->kayttaja_id;
        $luokat = Luokka::all($kayttaja_id);
        View::make('askare/askaremuokkaus.html', array('askare' => $askare, 'luokat' => $luokat));
    }

    public static function paivita($askare_id) {
        self::check_logged_in();
        $params = $_POST;
        $luokat = $params['luokat'];

        $attributes = array(
            'askare_id' => $askare_id,
            'askare_nimi' => $params['askare_nimi'],
            'deadline' => $params['deadline'],
            'kuvaus' => $params['kuvaus'],
            'luokat' => array()
        );

        foreach ($luokat as $luokka) {
            $attributes['luokat'][] = $luokka;
        }

        $askare = new Askare($attributes);
        $errors = $askare->errors();
        if (count($errors) > 0) {
            View::make('askare/askaremuokkaus.html', array('errors' => $errors, 'askare' => $askare));
        } else {
            $askare->update();
            Redirect::to('/askare/askarenakyma/' . $askare->askare_id, array('message' => 'Askaretta on muokattu, jee!'));
        }
    }

    public static function poista($askare_id) {
        self::check_logged_in();
        $askare = new Askare(array('askare_id' => $askare_id));
        $askare->delete();
        Redirect::to('/askare/askarelista', array('message' => 'Askare on nyt poistettu!'));
    }

}
