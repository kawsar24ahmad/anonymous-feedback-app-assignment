<?php
namespace App\feedback;
use App\helpers\Sanitize;

class FeedbackWriting
{
    private string $feedback;
    private string $filename= "feedback-store.json";
    private  $data;
    public $user_id;
    public array $errors;

    public function __construct($user_id, array $errors) {
        $this->user_id = $user_id;
        $this->errors = $errors;
    }

    public function writeFeedback()  
    {
        $sanitize = new Sanitize();
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $this->feedback = $_POST['feedback'];
            if (empty($errors)) {
                $this->data = json_encode(['user_id'=> $this->user_id, "feedback"=> $sanitize->sanitize( $this->feedback ) ] );
                if (file_exists($this->filename)) {
                $file = fopen($this->filename, 'a' );
                    if ($file) {
                        file_put_contents($this->filename, $this->data . PHP_EOL, FILE_APPEND);
                    }
                }
                header('Location:feedback-success.php');
                exit;
            }
        }
    }
}
