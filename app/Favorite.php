<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Favorite extends Model
{
    use RecordsActivity;

    protected $guarded = [];

    // a favorite belongs to a reply or a thread
    public function favorited()
    {
        return $this->morphTo();
    }
}
