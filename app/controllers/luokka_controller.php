<?php

require 'app/models/luokka.php';

class LuokkaController extends BaseController {

    public static function luokkalista() {
        self::check_logged_in();
        $kayttaja_id = self::get_user_logged_in()->kayttaja_id;
        $luokat = Luokka::all($kayttaja_id);
        View::make('luokka/luokkalista.html', array('luokat' => $luokat));
    }

}
