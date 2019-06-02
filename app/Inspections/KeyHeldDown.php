<?php


namespace App\Inspections;

use Exception;

class KeyHeldDown
{

    // Detect key held down
    public function detect($message)
    {
        // check for a character repeated more than 4 times continuously like aaaaa, bbbbbbb
        if (preg_match('/(.)\\1{4,}/', $message)) {
            throw new Exception('Your message contains spam');
        }
    }

}
