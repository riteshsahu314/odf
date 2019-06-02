<?php

namespace Tests\Feature;

use App\Reply;
use App\Thread;
use App\User;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class ParticipateInThreadsTest extends TestCase
{
    use DatabaseMigrations;

    /** @test */
    function unauthenticated_users_may_not_add_replies()
    {
        $this->withExceptionHandling()
            ->post('/threads/some-channel/1/replies', [])
            ->assertRedirect('/login');

        $this->withoutExceptionHandling();
    }

    /** @test */
    function an_authenticated_user_may_participate_in_forum_threads()
    {
        // Given we have an authenticated user
        $this->signIn();

        // And an exisiting thread
        $thread = create(Thread::class);

        // When the user adds a reply to the thread
        $reply = make(Reply::class); // create a reply but don't store in database

        $this->post($thread->path() . '/replies', $reply->toArray());

        // Then their reply should be visible on the page
//        $this->get($thread->path())
//            ->assertSee($reply->body);

        $this->assertDatabaseHas('replies', ['body' => $reply->body]);
        $this->assertEquals(1, $thread->fresh()->replies_count);
    }
    
    /** @test */
    function a_reply_requires_a_body()
    {
        $this->withExceptionHandling()->signIn();

        $thread = create(Thread::class);
        $reply = make(Reply::class, ['body' => null]); // create a reply but don't store in database

//        $this->post($thread->path() . '/replies', $reply->toArray())
//            ->assertSessionHasErrors('body');

        $this->json('post', $thread->path() . '/replies', $reply->toArray())
            ->assertStatus(422);

    }
    
    /** @test */
    function unauthorized_users_cannot_delete_replies()
    {
        $this->withExceptionHandling();

        $reply = create('App\Reply');

        // if the user is not signed in
        $this->delete("/replies/{$reply->id}")
            ->assertRedirect('login');

        // if the user is signed in but the reply doesn't belongs to the user
        $this->signIn()
            ->delete("/replies/{$reply->id}")
            ->assertStatus(403);  // 403: Forbidden
    }

    /** @test */
    function authorized_users_can_delete_replies()
    {
        $this->signIn();

        $reply = create('App\Reply', ['user_id' => auth()->id()]);

        $this->delete("/replies/{$reply->id}")->assertStatus(302);  // 302: Redirect

        $this->assertDatabaseMissing('replies', ['id' => $reply->ic]);

        $this->assertEquals(0, $reply->thread->fresh()->replies_count);
    }

    /** @test */
    function authorized_users_can_update_replies()
    {
        $this->signIn();

        $reply = create('App\Reply', ['user_id' => auth()->id()]);

        $updatedReply = 'You been changed, fool.';
        $this->patch("/replies/{$reply->id}", ['body' => $updatedReply]);  // 302: Redirect

        $this->assertDatabaseHas('replies', ['id' => $reply->id, 'body' => $updatedReply]);
    }

    /** @test */
    function unauthorized_users_cannot_update_replies()
    {
        $this->withExceptionHandling();

        $reply = create('App\Reply');

        // if the user is not signed in
        $this->patch("/replies/{$reply->id}")
            ->assertRedirect('login');

        // if the user is signed in but the reply doesn't belongs to the user
        $this->signIn()
            ->patch("/replies/{$reply->id}")
            ->assertStatus(403);  // 403: Forbidden
    }

    /** @test */
    function replies_that_contain_spam_may_not_be_created()
    {
        $this->withExceptionHandling();

        // Given we have an authenticated user
        $this->signIn();

        // And an exisiting thread
        $thread = create(Thread::class);

        // When the user adds a reply to the thread
        $reply = make(Reply::class, [
            'body' => 'Yahoo Customer Support'
        ]);

//        $this->expectException(\Exception::class);

        $this->json('post', $thread->path() . '/replies', $reply->toArray())
            ->assertStatus(422);
    }

    /** @test */
    function users_may_only_reply_a_maximum_of_once_per_minute()
    {
        $this->withExceptionHandling();

        $this->signIn();

        $thread = create(Thread::class);

        $reply = make(Reply::class, [
            'body' => 'My simple reply.'
        ]);

        $this->post($thread->path() . '/replies', $reply->toArray())
            ->assertStatus(201);

        $this->post($thread->path() . '/replies', $reply->toArray())
            ->assertStatus(429);

    }
}
