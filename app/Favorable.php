<?php

namespace App;

trait Favorable
{

    protected static function bootFavoritable()
    {
        static::deleting(function ($model){
            dd('FROM FAVORABLE TRAIT');
//            $model->favorites->delete();
            $model->favorites->each->delete();
        });
    }

    /**
     * @return mixed
     */
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

    public function unfavorite()
    {
        $attributes = ['user_id' => auth()->user()->id];

        $this->favorites()->where($attributes)->get()->each->delete();
    }

    public function isFavorited()
    {
        //if no one is sign in then trying to get property of non-object because auth()->user() is null
        return $this->favorites()->where('user_id', auth()->user())->exists();
//        return ! !$this->favorites->where('user_id', auth()->user()->id)->count();
    }

    public function getIsFavoritedAttribute()
    {
        return $this->isFavorited();
    }

    public function getFavoritesCountAttribute()
    {
        //DOES NOT WORK FROM TRAIT, WHY? HAD TO DUPLICATE IN MODEL.
        //snake case in propert and singular getFavoritesCountAttribute, not getFavoritesCountAttributes
        return $this->favorites->count();
    }
}