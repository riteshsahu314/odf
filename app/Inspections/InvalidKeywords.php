<?php


namespace App\Inspections;
use Exception;

class InvalidKeywords
{
    protected $keywords = [
        'yahoo customer support'
    ];

    // Detect invalid keywords
    public function detect($message)
    {
        foreach ($this->keywords as $keyword) {
            if (stripos($message, $keyword) !== false) {
                throw new Exception('Your message contains spam');
            }
        }
    }
}
