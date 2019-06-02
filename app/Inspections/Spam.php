<?php

namespace App\Inspections;


class Spam
{
    protected $inspections = [
        InvalidKeywords::class,
        KeyHeldDown::class
    ];

    public function detect($message) {

        foreach ($this->inspections as $inspection) {
//            (new $inspection)->detect($message);
            app($inspection)->detect($message);
        }

        return false;   // return false if spam not detected
    }

}
