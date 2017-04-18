<?php namespace JobApis\JobsToMail\Tests\Unit\Notifications;

use JobApis\JobsToMail\Notifications\Messages\JobMailMessage;
use Mockery as m;
use JobApis\JobsToMail\Notifications\JobsCollected;
use JobApis\JobsToMail\Tests\TestCase;

class JobsCollectedTest extends TestCase
{
    public function setUp()
    {
        parent::setUp();
        $this->search = m::mock('JobApis\JobsToMail\Models\Search');
        $this->job = m::mock('JobApis\Jobs\Client\Job');
        $this->jobs = [
            0 => $this->job,
        ];
        $this->notification = new JobsCollected($this->jobs, $this->search);
    }

    public function testItWillSendViaMail()
    {
        $user = m::mock('JobApis\JobsToMail\Models\User');
        $this->assertEquals(['mail', 'database'], $this->notification->via($user));
    }

    public function testItReturnsArray()
    {
        $search_id = uniqid();
        $user = m::mock('JobApis\JobsToMail\Models\User');
        $this->search->shouldReceive('getAttribute')
            ->with('id')
            ->once()
            ->andReturn($search_id);

        $results = $this->notification->toArray($user);

        $this->assertEquals([
            'search_id' => $search_id,
            'jobs' => $this->jobs,
        ], $results);
    }

    public function testItConvertsNotificationToMail()
    {
        $user = m::mock('JobApis\JobsToMail\Models\User');

        $user->shouldReceive('getAttribute')
            ->with('id')
            ->andReturn(uniqid());
        $this->search->shouldReceive('getAttribute')
            ->with('id')
            ->andReturn(uniqid());
        $this->search->shouldReceive('getAttribute')
            ->with('keyword')
            ->andReturn(uniqid());
        $this->search->shouldReceive('getAttribute')
            ->with('location')
            ->andReturn(uniqid());
        $this->job->shouldReceive('getTitle')
            ->once()
            ->andReturn(uniqid());
        $this->job->shouldReceive('getCompanyName')
            ->once()
            ->andReturn(null);
        $this->job->shouldReceive('getIndustry')
            ->once()
            ->andReturn(null);
        $this->job->shouldReceive('getLocation')
            ->once()
            ->andReturn(null);
        $this->job->shouldReceive('getDatePosted')
            ->once()
            ->andReturn(null);
        $this->job->shouldReceive('getUrl')
            ->once()
            ->andReturn(null);

        $results = $this->notification->toMail($user);

        $this->assertEquals(JobMailMessage::class, get_class($results));
    }
}
