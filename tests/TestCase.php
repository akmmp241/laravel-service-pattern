<?php

namespace LaravelServicePattern\Tests;

use Illuminate\Database\Eloquent\Factories\Factory;
use LaravelServicePattern\LaravelServicePatternServiceProvider;
use Orchestra\Testbench\TestCase as Orchestra;

class TestCase extends Orchestra
{
    public function setUp(): void
    {
        parent::setUp();

        Factory::guessFactoryNamesUsing(
            fn (string $modelName) => 'LaravelServicePattern\\Database\\Factories\\'.class_basename($modelName).'Factory'
        );
    }

    protected function getPackageProviders($app)
    {
        return [
            LaravelServicePatternServiceProvider::class,
        ];
    }

    public function getEnvironmentSetUp($app)
    {
        config()->set('database.default', 'testing');

        /*
        include_once __DIR__.'/../database/migrations/create_laravel-easy-repository_table.php.stub';
        (new \CreatePackageTable())->up();
        */
    }
}
