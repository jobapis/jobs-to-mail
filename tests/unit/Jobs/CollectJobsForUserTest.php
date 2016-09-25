<?php namespace JobApis\JobsToMail\Tests\Unit\Jobs;

use JobApis\Jobs\Client\Collection;
use JobApis\JobsToMail\Tests\TestCase;
use Mockery as m;
use JobApis\JobsToMail\Jobs\CollectJobsForUser;

class CollectJobsForUserTest extends TestCase
{
    public function setUp()
    {
        $this->user = m::mock('JobApis\JobsToMail\Models\User');
        $this->job = new CollectJobsForUser($this->user);
    }

    public function testItCanHandleWhenJobsFound()
    {
        $client = m::mock('JobApis\Jobs\Client\JobsMulti');
        $keyword = uniqid();
        $location = uniqid();

        $jobs = [
            'Provider1' => m::mock(Collection::class),
        ];
        $jobsArray = [
            0 => (object) [
                'title' => uniqid(),
                'datePosted' => time(),
            ],
            1 => (object) [
                'title' => uniqid(),
                'datePosted' => time(),
            ],
        ];

        $this->user->shouldReceive('getAttribute')
            ->with('keyword')
            ->once()
            ->andReturn($keyword);
        $client->shouldReceive('setKeyword')
            ->with($keyword)
            ->once()
            ->andReturnSelf();
        $this->user->shouldReceive('getAttribute')
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
        $jobs['Provider1']->shouldReceive('all')
            ->once()
            ->andReturn($jobsArray);
        $this->user->shouldReceive('notify')
            ->once()
            ->andReturnSelf();

        $results = $this->job->handle($client);

        $this->assertEquals($jobsArray, $results);
    }
}
