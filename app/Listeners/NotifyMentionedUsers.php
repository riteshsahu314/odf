<?php

namespace App\Listeners;

use App\Events\ThreadReceivedNewReply;
use App\Notifications\YouWereMentioned;
use App\User;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;

class NotifyMentionedUsers
{
    /**
     * Create the event listener.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     *
     * @param  ThreadReceivedNewReply  $event
     * @return void
     */
    public function handle(ThreadReceivedNewReply $event)
    {
        // Inspect the body of the reply for username mentions
        // And for each mentioned user, notify them.
        User::whereIn('name', $event->reply->mentionedUsers())->get()
            ->each(function ($user) use ($event) {
                $user->notify(new YouWereMentioned($event->reply));
            });

//        // Inspect the body of the reply for username mentions
//        $mentionedUsers = $event->reply->mentionedUsers();
//
//        // And for each mentioned user, notify them.
//        foreach ($mentionedUsers as $name) {
//            if ($user = User::whereName($name)->first()) {
//                $user->notify(new YouWereMentioned($event->reply));
//            }
//        }
    }
}
