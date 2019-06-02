<?php

namespace App;

use App\Events\ThreadHasNewReply;
use App\Events\ThreadReceivedNewReply;
use App\Notifications\ThreadWasUpdated;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;
use Stevebauman\Purify\Facades\Purify;

class Thread extends Model
{
    use RecordsActivity;

    /**
     * Don't auto-apply mass assignment protection.
     *
     * @var array
     */
    protected $guarded = [];

    // The relations to eager load on every query
    // as every reply will need 'creator' and 'channel' information
    protected $with = ['creator', 'channel'];

    protected $appends = ['isSubscribedTo'];

    protected $casts = [
        'locked' => 'boolean'
    ];

    // laravel will trigger boot method automatically
    protected static function boot()
    {
        parent::boot(); // TODO: Change the autogenerated stub

        // a global scope is a query scope that is
        // automatically applied to all of the queries
//        static::addGlobalScope('replyCount', function ($builder) {
//            // eager load replies
//            $builder->withCount('replies');
//        });

//        static::addGlobalScope('creator', function ($builder) {
//            // eager load creator
//            $builder->withCount('creator');
//        });

//        // When deleting a thread also delete all associated replies with it
//        // but it will delte replies in bulk, thus their activity will not be deleted
//        static::deleting(function ($thread) {
//            $thread->replies()->delete();
//        });

        // When deleting a thread also delete all associated replies with it
        // as we are deleting each reply separately ( not in bulk )
        // it will also delete each one's associated activity
        static::deleting(function ($thread) {
//            $thread->replies->each(function ($reply) {
//                $reply->delete();
//            });

            // using Higher Order Messaging
            $thread->replies->each->delete();
        });

//        static::created(function ($thread) {
//            $thread->recordActivity('created');
//        });

        static::created(function ($thread) {
            $thread->update(['slug' => $thread->title]);
        });
    }

//    protected function recordActivity($event)
//    {
//        Activity::create([
//            'user_id' => auth()->id(),
//            'type' => $this->getActivityType($event),
//            'subject_id' => $this->id,
//            'subject_type' => get_class($this)
//        ]);
//    }
//
//    protected function getActivityType($event)
//    {
//        return $event . '_' . strtolower((new \ReflectionClass($this))->getShortName());
//    }

    public function path()
    {
        return "/threads/{$this->channel->slug}/{$this->slug}";
    }

    public  function  replies()
    {
        return $this->hasMany(Reply::class);
//            ->withCount('favorites')    // eager load favorites_count
//            ->with('owner');    // eager load owner
    }

//    public function getReplyCountAttribute()
//    {
//        return $this->replies()->count();
//    }

    public function creator()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function channel()
    {
        return $this->belongsTo('App\Channel');
    }

    public function addReply($reply)
    {
       $reply = $this->replies()->create($reply);

        event(new ThreadReceivedNewReply($reply));

//        $this->notifySubscribers($reply);

//        event(new ThreadHasNewReply($this, $reply));

        return $reply;
    }

//    public function notifySubscribers($reply)
//    {
//        $this->subscriptions
//            ->where('user_id', '!=', $reply->user_id)
//            ->each
//            ->notify($reply);
//    }

    public function scopeFilter($query, $filters)
    {
        return $filters->apply($query);
    }

    public function subscribe($userId = null)
    {
        $this->subscriptions()->create([
            'user_id' => $userId ?: auth()->id()
        ]);

        return $this;
    }

    public function unsubscribe($userId = null)
    {
        $this->subscriptions()
            ->where('user_id', $userId ?: auth()->id())
            ->delete();
    }

    public function subscriptions()
    {
        return $this->hasMany(ThreadSubscription::class);
    }

    public function getIsSubscribedToAttribute()
    {
        return $this->subscriptions()
            ->where('user_id', auth()->id())
            ->exists();
    }

    public function hasUpdatesFor($user)
    {
//        $user = $user ?: auth()->user();

        // Look in the cache for the proper key.
        // compare that carbon instance with the $thread->updated_at

//        $key = sprintf("users.%s.visits.%s", auth()->id(), $this->id);

        $key = $user->visitedThreadCacheKey($this);

        return $this->updated_at > cache($key);
    }

    public function getRouteKeyName()
    {
        return 'slug';
    }

    public function getBodyAttribute($body)
    {
        return Purify::clean($body);
    }

    public function setSlugAttribute($value)
    {
        $slug = Str::slug($value);

        if (static::whereSlug($slug)->exists()) {
            $slug = "{$slug}-" . $this->id;
        }

        $this->attributes['slug'] = $slug;
    }
}