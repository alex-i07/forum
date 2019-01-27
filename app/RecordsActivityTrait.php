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
            'type'    => $this->getActivityType('created')
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