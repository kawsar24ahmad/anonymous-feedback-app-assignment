<?php
namespace App\feedback;

class FeedbackReading
{
    private string $filename;
    public $user_id;
    public array $errors;

    public function __construct($user_id, array $errors, string $filename) {
        $this->user_id = $user_id;
        $this->errors = $errors;
        $this->filename = $filename;
    }

    public function readFeedback() : array 
    {
        if (file_exists($this->filename)) {
            $lines = file($this->filename, FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);
            return $lines;
        } else {
            $this->errors['file_info'] = "This file does not exist!";
            return [];
        }
    }

    public function getUserName($user_id) : string
    {
        $lines = $this->readFeedback();
        foreach ($lines as $line) {
            $single_data = json_decode($line, true);
           

            if (isset($single_data['user_id']) && $single_data['user_id'] == $user_id) {
                return isset($single_data['user_name']) ? $single_data['user_name'] : 'Unknown User';
            }
        }
        return 'Unknown User';
    }

    public function getFeedback(array $lines) : array
    {
        $single_feedback = [];
        foreach ($lines as $line) {
            $single_data = json_decode($line, true);
            if (isset($single_data['feedback']) && $single_data['user_id'] == $this->user_id) {
                $single_feedback[] = $single_data['feedback'];
            }
        }
        return $single_feedback;
    }
}
