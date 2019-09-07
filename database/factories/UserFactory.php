<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Reply;
use App\User;
use App\Thread;
use App\Channel;
use Carbon\Carbon;
use Illuminate\Support\Str;
use Faker\Generator as Faker;

/*
|--------------------------------------------------------------------------
| Model Factories
|--------------------------------------------------------------------------
|
| This directory should contain each of the model factory definitions for
| your application. Factories provide a convenient way to generate new
| model instances for testing / seeding your application's database.
|
*/

$factory->define(User::class, function (Faker $faker) {
    return [
        'name' => $faker->name,
        'email' => $faker->unique()->safeEmail,
        'email_verified_at' => now(),
        'password' => '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', // password
        'remember_token' => Str::random(10),
    ];
});

$factory->state(User::class, 'unconfirmed', function () {
    return [
        'email_verified_at' => null
    ];
} );

$factory->state(App\User::class, 'administrator', function () {
    return [
        'name' => 'Ritesh'
    ];
});

$factory->define(Channel::class, function (Faker $faker) {
    $name = $faker->word;

    return [
        'name' => $name,
        'slug' => $name

    ];
});

$factory->define(Thread::class, function (Faker $faker) {
    $title = $faker->sentence;

    return [
        'user_id' => function() {
            // create a user and grab the id
            return factory('App\User')->create()->id;
        },
        'channel_id' => function() {
            // create a user and grab the id
            return factory('App\Channel')->create()->id;
        },
        'title' => $title,
        'body' => $faker->paragraph,
        'slug' => Str::slug($title),
        'locked' => false,
        'visits' => 0
    ];
});

$factory->state(App\Thread::class, 'from_existing_channels_and_users', function ($faker) {
    $title = $faker->sentence;

    return [
        'user_id' => function () {
            return \App\User::all()->random()->id;
        },
        'channel_id' => function () {
            return \App\Channel::all()->random()->id;
        },
        'title' => $title,
        'body'  => $faker->paragraph,
        'visits' => $faker->numberBetween(0, 35),
        'slug' => Str::slug($title),
        'locked' => $faker->boolean(15)
    ];
});

$factory->define(Reply::class, function (Faker $faker) {
    $random_date = Carbon::now()->subDay(rand(0, 6));
    return [
        'thread_id' => function() {
            // create a user and grab the id
            return factory('App\Thread')->create()->id;
        },
        'user_id' => function() {
            // create a user and grab the id
            return factory('App\User')->create()->id;
        },
        'body' => $faker->paragraph,
        'created_at' => $random_date,
        'updated_at' => $random_date
    ];
});

$factory->state(Reply::class, 'from_existing_threads_and_users',function (Faker $faker) {
    $random_date = Carbon::now()->subDay(rand(0, 6));
    return [
        'thread_id' => function() {
            return \App\Thread::all()->random()->id;
        },
        'user_id' => function() {
            return \App\User::all()->random()->id;
        },
        'body' => $faker->paragraph,
        'created_at' => $random_date,
        'updated_at' => $random_date
    ];
});

$factory->define(\Illuminate\Notifications\DatabaseNotification::class, function (Faker $faker) {
    return [
        'id' => \Ramsey\Uuid\Uuid::uuid4()->toString(),
        'type' => 'App\Notifications\ThreadWasUpdated',
        'notifiable_id' => function () {
            return auth()->id() ?: factory('App\User')->create()->id;
        },
        'notifiable_type' => 'App\User',
        'data' => ['foo' => 'bar']
    ];
});
