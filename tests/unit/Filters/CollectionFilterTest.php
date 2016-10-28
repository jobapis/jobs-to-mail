<?php namespace JobApis\JobsToMail\Tests\Unit\Http\Messages;

use Illuminate\Support\Facades\Log;
use JobApis\JobsToMail\Filters\CollectionFilter;
use JobApis\JobsToMail\Tests\TestCase;
use Mockery as m;

class CollectionFilterTest extends TestCase
{
    public function setUp()
    {
        parent::setUp();
        $this->filter = new CollectionFilter();
    }

    public function testItCanGetJobsFromCollectionsWhenNoErrors()
    {
        $collectionArray = [
            0 => m::mock('JobApis\Jobs\Client\Collection'),
            1 => m::mock('JobApis\Jobs\Client\Collection'),
            2 => m::mock('JobApis\Jobs\Client\Collection'),
        ];
        $jobsArray = $this->getJobsArray();

        $collectionArray[0]->shouldReceive('getErrors')
            ->once()
            ->andReturn(false);
        $collectionArray[0]->shouldReceive('all')
            ->once()
            ->andReturn($jobsArray);
        $collectionArray[1]->shouldReceive('getErrors')
            ->once()
            ->andReturn(false);
        $collectionArray[1]->shouldReceive('all')
            ->once()
            ->andReturn($jobsArray);
        $collectionArray[2]->shouldReceive('getErrors')
            ->once()
            ->andReturn(false);
        $collectionArray[2]->shouldReceive('all')
            ->once()
            ->andReturn($jobsArray);

        $result = $this->filter->getJobsFromCollections($collectionArray);

        $this->assertEquals(count($jobsArray) * count($collectionArray), count($result));
    }

    public function testItCanGetJobsFromCollectionsWhenErrors()
    {
        $collectionArray = [
            0 => m::mock('JobApis\Jobs\Client\Collection'),
        ];
        $jobsArray = $this->getJobsArray();
        $error = uniqid();

        $collectionArray[0]->shouldReceive('getErrors')
            ->twice()
            ->andReturn([$error]);
        Log::shouldReceive('error')
            ->with($error)
            ->once()
            ->andReturnSelf();
        $collectionArray[0]->shouldReceive('all')
            ->once()
            ->andReturn($jobsArray);

        $result = $this->filter->getJobsFromCollections($collectionArray);

        $this->assertEquals(count($jobsArray) * count($collectionArray), count($result));
    }

    private function getJobsArray($number = 2)
    {
        $jobsArray = [];
        $count = 0;
        while ($count < $number) {
            $jobsArray[] = (object) [
                'title' => $this->faker->sentence(),
                'datePosted' => new \DateTime(),
            ];
            $count++;
        }
        return $jobsArray;
    }
}
