<?php namespace JobApis\JobsToMail\Tests\Unit\Jobs;

use Illuminate\Support\Facades\Log;
use JobApis\Jobs\Client\Collection;
use JobApis\JobsToMail\Tests\TestCase;
use Mockery as m;
use JobApis\JobsToMail\Jobs\SearchAndNotifyUser;

class SearchAndNotifyUserTest extends TestCase
{
    public function setUp()
    {
        parent::setUp();
        $this->user = m::mock('JobApis\JobsToMail\Models\User');
        $this->search = m::mock('JobApis\JobsToMail\Models\Search');
        $this->collectionFilter = m::mock('JobApis\JobsToMail\Filters\CollectionFilter');
        $this->jobFilter = m::mock('JobApis\JobsToMail\Filters\JobFilter');
        $this->recruiterFilter = m::mock('JobApis\JobsToMail\Filters\RecruiterFilter');
        $this->job = new SearchAndNotifyUser($this->search);
    }

    public function testItCanHandleWhenJobsFoundFromOneProvider()
    {
        $client = m::mock('JobApis\Jobs\Client\JobsMulti');
        $keyword = uniqid();
        $location = uniqid();

        $jobs = [
            'Provider1' => m::mock(Collection::class),
        ];
        $jobsArray = $this->getJobsArray();

        $this->search->shouldReceive('getAttribute')
            ->with('keyword')
            ->once()
            ->andReturn($keyword);
        $client->shouldReceive('setKeyword')
            ->with($keyword)
            ->once()
            ->andReturnSelf();
        $this->search->shouldReceive('getAttribute')
            ->with('location')
            ->once()
            ->andReturn($location);
        $client->shouldReceive('setLocation')
            ->with($location)
            ->once()
            ->andReturnSelf();
        $client->shouldReceive('setPage')
            ->with(1, 10)
            ->once()
            ->andReturnSelf();
        $client->shouldReceive('getAllJobs')
            ->once()
            ->andReturn($jobs);
        $this->collectionFilter->shouldReceive('getJobsFromCollections')
            ->with($jobs, 10)
            ->once()
            ->andReturn($jobsArray);
        $this->jobFilter->shouldReceive('sort')
            ->with($jobsArray, 14, 50)
            ->once()
            ->andReturn($jobsArray);
        $this->recruiterFilter->shouldReceive('filter')
            ->with($jobsArray, $this->search)
            ->once()
            ->andReturn($jobsArray);
        $this->search->shouldReceive('getAttribute')
            ->with('user')
            ->once()
            ->andReturn($this->user);
        $this->user->shouldReceive('notify')
            ->once()
            ->andReturnSelf();

        $results = $this->job->handle(
            $client,
            $this->collectionFilter,
            $this->jobFilter,
            $this->recruiterFilter
        );

        $this->assertEquals($jobsArray, $results);
    }

    public function testItCanHandleWhenJobsFoundFromMultipleProviders()
    {
        $client = m::mock('JobApis\Jobs\Client\JobsMulti');
        $keyword = uniqid();
        $location = uniqid();

        $jobs = [
            'Provider1' => m::mock(Collection::class),
            'Provider2' => m::mock(Collection::class),
            'Provider3' => m::mock(Collection::class),
        ];
        $jobsArray = $this->getJobsArray();

        $this->search->shouldReceive('getAttribute')
            ->with('keyword')
            ->once()
            ->andReturn($keyword);
        $client->shouldReceive('setKeyword')
            ->with($keyword)
            ->once()
            ->andReturnSelf();
        $this->search->shouldReceive('getAttribute')
            ->with('location')
            ->once()
            ->andReturn($location);
        $client->shouldReceive('setLocation')
            ->with($location)
            ->once()
            ->andReturnSelf();
        $client->shouldReceive('setPage')
            ->with(1, 10)
            ->once()
            ->andReturnSelf();
        $client->shouldReceive('getAllJobs')
            ->once()
            ->andReturn($jobs);
        $this->collectionFilter->shouldReceive('getJobsFromCollections')
            ->with($jobs, 10)
            ->once()
            ->andReturn($jobsArray);
        $this->jobFilter->shouldReceive('sort')
            ->with($jobsArray, 14, 50)
            ->once()
            ->andReturn($jobsArray);
        $this->recruiterFilter->shouldReceive('filter')
            ->with($jobsArray, $this->search)
            ->once()
            ->andReturn($jobsArray);
        $this->search->shouldReceive('getAttribute')
            ->with('user')
            ->once()
            ->andReturn($this->user);
        $this->user->shouldReceive('notify')
            ->once()
            ->andReturnSelf();

        $results = $this->job->handle(
            $client,
            $this->collectionFilter,
            $this->jobFilter,
            $this->recruiterFilter
        );

        $this->assertEquals($jobsArray, $results);
    }

    public function testItCanHandleWhenNoJobsFound()
    {
        $client = m::mock('JobApis\Jobs\Client\JobsMulti');
        $keyword = uniqid();
        $location = uniqid();

        $jobs = [
            'Provider1' => m::mock(Collection::class),
        ];
        $jobsArray = [];

        $this->search->shouldReceive('getAttribute')
            ->with('keyword')
            ->once()
            ->andReturn($keyword);
        $client->shouldReceive('setKeyword')
            ->with($keyword)
            ->once()
            ->andReturnSelf();
        $this->search->shouldReceive('getAttribute')
            ->with('location')
            ->once()
            ->andReturn($location);
        $client->shouldReceive('setLocation')
            ->with($location)
            ->once()
            ->andReturnSelf();
        $client->shouldReceive('setPage')
            ->with(1, 10)
            ->once()
            ->andReturnSelf();
        $client->shouldReceive('getAllJobs')
            ->once()
            ->andReturn($jobs);
        $this->collectionFilter->shouldReceive('getJobsFromCollections')
            ->with($jobs, 10)
            ->once()
            ->andReturn($jobsArray);
        $this->jobFilter->shouldReceive('sort')
            ->with($jobsArray, 14, 50)
            ->once()
            ->andReturn($jobsArray);
        $this->recruiterFilter->shouldReceive('filter')
            ->with($jobsArray, $this->search)
            ->once()
            ->andReturn($jobsArray);
        $this->search->shouldReceive('getAttribute')
            ->with('id')
            ->once()
            ->andReturn(uniqid());
        Log::shouldReceive('info')
            ->once()
            ->andReturnSelf();

        $results = $this->job->handle(
            $client,
            $this->collectionFilter,
            $this->jobFilter,
            $this->recruiterFilter
        );

        $this->assertEquals($jobsArray, $results);
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
