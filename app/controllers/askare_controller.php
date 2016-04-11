<?php
require 'app/models/askare.php';

class AskareController extends BaseController {
    public static function askarenakyma($askare_id) {
        $askare = Askare::find($askare_id);
        Kint::dump($askare);
        View::make('askare/askarenakyma.html', array('askare' => $askare));  
    }
    
    public static function uusi() {
        View::make('askare/uusi.html');
    }
    
    public function tallenna() {       
        $params=$_POST;
        $askare = new Askare(array(
            'askare_nimi' => $params['askare_nimi'],
            'deadline' => $params['deadline'],
            'kuvaus' => $params['kuvaus']         
            ));
        Kint::dump($params);
        $askare->save();
        Redirect::to('/askare/askarenakyma/'.$askare->askare_id, array('message' => 'Askare on nyt muistilistalla!'));
    }
    
}


