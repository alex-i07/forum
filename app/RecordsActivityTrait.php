<?php

namespace App;


trait RecordsActivityTrait
{

    protected static function bootRecordsActivityTrait()
    {
        if(auth()->guest()) return;

        foreach (static::getActivitiesToRecord() as $event) {
            static::$event(function ($model) use ($event) {
                $model->recordActivity($event);
            });
        }

        static::deleting(function ($model) {
            //Call to undefined method App\Favorite::favorites()
//            dd('DELETING EVENT', $model->activity()->get()->each->favorites()->get()->each->delete());
//            $model->activity()->get()->each->delete();
            $model->activity->each->delete();
//            $model->activity->each(function($value){
////                $value->favorites()->get()->each->delete();
//                $value->delete();
//            });
        });

//        static::created(function ($thread) {
//            $thread->recordActivity('created');
//        });
    }

    protected static function getActivitiesToRecord()
    {
        return ['created'];
    }

    protected function recordActivity($event)
    {
        $this->activity()->create([
            'user_id' => auth()->user()->id,
            'type'    => $this->getActivityType($event)
        ]);

//        Activity::create([
//            'user_id'      => auth()->user()->id,
//            'type'         => $this->getActivityType('created'),
//            'subject_id'   => $this->id,
//            'subject_type' => get_class($this)
//        ]);
    }

    public function activity()
    {
        return $this->morphMany('App\Activity', 'subject');
    }

    protected function getActivityType($event)
    {
        $type = strtolower((new \ReflectionClass($this))->getShortName());

        return "{$event}_{$type}";
    }
}