<?php
namespace App\auth;
use App\validation\{EmailValidation,PasswordValidation};


class LoginUser
{
    public string $email, $password;
    public $errors = [];
   
    public function login(){
        $emailValidation = new EmailValidation();
        $passwordValidation = new PasswordValidation();

        if ($_SERVER['REQUEST_METHOD'] == 'POST') {

            // Email validation
            $emailValidation->emailValidate();
            $this->errors = array_merge($this->errors, $emailValidation->errors);

            // Password validation
            $passwordValidation->passwordValidate();
            $this->errors = array_merge($this->errors, $passwordValidation->errors );
        
            // If there are no errors, process the form
            if (empty($this->errors)) {
                $filename = "database.json";
                if (file_exists($filename)) {
                    $lines = file($filename, FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);
        
                    $found = false;
                    foreach ($lines as $line) {
                        $single_data = json_decode($line, true);
                        if (isset($single_data['email']) && $single_data['email'] === $emailValidation->email) {
                            // Email found
                            $found = true;
                            //  check password
                            if (password_verify($passwordValidation->password, $single_data['password'])) {
                                $_SESSION['user_id'] = $single_data['user_id'];
                                $_SESSION['user_name'] = $single_data['user_name'];
                                header('Location:dashboard.php');
                                exit;
                                break;
                            } else {
                                $this->errors['auth_error'] = "Incorrect gmail or password!";
                                break;
                            }
                        }
                    }
        
                    if (!$found) {
                        $this->errors['auth_error'] = "Incorrect gmail or password!";
                    }
        
                } else {
                    $this->errors['file_info'] = "This file does not exist!";
                }
            }
        }
    } 
  
}
