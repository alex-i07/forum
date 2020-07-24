<?php

namespace App;

use App\Events\ThreadHasNewReply;
use Illuminate\Database\Eloquent\Model;
use App\Notifications\ThreadWasUpdated;

class Thread extends Model
{

    use RecordsActivityTrait;

    protected $fillable = ['user_id', 'channel_id', 'title', 'body'];

    protected $appends = ['isSubscribedTo'];

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
        $reply = $this->replies()->create($reply);

        //Implement notifications for all subscribers

        event(new ThreadHasNewReply($this, $reply));



//        foreach ($this->subscriptions as $subscription) {
//            if ($subscription->user_id != $reply->user_id) {
//                $subscription->user->notify(new ThreadWasUpdated($this, $reply));
//            }
//        }

        return $reply;
    }

    /**
     * @param $query
     * @param $filters
     * @return mixed
     */
    public function scopeFilter($query, $filters)
    {
        return $filters->apply($query);
    }

    /**
     * A thread can has many subscriptions.
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function subscriptions()
    {
        return $this->hasMany(ThreadSubscription::class);
    }

    /**
     * A thread can be subscribed to a user.
     *
     * @param null $userId
     * @return $this
     */
    public function subscribe($userId = null)
    {
        $this->subscriptions()->create([
            'user_id' => $userId ?: auth()->user()->id
        ]);

        return $this;
    }

    /**
     * A thread can be unsubscrubed from a user.
     *
     * @param null $userId
     */
    public function unSubscribe($userId = null)
    {
        $this->subscriptions()->where('user_id', $userId ?: auth()->user()->id)->delete();
    }

    /**
     * Defines if given thread is subscribed to authenticated user.
     *
     * @return bool
     */
    public function getIsSubscribedToAttribute()
    {
        //trying to get property of non-object if there are no subscriptions
        if ($this->subscriptions()->exists()) {
            return $this->subscriptions()->where('user_id', auth()->user()->id)->exists();
        }
        return false;
    }

    /**
     * @param User $user
     *
     * @return bool
     */
    public function hasUpdateFor(User $user)
    {
        return true; //temporary
    }

}
