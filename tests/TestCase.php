<?php namespace JobApis\JobsToMail\Tests;

use Faker\Factory as Faker;
use Illuminate\Foundation\Testing\TestCase as LaravelTestCase;
use Illuminate\Contracts\Console\Kernel;
use Illuminate\Support\Facades\Artisan;

abstract class TestCase extends LaravelTestCase
{
    /**
     * The base URL to use while testing the application.
     *
     * @var string
     */
    protected $baseUrl = 'http://localhost';

    /**
     * @var Faker
     */
    protected $faker;

    /**
     * Stores seed status
     *
     * @var bool
     */
    protected static $seeded = false;

    /**
     * Set up the tests by running the seeder first
     */
    public function setUp()
    {
        parent::setUp();

        // Set up faker for fake data
        $this->faker = Faker::create();

        // Run the DB seeder
        if (!static::$seeded) {
            $this->seedDb();
        }
    }
    /**
     * Creates the application.
     *
     * @return \Illuminate\Foundation\Application
     */
    public function createApplication()
    {
        $app = require __DIR__.'/../bootstrap/app.php';

        $app->make(Kernel::class)->bootstrap();

        return $app;
    }

    /**
     * Runs the database seeder and sets the seeded variable to true.
     */
    private function seedDb()
    {
        static::$seeded = true;
        Artisan::call('db:seed', array('--class'=>'DatabaseSeeder'));
    }
}
