<?php
namespace App\database;


class GetLines
{
    public function getLinesFormFile($filename) : array 
    {
        if (file_exists($filename)) {
            $lines = file($filename, FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);
    
            return $lines;
            
        } else {
             echo "This file does not exist!";
        }
    }

   
}
