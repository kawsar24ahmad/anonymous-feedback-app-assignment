<?php

namespace App\auth;
use App\validation\{ConfirmPasswordValidation, EmailValidation, NameValidation, PasswordValidation};
use App\helpers\FlashMassage;


class RegisterUser
{

    public string  $name,  $email,  $password, $confirm_password;
    public $errors =[];
    
    public function registerUser() 
    {
        $flashMassage = new FlashMassage();
        $userId = new UserId();
        $emailValidation = new EmailValidation();
        $passwordValidation = new PasswordValidation();

        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            // Name validation
           $name = $_POST['name'];
           $email = $_POST['email'];
           $nameValidation = new NameValidation();
           $user_name = $nameValidation->nameValidate($name);
           $this->errors = array_merge($this->errors, $nameValidation->errors );
        
        // Email validation

        $emailValidation->emailValidate();
        $emailValidation->isEmailExits( $email);
        $this->errors = array_merge($this->errors, $emailValidation->errors);

        // Password validation
        $passwordValidation->passwordValidate();
        $this->errors = array_merge($this->errors, $passwordValidation->errors );
           

        // Confirm password validation
        $cPasswordValidation = new ConfirmPasswordValidation();
        $cPasswordValidation->confirmPasswordValidate();
        $this->errors = array_merge($this->errors, $cPasswordValidation->errors );
           
        
            // If there are no errors, process the form
            if (empty($this->errors)) {
                $filename = "database.json";
                $user_id = $userId->getUserId();
                $data = json_encode([
                    "user_id" => $user_id,
                    "user_name" => $user_name,
                    "email" => $emailValidation->email,
                    "password" => password_hash($passwordValidation->password, PASSWORD_DEFAULT)
              
                ]);

                if (file_exists($filename)) {
                    $file = fopen($filename, 'a');
                    if ($file) {
                        file_put_contents($filename, $data . PHP_EOL, FILE_APPEND);
                    }
                }

                $flashMassage->flash('success', 'Registered successfully! Please log in now!');
                header('Location: login.php');
                exit;
            }
        }
    }
}

class UserId
{
    private $filename = "database.json";

    public function getUserId(): int
    {
        $lines = file($this->filename, FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);
        return count($lines) + 1; // Incrementing user ID
    }
}
