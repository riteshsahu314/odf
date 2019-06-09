<?php

namespace Tests\Feature;

use App\Activity;
use App\Rules\Recaptcha;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Tests\TestCase;

class CreateThreadsTest extends TestCase
{
    protected function setUp():void
    {
        parent::setUp();

        app()->singleton(Recaptcha::class, function () {
            return \Mockery::mock(Recaptcha::class, function ($m) {
                $m->shouldReceive('passes')->andReturn(true);
            });
        });
    }

    use DatabaseMigrations;



    /** @test */
    function guests_may_not_create_threads()
    {
        // Enable Exception handling
        $this->withExceptionHandling();

        // When '/threads/create' page is requested
        // an Exception is thrown and
        // it is handled by the Laravel Exception handler
        // and the user is redirected to '/login'
        $this->get('/threads/create')
            ->assertRedirect('/login');

        // When user try to post to '/threads/create' page
        // an Exception is thrown and
        // it is handled by the Laravel Exception handler
        // and the user is redirected to '/login'
        $this->post('/threads')
            ->assertRedirect('/login');
    }

    /** @test */
    function unverified_users_may_not_create_threads()
    {
        $this->signIn(factory('App\User')->states('unconfirmed')->create());

        $this->get('/threads/create')
            ->assertRedirect(route('verification.notice'));

    }

//    /** @test */
//    function an_authenticated_user_can_create_new_forum_threads()
//    {
//        // Given we have a signed in user
//        $this->signIn(create('App\User'));
//
//        // When we hit the endpoint to crate a new thread
//        // make() will not persist data nor will create id
//        $thread = make('App\Thread');
//
//        $response = $this->post('/threads', $thread->toArray() + ['g-recaptcha-response' => 'token']);
//
//        // Then when we visit the thread page
//        // We should see the new thread on the page
//        $this->get($response->headers->get('Location'))
//             ->assertSee($thread->title)
//             ->assertSee($thread->body);
//
//    }

    /** @test */
    function an_authenticated_and_verified_user_can_create_new_forum_threads()
    {
        $response = $this->publishThread(['title' => 'Some Title', 'body' => 'Some body.']);

        // Then when we visit the thread page
        // We should see the new thread on the page
        $this->get($response->headers->get('Location'))
            ->assertSee('Some Title')
            ->assertSee('Some body.');

    }
    
    /** @test */
    function a_thread_requires_a_title()
    {
        $this->publishThread(['title' => null])
            ->assertSessionHasErrors('title');
    }

    /** @test */
    function a_thread_requires_a_body()
    {
        $this->publishThread(['body' => null])
            ->assertSessionHasErrors('body');
    }
    
    /** @test */
    function a_thread_requires_recaptcha_verification()
    {
        unset(app()[Recaptcha::class]);

        $this->publishThread(['g-recaptcha-response' => 'test'])
            ->assertSessionHasErrors('g-recaptcha-response');
    }

    /** @test */
    function a_thread_requires_a_valid_channel()
    {
        factory('App\Channel', 2)->create();

        $this->publishThread(['channel_id' => null])
            ->assertSessionHasErrors('channel_id');

        $this->publishThread(['channel_id' => 999])
            ->assertSessionHasErrors('channel_id');
    }
    
    /** @test */
    function a_thread_requires_a_unique_slug()
    {
        $this->signIn();

        $thread = create('App\Thread', ['title' => 'Foo Title']);

        $this->assertEquals($thread->fresh()->slug, 'foo-title');

        $thread = $this->postJson(route('threads'), $thread->toArray() + ['g-recaptcha-response' => 'token'])->json();

        $this->assertEquals("foo-title-{$thread['id']}", $thread['slug']);
    }
    
    /** @test */
    function a_thread_with_a_title_that_ends_in_a_number_should_generate_the_proper_slug()
    {
        $this->signIn();

        $thread = create('App\Thread', ['title' => 'Some Title 24']);

        $thread = $this->postJson(route('threads'), $thread->toArray() + ['g-recaptcha-response' => 'token'])->json();

        $this->assertEquals("some-title-24-{$thread['id']}", $thread['slug']);
    }

    /** @test */
    function unauthorized_users_may_not_delete_threads()
    {
        $this->withExceptionHandling();

        $thread = create('App\Thread');

        $this->delete($thread->path())->assertRedirect('/login');

        $this->signIn();
        $this->delete($thread->path())->assertStatus(403);

    }

    /** @test */
    function authorized_users_can_delete_threads()
    {
        $this->signIn();

        $thread = create('App\Thread', ['user_id' => auth()->id()]);
        $reply = create('App\Reply', ['thread_id' => $thread->id]);

        $response = $this->json('DELETE', $thread->path());

        $response->assertStatus(204);

        $this->assertDatabaseMissing('threads', ['id' => $thread->id]);
        $this->assertDatabaseMissing('replies', ['id' => $reply->id]);

//        $this->assertDatabaseMissing('activities', [
//            'subject_id' => $thread->id,
//            'subject_type' => get_class($thread)
//        ]);
//
//        $this->assertDatabaseMissing('activities', [
//            'subject_id' => $reply->id,
//            'subject_type' => get_class($reply)
//        ]);

        $this->assertEquals(0, Activity::count());  // assert the activities table has 0 records
    }

    public function publishThread($overrides = [])
    {
        $this->withExceptionHandling()->signIn();

        $thread = make('App\Thread', $overrides);

        return $this->post('/threads', $thread->toArray() + ['g-recaptcha-response' => 'token']);
    }
}
