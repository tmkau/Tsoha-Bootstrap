<?php

 require 'app/models/askare.php';

class HelloWorldController extends BaseController {

    public static function index() {
        // make-metodi renderöi app/views-kansiossa sijaitsevia tiedostoja
        echo 'Tämä on etusivu!';
    }

    public static function sandbox() {
        $hammas = askare::find(1);
        $askareet = askare::all();
        Kint::dump($hammas);
        Kint::dump($askareet);
    }

    public static function askarelista() {
        View::make('askarelista.html');
    }

    public static function askaremuokkaus() {
        View::make('askaremuokkaus.html');
    }

    public static function askarenakyma() {
        View::make('askarenakyma.html');
    }

    public static function kirjautumissivu() {
        View::make('kirjautumissivu.html');
    }

}
