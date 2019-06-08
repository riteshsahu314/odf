<?php

namespace Tests\Feature;

use App\Thread;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
use Illuminate\Foundation\Testing\DatabaseMigrations;

class SearchTest extends TestCase
{
    use RefreshDatabase;    // will dynamically figure out whether to use DatabaseMigrations or DatabaseTransaction

    /** @test */
    function a_user_can_search_threads()
    {
        // use algolia only for this test
        config(['scout.driver' => 'algolia']);

        $search = 'foobar';

        create('App\Thread', [], 2);
        create('App\Thread', ['body' => "A thread with the {$search} term."], 2);

        do {
            sleep(.25);

            $results = $this->getJson("/threads/search?q={$search}")->json()['data'];
        } while (empty($results));

        $this->assertCount(2, $results);

        Thread::latest()->take(4)->unsearchable();
    }
}
