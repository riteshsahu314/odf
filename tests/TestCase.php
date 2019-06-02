<?php

namespace Tests;

use Illuminate\Foundation\Testing\TestCase as BaseTestCase;
use phpDocumentor\Reflection\Types\Parent_;

abstract class TestCase extends BaseTestCase
{
    use CreatesApplication;

    protected function setUp(): void
    {
        parent::setUp();

        // disable Exception handling
        // so that exceptions are not handled by laravel Exception handler
        // and we see the actual errors
        $this->withoutExceptionHandling();
    }

    protected function signIn($user = null)
    {
        $user = $user ?: create('App\User');

        $this->actingAs($user);

        return $this;
    }
}
