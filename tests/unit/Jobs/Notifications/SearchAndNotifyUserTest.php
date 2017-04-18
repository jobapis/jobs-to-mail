<?php namespace JobApis\JobsToMail\Tests\Unit\Jobs\Notifications;

use Illuminate\Support\Facades\Log;
use JobApis\JobsToMail\Tests\TestCase;
use Mockery as m;
use JobApis\JobsToMail\Jobs\Notifications\SearchAndNotifyUser;

class SearchAndNotifyUserTest extends TestCase
{
    public function setUp()
    {
        parent::setUp();
        $this->user = m::mock('JobApis\JobsToMail\Models\User');
        $this->search = m::mock('JobApis\JobsToMail\Models\Search');
        $this->recruiterFilter = m::mock('JobApis\JobsToMail\Filters\RecruiterFilter');
        $this->job = new SearchAndNotifyUser($this->search);
    }

    public function testItCanHandleWhenJobsFoundFromOneProvider()
    {
        $client = m::mock('JobApis\Jobs\Client\JobsMulti');
        $keyword = uniqid();
        $location = uniqid();

        $jobs = m::mock('JobApis\Jobs\Client\Collection');
        $jobsArray = $this->getJobsArray();
        $options = [
            'maxAge' => 2,
            'maxResults' => 25,
            'orderBy' => 'datePosted',
            'order' => 'desc',
        ];

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
            ->with($options)
            ->once()
            ->andReturn($jobs);
        $jobs->shouldReceive('all')
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
            $this->recruiterFilter
        );

        $this->assertEquals($jobsArray, $results);
    }

    public function testItCanHandleWhenNoJobsFound()
    {
        $client = m::mock('JobApis\Jobs\Client\JobsMulti');
        $keyword = uniqid();
        $location = uniqid();

        $jobs = m::mock('JobApis\Jobs\Client\Collection');
        $jobsArray = [];
        $options = [
            'maxAge' => 2,
            'maxResults' => 25,
            'orderBy' => 'datePosted',
            'order' => 'desc',
        ];

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
            ->with($options)
            ->once()
            ->andReturn($jobs);
        $jobs->shouldReceive('all')
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
