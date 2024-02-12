<?php


namespace LaravelServicePattern\Tests\Unit;


use LaravelServicePattern\Tests\TestCase;
class FolderTest extends TestCase
{
    /**
     * @group folder_test
     */
    public function test_folder_repository()
    {
        $folder_exist = false;
        if(file_exists($this->app->basePath()."/".config("service-pattern.repository_directory"))) {
            $folder_exist = true;
        } else {
            $folder_exist = false;
        }

        $this->assertEquals(true, $folder_exist);
    }
}
