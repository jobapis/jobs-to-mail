<?php namespace JobApis\JobsToMail\Tests\Unit\Notifications;

use Mockery as m;
use JobApis\JobsToMail\Notifications\LoginTokenGenerated;
use JobApis\JobsToMail\Tests\TestCase;

class LoginTokenGeneratedTest extends TestCase
{
    public function setUp()
    {
        parent::setUp();
        $this->token = m::mock('JobApis\JobsToMail\Models\Token');
        $this->notification = new LoginTokenGenerated($this->token);
    }

    public function testItWillSendViaMail()
    {
        $user = m::mock('JobApis\JobsToMail\Models\User');
        $this->assertEquals(['mail'], $this->notification->via($user));
    }

    public function testItConvertsNotificationToMail()
    {
        $user = m::mock('JobApis\JobsToMail\Models\User');

        $user->shouldReceive('getAttribute')
            ->with('id')
            ->andReturn(uniqid());
        $this->token->shouldReceive('__toString')
            ->andReturn(uniqid());

        $results = $this->notification->toMail($user);

        $this->assertEquals('Illuminate\Notifications\Messages\MailMessage', get_class($results));
    }
}
