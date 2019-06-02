<?php


namespace App;


use Illuminate\Database\Eloquent\Model;

trait Favoritable
{
    protected static function bootFavoritable()
    {
        // When deleting a record (a thread or a reply)
        // also delete their reply
        static::deleting(function ($model) {
            $model->favorites->each->delete();
        });
    }

    /**
     * Determine if the current reply has been favorited
     *
     * @return bool
     */
    public function isFavorited()
    {
        return !! $this->favorites->where('user_id', auth()->id())->count();
    }

    public function getIsFavoritedAttribute()
    {
        return $this->isFavorited();
    }

    public function getFavoritesCountAttribute()
    {
        return $this->favorites->count();
    }

    /**
     * A reply can be favorited.
     *
     * @return \Illuminate\Database\Eloquent\Relations\MorphMany
     */
    public function favorites()
    {
        // return the relationship
        return $this->morphMany(Favorite::class, 'favorited');
    }

    /**
     * Favorite the current reply or thread
     *
     * @return Model
     */
    public function favorite()
    {
        $attributes = ['user_id' => auth()->id()];

        // if favorite not exists then create a favorite
        if (!$this->favorites()->where($attributes)->exists()) {
            $this->favorites()->create($attributes);
        }
    }

    // Unfavorite the current reply or thread
    public function unfavorite()
    {
        $attributes = ['user_id' => auth()->id()];

        // if favorite exists then delete the favorite
        if ($this->favorites()->where($attributes)->exists()) {
//            $this->favorites()->where($attributes)->delete();     // but this will not fire model event's i.e. the deleting event
            $this->favorites()->where($attributes)->get()->each->delete();
        }
    }
}
