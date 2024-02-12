<?php


namespace LaravelServicePattern\Tests\Integrations;


use LaravelServicePattern\Commands\MakeRepository;
use LaravelServicePattern\Tests\TestCase;
use Illuminate\Console\Command;
use Mockery\MockInterface;

class CreateRepositoryTest extends TestCase
{

    /**
     * test create repository
     * @group integration
     */
    public function test_create_repository() {
        $this->artisan("make:repository User");
    }
}
