<?php
namespace App\validation;
use App\helpers\Sanitize;

class NameValidation
{
    public $errors = [];
    public function nameValidate($name) : string
    {
        $sanitize = new Sanitize();
        if (empty($name)) {
           return  $this->errors['name'] = "Please provide a name!";
        } else {
            return $name = $sanitize->sanitize($name);
        }
    }
}


