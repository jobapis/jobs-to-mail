<?php namespace JobApis\JobsToMail\Tests\Unit\Jobs;

use JobApis\JobsToMail\Http\Messages\FlashMessage;
use JobApis\JobsToMail\Jobs\ConfirmUser;
use JobApis\JobsToMail\Tests\TestCase;
use Mockery as m;

class ConfirmUserTest extends TestCase
{
    public function setUp()
    {
        parent::setUp();
        $this->token = uniqid();
        $this->job = new ConfirmUser($this->token);
    }

    public function testItCanHandleIfUserConfirmed()
    {
        $userRepository = m::mock('JobApis\JobsToMail\Repositories\Contracts\UserRepositoryInterface');

        $userRepository->shouldReceive('confirm')
            ->with($this->token)
            ->once()
            ->andReturn(true);

        $result = $this->job->handle($userRepository);

        $this->assertEquals(FlashMessage::class, get_class($result));
        $this->assertEquals('alert-success', $result->type);
    }

    public function testItCanHandleIfExceptionThrown()
    {
        $userRepository = m::mock('JobApis\JobsToMail\Repositories\Contracts\UserRepositoryInterface');

        $userRepository->shouldReceive('confirm')
            ->with($this->token)
            ->once()
            ->andReturn(false);

        $result = $this->job->handle($userRepository);

        $this->assertEquals(FlashMessage::class, get_class($result));
        $this->assertEquals('alert-danger', $result->type);
    }
}
