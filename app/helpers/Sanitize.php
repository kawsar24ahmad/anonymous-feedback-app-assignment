<?php
namespace App\helpers;


class Sanitize
{
    public function sanitize(string $data) : string 
    {
        return htmlspecialchars(stripslashes(trim($data)));
    }
}