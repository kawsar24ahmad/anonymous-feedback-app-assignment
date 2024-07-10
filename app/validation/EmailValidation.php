<?php
namespace App\validation;
use App\helpers\Sanitize;
use App\database\{GetEmail, GetLines};


class EmailValidation
{
    public string $email = "";
    public  $errors = [];
    // Email validation
    public function emailValidate()
    {
        $sanitize = new Sanitize();
     
        if (empty($_POST['email'])) {
            $this->errors['email'] = "Please provide an email address!";
        } else {
            $this->email = $sanitize->sanitize($_POST['email']);
            if (!filter_var($this->email, FILTER_VALIDATE_EMAIL)) {
                $this->errors['email'] = "Please provide a valid email address!";
            }
        }
    }
    public function isEmailExits($email) 
    {
        $getLines = new GetLines();
        $getEmail = new GetEmail();
        $lines =  $getLines->getLinesFormFile("database.json");
        if($email === $getEmail->getEmail($lines,$email)){
            $this->errors['email'] = "This email is already exits!";
        }
    }
}