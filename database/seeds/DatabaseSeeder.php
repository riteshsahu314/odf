<?php

use App\Activity;
use App\Channel;
use App\Favorite;
use App\Reply;
use App\ThreadSubscription;
use App\User;
use App\Thread;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Artisan;
use \Illuminate\Support\Facades\Redis;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        Schema::disableForeignKeyConstraints();
        $this->users();
        $this->channels();
        $this->content();
        Schema::enableForeignKeyConstraints();
    }

    public function users()
    {
        User::truncate();

        // create dev users
        factory(User::class)->create([
            'name' => 'Ritesh',
            'email' => 'ritesh@example.com',
        ]);

        factory(User::class)->create([
            'name' => 'admin_demo',
            'email' => 'admin_demo@example.com',
        ]);

        // create normal usrs
        factory(User::class)->create([
            'name' => 'user_demo',
            'email' => 'user_demo@example.com',
        ]);

        factory(User::class, 20)->create();
    }

    public function channels()
    {
        Channel::truncate();

        collect([
            [
                'name' => 'PHP',
                'description' => 'A channel for general PHP questions. Use this channel if you can\'t find a more specific channel for your question.'
            ],
            [
                'name' => 'Vue',
                'description' => 'A channel for general Vue questions. Use this channel if you can\'t find a more specific channel for your question.'
            ],
            [
                'name' => 'Laravel Mix',
                'description' => 'This channel is for all Laravel Mix related questions.'
            ],
            [
                'name' => 'Eloquent',
                'description' => 'This channel is for all Laravel Eloquent related questions.'
            ],
            [
                'name' => 'Vuex',
                'description' => 'This channel is for all Vuex related questions.'
            ],
        ])->each(function ($channel) {
            factory(Channel::class)->create([
                'name' => $channel['name'],
                'slug' => Str::slug($channel['name']),
                'description' => $channel['description']
            ]);
        });
    }

    public function content()
    {
        Thread::truncate();
        Reply::truncate();
        ThreadSubscription::truncate();
        Activity::truncate();
        Favorite::truncate();
        Redis::del("odf_database_trending_threads");
        Artisan::call('cache:clear');

        factory(Thread::class, 50)->states('from_existing_channels_and_users')->create()->each(function ($thread) {
            $this->recordActivity($thread, 'created', $thread->creator()->first()->id);
        });

        factory(Reply::class, 100)->states('from_existing_threads_and_users')->create()->each(function ($reply) {
            $this->recordActivity($reply, 'created', $reply->owner()->first()->id);
        });
    }

    /**
     * @param $model
     * @param $event_type
     * @param $user_id
     *
     * @throws ReflectionException
     */
    public function recordActivity($model, $event_type, $user_id)
    {
        $type = strtolower((new \ReflectionClass($model))->getShortName());
        $model->morphMany(\App\Activity::class, 'subject')->create([
            'user_id' => $user_id,
            'type' => "{$event_type}_{$type}"
        ]);
    }
}
