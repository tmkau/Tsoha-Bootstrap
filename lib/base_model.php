<?php

class BaseModel {
    protected $validators;

    public function __construct($attributes = null) {
        foreach ($attributes as $attribute => $value) {
            if (property_exists($this, $attribute)) {
                $this->{$attribute} = $value;
            }
        }
    }

    public function errors() {
        $virheet = array();
        foreach ($this->validators as $validator) {
            $virheet = array_merge($virheet, $this->{$validator}());
        }

        return $virheet;
    }

}
