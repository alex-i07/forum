<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Thread extends Model
{
    protected $fillable = ['user_id', 'title', 'body'];

    public function replies()
    {
        return $this->hasMany(Reply::class);
    }

    public function creator()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    /**
     * Return path to the current thread.
     * @return string
     */
    public function path()
    {
        return '/threads/' . $this->id;
    }

    public function addReply($reply)
    {
        $this->replies()->create($reply);
    }
}
