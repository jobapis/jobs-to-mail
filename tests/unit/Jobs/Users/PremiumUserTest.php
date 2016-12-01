<?php namespace JobApis\JobsToMail\Tests\Unit\Jobs\Users;

use JobApis\JobsToMail\Http\Messages\FlashMessage;
use JobApis\JobsToMail\Jobs\Users\PremiumUserSignup;
use JobApis\JobsToMail\Tests\TestCase;
use Mockery as m;

class PremiumUserTest extends TestCase
{
    public function setUp()
    {
        parent::setUp();
        $this->classData = [
            uniqid() => uniqid(),
        ];
        $this->job = new PremiumUserSignup($this->classData);
        $this->job->admin = m::mock('JobApis\Models\User');
    }

    public function testItCanHandle()
    {
        $this->job->admin->shouldReceive('notify')
            ->once()
            ->andReturnSelf();

        $result = $this->job->handle();

        $this->assertEquals(FlashMessage::class, get_class($result));
        $this->assertEquals('alert-success', $result->type);
    }
}
