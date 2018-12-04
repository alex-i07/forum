<?php

namespace App;


trait Favorable
{

    public function favorites()
    {
        return $this->morphMany(Favorite::class, 'favorited');
    }

    public function favorite()
    {
        $attributes = ['user_id' => auth()->user()->id];

        if ( !$this->favorites()->where($attributes)->exists()) {
            return $this->favorites()->create($attributes);
        }
    }

    public function isFavorited()
    {
//        return $this->favorites()->where('user_id', auth()->user()->id)->exists();
        return ! !$this->favorites->where('user_id', auth()->user()->id)->count();
    }

    public function getFavoritesCountAttributes()
    {
        return $this->favorites->count();
    }
}