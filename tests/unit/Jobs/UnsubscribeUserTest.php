<?php namespace JobApis\JobsToMail\Tests\Unit\Jobs;

use JobApis\JobsToMail\Http\Messages\FlashMessage;
use JobApis\JobsToMail\Jobs\UnsubscribeUser;
use JobApis\JobsToMail\Tests\TestCase;
use Mockery as m;

class UnsubscribeUserTest extends TestCase
{
    public function setUp()
    {
        parent::setUp();
        $this->userId = $this->faker->uuid();
        $this->job = new UnsubscribeUser($this->userId);
    }

    public function testItCanHandleIfUserConfirmed()
    {
        $userRepository = m::mock('JobApis\JobsToMail\Repositories\Contracts\UserRepositoryInterface');

        $userRepository->shouldReceive('unsubscribe')
            ->with($this->userId)
            ->once()
            ->andReturn(true);

        $result = $this->job->handle($userRepository);

        $this->assertEquals(FlashMessage::class, get_class($result));
        $this->assertEquals('alert-success', $result->type);
    }

    public function testItCanHandleIfExceptionThrown()
    {
        $userRepository = m::mock('JobApis\JobsToMail\Repositories\Contracts\UserRepositoryInterface');

        $userRepository->shouldReceive('unsubscribe')
            ->with($this->userId)
            ->once()
            ->andReturn(false);

        $result = $this->job->handle($userRepository);

        $this->assertEquals(FlashMessage::class, get_class($result));
        $this->assertEquals('alert-danger', $result->type);
    }
}
