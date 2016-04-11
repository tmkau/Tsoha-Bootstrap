<?php

require 'app/models/askare.php';

class AskareetController extends BaseController {

    public static function askarelista() {
        $askareet = Askare::all();
        View::make('askare/askarelista.html', array('askareet' => $askareet));
    }
    

}

