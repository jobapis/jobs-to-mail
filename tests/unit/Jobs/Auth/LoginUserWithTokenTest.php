<?php namespace JobApis\JobsToMail\Tests\Unit\Jobs\Auth;

use JobApis\JobsToMail\Http\Messages\FlashMessage;
use JobApis\JobsToMail\Jobs\Auth\LoginUserWithToken;
use JobApis\JobsToMail\Tests\TestCase;
use Mockery as m;

class LoginUserWithTokenTest extends TestCase
{
    public function setUp()
    {
        parent::setUp();
        $this->token = uniqid();
        $this->request = m::mock('Illuminate\Http\Request');
        $this->repository = m::mock('JobApis\JobsToMail\Repositories\Contracts\UserRepositoryInterface');
        $this->job = new LoginUserWithToken($this->token);
    }

    public function testItCanHandleIfUserNotYetConfirmed()
    {
        $user = m::mock('JobApis\JobsToMail\Models\User');
        $token = m::mock('JobApis\JobsToMail\Models\Token');
        $session = m::mock('Symfony\Component\HttpFoundation\Session\Session');

        $this->repository->shouldReceive('getToken')
            ->with($this->token, 7)
            ->once()
            ->andReturn($token);
        $this->request->shouldReceive('session')
            ->twice()
            ->andReturn($session);
        $session->shouldReceive('invalidate')
            ->once()
            ->andReturnSelf();
        $token->shouldReceive('getAttribute')
            ->with('user')
            ->andReturn($user);
        $user->shouldReceive('toArray')
            ->andReturn([]);
        $session->shouldReceive('put')
            ->once()
            ->andReturnSelf();
        $token->shouldReceive('delete')
            ->andReturn(true);
        $this->repository->shouldReceive('confirm')
            ->with($user)
            ->once()
            ->andReturn(true);

        $result = $this->job->handle($this->repository, $this->request);

        $this->assertEquals(FlashMessage::class, get_class($result));
        $this->assertEquals('alert-success', $result->type);
    }

    public function testItCanHandleIfUserAlreadyConfirmed()
    {
        $user = m::mock('JobApis\JobsToMail\Models\User');
        $token = m::mock('JobApis\JobsToMail\Models\Token');
        $session = m::mock('Symfony\Component\HttpFoundation\Session\Session');

        $this->repository->shouldReceive('getToken')
            ->with($this->token, 7)
            ->once()
            ->andReturn($token);
        $this->request->shouldReceive('session')
            ->twice()
            ->andReturn($session);
        $session->shouldReceive('invalidate')
            ->once()
            ->andReturnSelf();
        $token->shouldReceive('getAttribute')
            ->with('user')
            ->andReturn($user);
        $user->shouldReceive('toArray')
            ->andReturn([]);
        $session->shouldReceive('put')
            ->once()
            ->andReturnSelf();
        $token->shouldReceive('delete')
            ->andReturn(true);
        $this->repository->shouldReceive('confirm')
            ->with($user)
            ->once()
            ->andReturn(false);

        $result = $this->job->handle($this->repository, $this->request);

        $this->assertEquals(FlashMessage::class, get_class($result));
        $this->assertEquals('alert-success', $result->type);
    }

    public function testItCanHandleIfTokenInvalid()
    {
        $this->repository = m::mock('JobApis\JobsToMail\Repositories\Contracts\UserRepositoryInterface');

        $this->repository->shouldReceive('getToken')
            ->with($this->token, 7)
            ->once()
            ->andReturn(null);

        $result = $this->job->handle($this->repository, $this->request);

        $this->assertEquals(FlashMessage::class, get_class($result));
        $this->assertEquals('alert-danger', $result->type);
    }
}
