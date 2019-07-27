<?php

namespace Tests;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\TestCase as BaseTestCase;

abstract class TestCase extends BaseTestCase
{
    use CreatesApplication;
    use RefreshDatabase;

    protected function setUp(): void
    {
        // $this->withExceptionHandling();
        parent::setUp();

        /**
         * 
        *
        * Without Artisan call you will get a passport 
        * "please create a personal access client" error
        */
        \Artisan::call('passport:install');
    }

}
