<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Tests\TestCase;

class MentionUsersTest extends TestCase
{
    use DatabaseMigrations;

    /** @test */
    function mentioned_users_in_a_reply_are_notified()
    {
        // Given we have a user, Ritesh, who is signed in.
        $ritesh = create('App\User', ['name' => 'Ritesh']);
        $this->signIn($ritesh);
        // And another user, Pooja
        $pooja = create('App\User', ['name' => 'Pooja']);

        // If we have a thread
        $thread = create('App\Thread');

        // And Ritesh replies and mentions @Pooja.
        $reply = make('App\Reply', [
            'body' => '@Pooja look at this.'
        ]);

        $this->json('post', $thread->path() . '/replies', $reply->toArray());

        // Then. Pooja should be notified.
        $this->assertCount(1, $pooja->notifications);
    }

    /** @test */
    function it_can_fetch_all_mentioned_users_starting_with_the_given_characters()
    {
        create('App\User', ['name' => 'ElonMusk']);
        create('App\User', ['name' => 'ElonMusk2']);
        create('App\User', ['name' => 'Ritesh']);

        $results = $this->json('GET', '/api/users', ['name' => 'Elon']);

        $this->assertCount(2, $results->json());
    }
}
