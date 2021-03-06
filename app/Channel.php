<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Channel extends Model
{
    protected $fillable = ['name', 'slug'];

    protected static function boot()
    {
        parent::boot();

        static::deleting(function ($channel) {
            $channel->threads->each->delete();
        });
    }

    /**
     * make route model binding to use 'slug' column instead of
     * 'id' column to retrieve the model class
     *
     * @return string
     */
    public function getRouteKeyName()
    {
        return 'slug'; // TODO: Change the autogenerated stub
    }

    public function threads()
    {
        return $this->hasMany(Thread::class);
    }

}
