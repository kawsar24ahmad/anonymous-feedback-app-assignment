<?php 
namespace App\validation;
use App\helpers\Sanitize;

class PasswordValidation
{
    public string $password;
    public $errors = [];

    
    public function passwordValidate()
    {

        $sanitize = new Sanitize();
        // Password validation
        if (empty($_POST['password'])) {
            $this->errors['password'] = "Please provide a password!";
        } elseif (strlen($_POST['password']) < 4) {
            $this->errors['password'] = "Please provide a password longer than 8 characters!";
        } else {
            $this->password = $sanitize->sanitize($_POST['password']);
        }
    
    }
}