<?php
namespace App\database;


class GetEmail
{
    public function getEmail(array $lines, $email) 
    {
        foreach ($lines as $line) {
            $single_data = json_decode($line, true);
            if (isset($single_data['email']) && $single_data['email'] == $email   ) {
               return $single_data['email'];
            }else{
                continue;
            }
        }
    }

   
}
