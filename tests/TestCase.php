<?php

use Laravel\Lumen\Testing\TestCase as BaseTestCase;

abstract class TestCase extends BaseTestCase
{
    /**
     * Creates the application.
     *
     * @return \Laravel\Lumen\Application
     */
    public function createApplication ()
    {
        return require __DIR__.'/../bootstrap/app.php';
    }

    protected function setUp () : void
    {
        parent::setUp();
        $this->withoutMiddleware();
        if (config('database.default') == 'sqlite') {
            $db = app()->make('db');
            $db->connection()->getPdo()->exec("pragma foreign_keys=1");
        }
    }
}
