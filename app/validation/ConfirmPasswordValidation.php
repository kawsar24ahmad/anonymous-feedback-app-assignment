<?php 
namespace App\validation;

class ConfirmPasswordValidation
{
    public string $confirm_password;
    public $errors = [];

    
    public function confirmPasswordValidate()
    {
        // Password validation
        if (empty($_POST['confirm_password'])) {
            $this->errors['confirm_password'] = "Please confirm your password!";
        } elseif ($_POST['password'] !== $_POST['confirm_password']) {
            $this->errors['confirm_password'] = "Passwords do not match!";
        }
    
    }
}