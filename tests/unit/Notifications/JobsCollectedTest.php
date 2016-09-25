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
        $this->jobs = [
            0 => m::mock('JobApis\Jobs\Client\Job'),
        ];
        $this->notification = new JobsCollected($this->jobs);
    }

    public function testItWillSendViaMail()
    {
        $user = m::mock('JobApis\JobsToMail\Models\User');
        $this->assertEquals(['mail'], $this->notification->via($user));
    }

    /*
    public function testItConvertsNotificationToMail()
    {
        $user = m::mock('JobApis\JobsToMail\Models\User');

        $user->shouldReceive('getAttribute')
            ->with('id')
            ->andReturn(uniqid());

        $results = $this->notification->toMail($user);

        $this->assertEquals(JobMailMessage::class, get_class($results));
    }
    */
}
