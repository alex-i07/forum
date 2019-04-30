<?php

namespace App;

use function foo\func;
use Illuminate\Database\Eloquent\Model;

class Thread extends Model
{

    use RecordsActivityTrait;

    protected $fillable = ['user_id', 'channel_id', 'title', 'body'];

    protected static function boot()
    {
        parent::boot();

//        static::addGlobalScope('replyCount', function ($builder) {
//            $builder->withCount('replies');
//        });

        static::addGlobalScope('creator', function ($builder) {
            $builder->with('creator');
        });

        static::deleting(function ($thread) {  //откуда берётся $thread?
            $thread->replies->each->delete(); //high order messaging!!!
//            $thread->replies->each(function ($reply){
//                $reply->delete();
//            });
        });
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function replies()
    {
        return $this->hasMany(Reply::class);
//            ->withCount('favorites')
//            ->with('owner');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function creator()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function channel()
    {
        return $this->belongsTo(Channel::class);
    }

    /**
     * Return path to the current thread.
     * @return string
     */
    public function path()
    {
        return "/threads/{$this->channel->slug}/{$this->id}";
//        return '/threads/' . $this->channel->slug . '/'. $this->id;
    }

    /**
     * @param $reply
     * @return Reply
     */
    public function addReply($reply)
    {
        return $this->replies()->create($reply);
    }

    public function scopeFilter($query, $filters)
    {
        return $filters->apply($query);
    }

}
