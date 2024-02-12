<?php


namespace LaravelServicePattern\Tests\Unit;


use Illuminate\Filesystem\Filesystem;
use Illuminate\Support\Facades\File;
use LaravelServicePattern\Tests\TestCase;
use LaravelServicePattern\helpers\Search;
use SplFileInfo;

/**
 * @group serviceprovider
 * Class ServiceProviderTest
 * @package LaravelEasyRepository\Tests\Unit
 */
class ServiceProviderTest extends TestCase
{

    private Filesystem $files;
    public function setUp(): void
    {
        parent::setUp();
        $this->files = $this->app->make(Filesystem::class);
    }

    /**
     * test schema bind service
     * @group bindrepo
     */
    public function test_schema_bind_repository()
    {
            $dirs = File::directories($this->app->basePath() .
                "/" . config("service-pattern.repository_directory"));
            $folders = [];
            foreach ($dirs as $dir) {
                $arr = explode("/", $dir);

                $folders[] = end($arr);
            }

        $repositoryInterfaces = $folders;

        $repositoryServiceProvider = [];
        foreach ($repositoryInterfaces as $key => $repositoryInterface) {
            $repositoryInterfaceClass =  config("service-pattern.repository_namespace"). "\\"
                                                . $repositoryInterface. "\\"
                                                .$repositoryInterface
                                                .config("service-pattern.repository_interface_suffix");

            $repositoryImplementClass = config("service-pattern.repository_namespace"). "\\"
                                                . $repositoryInterface. "\\"
                                                .$repositoryInterface
                                                .config("service-pattern.repository_suffix");

            $repositoryServiceProvider[] = [$repositoryInterfaceClass, $repositoryImplementClass];
        }
            $this->assertArrayHasKey(0, $repositoryServiceProvider);
    }

    /**
     * test schema bind service
     * @group binservice
     */
    public function test_schema_bind_service()
    {
        $dirs = File::directories($this->app->basePath() .
            "/" . config("service-pattern.service_directory"));
        $folders = [];
        foreach ($dirs as $dir) {
            $arr = explode("/", $dir);
            $folders[] = end($arr);
        }

        $root = $this->app->basePath() .
            "/" . config("service-pattern.service_directory");

        $path = Search::file($root, ["php"]);

        $servicePath = [];
        foreach ($path as $file) {
            $servicePath[] = str_replace("Services/","",strstr($file->getPath(), "Services"));
        }

        $servicePath = array_unique($servicePath);

        $serviceProvider = [];

        // check binding
        $configBinding = config("service-pattern.bind_service");

        foreach ($servicePath as $serviceName) {
            $splitname = explode("/", $serviceName);
            $className = end($splitname);

            $pathService = str_replace("/", "\\", $serviceName);

            $serviceInterfaceClass =  config("service-pattern.service_namespace"). "\\"
                . $pathService. "\\"
                .$className
                .config("service-pattern.service_interface_suffix");

            $serviceImplementClass = config("service-pattern.service_namespace"). "\\"
                . $pathService. "\\"
                .$className
                .config("service-pattern.service_suffix");

            if (count($configBinding) > 0) {
                if(array_key_exists($serviceInterfaceClass, $configBinding)) {
                    var_dump(config("service-pattern.bind_service.".$serviceInterfaceClass));
                }
            }

            $serviceProvider[] = [$serviceInterfaceClass, $serviceImplementClass];

        }

        $this->assertArrayHasKey(0, $serviceProvider);
    }
}
