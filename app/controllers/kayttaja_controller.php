<?php
require 'app/models/kayttaja.php';

class KayttajaController extends BaseController {
    
    public static function kirjautuminen() {
        View::make('kayttaja/login.html');
        
    }
    
    public static function kirjaudu() {
        $params = $_POST;
        
        $kayttaja = Kayttaja::tarkista($params['kayttaja_nimi'], $params['salasana']);
        
        if($kayttaja) {
            $_SESSION['kayttaja'] = $kayttaja->kayttaja_id;
            Redirect::to('/askare/askarelista', array('message' => 'Tervetuloa askarelistaasi ' . $kayttaja->kayttaja_nimi . '!'));
         } else {
             View::make('kayttaja/login.html', array('error' => 'Väärä käyttäjätunnus tai salasana',
                 'kayttaja_nimi' => $params['kayttaja_nimi']));
         }
        
        
    }
}

