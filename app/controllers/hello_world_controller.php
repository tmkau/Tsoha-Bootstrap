<?php

require 'app/models/askare.php';

class HelloWorldController extends BaseController {

    public static function index() {
        View::make('etusivu.html');
    }

    public static function sandbox() {
        $doom = new Askare(array(
        'askare_nimi' => 'dump',
        'deadline' => 'tänään',
        'kuvaus' => 'jotain'
        ));
        $errors = $doom->errors();
        Kint::dump($doom);
        Kint::dump($errors);
    }

//    public static function askarelista() {
//        View::make('askarelista.html');
//    }
//
//    public static function askaremuokkaus() {
//        View::make('askaremuokkaus.html');
//    }
//
//    public static function askarenakyma() {
//        View::make('askarenakyma.html');
//    }
//
//    public static function kirjautumissivu() {
//        View::make('kirjautumissivu.html');
//    }

}
