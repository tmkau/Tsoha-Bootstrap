<?php

require 'app/models/kayttaja.php';

class KayttajaController extends BaseController {

    public static function kirjautuminen() {
        View::make('kayttaja/login.html');
    }

    public static function kirjaudu() {
        $params = $_POST;

        $kayttaja = Kayttaja::tarkista($params['kayttaja_nimi'], $params['salasana']);

        if ($kayttaja) {
            $_SESSION['kayttaja'] = $kayttaja->kayttaja_id;
            Redirect::to('/askare/askarelista', array('message' => 'Tervetuloa askarelistaasi ' . $kayttaja->kayttaja_nimi . '!'));
        } else {
            View::make('kayttaja/login.html', array('error' => 'Väärä käyttäjätunnus tai salasana',
                'kayttaja_nimi' => $params['kayttaja_nimi']));
        }
    }

    public static function logout() {
        $_SESSION['kayttaja'] = null;
        Redirect::to('/kayttaja/login', array('message' => 'Olet kirjautunut ulos!'));
    }
    
    public static function uusi() {
        View::make('kayttaja/uusi.html');       
    }

    public static function uusi_kayttaja() {
        $params = $_POST;
        $attributes = array(
            'kayttaja_nimi' => $params['kayttaja_nimi'],
            'salasana' => $params['salasana'],
        );
        $kayttaja = new Kayttaja($attributes);
        $errors = $kayttaja->errors();
        Kint::dump($errors);
        if (count($errors) == 0) {
            $kayttaja->uusi($kayttaja->kayttaja_nimi, $kayttaja->salasana);
            Redirect::to('/kayttaja/login', array('message' => 'Uusi kayttajatunnus luotu!'));
        } else {
            View::make('kayttaja/uusi.html', array('errors' => $errors, 'attributes' => $attributes));
        }
    }

}
