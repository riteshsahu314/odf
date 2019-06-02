<?php


namespace App;


trait RecordsActivity
{
    //  Any class that uses this trait
    // this method will be called as if
    // the boot method on the class itself
    // Convention: bootTraitName()
    protected static function bootRecordsActivity()
    {
        if (auth()->guest()) return;

        foreach (static::getActivitiesToRecord() as $event) {
            static::$event(function ($model) use ($event) {  /** use ($event)- inherit $event from parent scope */
                $model->recordActivity($event);
            });
        }

        // When deleting a record (a thread or a reply)
        // also delete it's activity
        static::deleting(function ($model) {
            $model->activity()->delete();
        });

//        static::created(function ($subject) {
//            $subject->recordActivity('created');
//        });
    }

    protected static function getActivitiesToRecord()
    {
        return ['created'];
    }

    protected function recordActivity($event)
    {
        $this->activity()->create([
            'user_id' => auth()->id(),
            'type' => $this->getActivityType($event),
        ]);

//        Activity::create([
//            'user_id' => auth()->id(),
//            'type' => $this->getActivityType($event),
//            'subject_id' => $this->id,
//            'subject_type' => get_class($this)
//        ]);
    }

    // Any model that use this trait
    // will contain this function
    // Polymorphic Relationship
    // A model has many activities
    public function activity()
    {
        // morphMany is just like hasMany but polymorphic
        return $this->morphMany('App\Activity', 'subject');
    }

    protected function getActivityType($event)
    {
        $type = strtolower((new \ReflectionClass($this))->getShortName());

        return "{$event}_{$type}";
    }
}
