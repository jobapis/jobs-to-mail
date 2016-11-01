<?php namespace JobApis\JobsToMail\Tests\Unit\Jobs\Auth;

use JobApis\JobsToMail\Http\Messages\FlashMessage;
use JobApis\JobsToMail\Jobs\Auth\SendLoginMessage;
use JobApis\JobsToMail\Tests\TestCase;
use Mockery as m;

class SendLoginMessageTest extends TestCase
{
    public function setUp()
    {
        parent::setUp();
        $this->email = uniqid();
        $this->repository = m::mock('JobApis\JobsToMail\Repositories\Contracts\UserRepositoryInterface');
        $this->job = new SendLoginMessage($this->email);
    }

    public function testItCanHandle()
    {
        $user = m::mock('JobApis\JobsToMail\Models\User');
        $token = m::mock('JobApis\JobsToMail\Models\Token');
        $id = uniqid();

        $this->repository->shouldReceive('getByEmail')
            ->with($this->email)
            ->once()
            ->andReturn($user);
        $user->shouldReceive('getAttribute')
            ->with('id')
            ->once()
            ->andReturn($id);
        $this->repository->shouldReceive('generateToken')
            ->with($id, 'login')
            ->once()
            ->andReturn($token);
        $user->shouldReceive('notify')
            ->once()
            ->andReturnSelf();

        $result = $this->job->handle($this->repository);

        $this->assertEquals(FlashMessage::class, get_class($result));
        $this->assertEquals('alert-success', $result->type);
    }
}
