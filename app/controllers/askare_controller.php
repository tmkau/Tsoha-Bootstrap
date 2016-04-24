<?php

require 'app/models/askare.php';

class AskareController extends BaseController {

    public static function askarenakyma($askare_id) {
        $askare = Askare::find($askare_id);
        Kint::dump($askare);
        View::make('askare/askarenakyma.html', array('askare' => $askare));
    }

    public static function askarelista() {
        $askareet = Askare::all();
        View::make('askare/askarelista.html', array('askareet' => $askareet));
    }

    public static function uusi() {
        View::make('askare/uusi.html');
    }

    public function tallenna() {
        $params = $_POST;
        $attributes = array(
            'askare_nimi' => $params['askare_nimi'],
            'deadline' => $params['deadline'],
            'kuvaus' => $params['kuvaus']
        );
        $askare = new Askare($attributes);
        $errors = $askare->errors();
        if (count($errors) == 0) {
            $askare->save();
            Redirect::to('/askare/askarenakyma/' . $askare->askare_id, array('message' => 'Askare on nyt muistilistalla!'));
        } else {
            View::make('askare/uusi.html', array('errors' => $errors, 'attributes' => $attributes));
        }
    }

    public static function muokkaa($askare_id) {
        $askare = Askare::find($askare_id);
        Kint::dump($askare);
        View::make('askare/askaremuokkaus.html', array('askare' => $askare));
    }

    public static function paivita($askare_id) {
        $params = $_POST;

        $attributes = array(
            'askare_id' => $askare_id,
            'askare_nimi' => $params['askare_nimi'],
            'deadline' => $params['deadline'],
            'kuvaus' => $params['kuvaus']
        );

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
        $askare = new Askare(array('askare_id' => $askare_id));
        $askare->delete();
        Redirect::to('/askare/askarelista', array('message' => 'Askare on nyt poistettu!'));
    }

}
