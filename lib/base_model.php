<?php

  class BaseModel{
    // "protected"-attribuutti on käytössä vain luokan ja sen perivien luokkien sisällä
    protected $validators;

    public function __construct($attributes = null){
      // Käydään assosiaatiolistan avaimet läpi
      foreach($attributes as $attribute => $value){
        // Jos avaimen niminen attribuutti on olemassa...
        if(property_exists($this, $attribute)){
          // ... lisätään avaimen nimiseen attribuuttin siihen liittyvä arvo
          $this->{$attribute} = $value;
        }
      }
    }

    public function errors(){
      // Lisätään $errors muuttujaan kaikki virheilmoitukset taulukkona
       $virheet = array();
      // $nimen_validointi = 'nimen_validointi';
      // $deadline_validointi = 'deadline_validointi';

      foreach($this->validators as $validator){
         
    //      $this->{$nimen_validointi}();
   //       $this-> {$deadline_validointi}();
          
         $virheet = array_merge($virheet, $this -> {$validator}());
        // Kutsu validointimetodia tässä ja lisää sen palauttamat virheet errors-taulukkoon
      }

      return $virheet;
    }

  }
