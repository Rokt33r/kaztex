<?php namespace Kaztex\Core;

class InvalidInputException extends \Exception{

    protected $errors;

    function __construct($message, $errors){
        $this->errors = $errors;

        parent::__construct($message);
    }

    public function getErrors(){
        return $this->errors;
    }
}