<?php namespace JobApis\JobsToMail\Tests\Unit\Notifications;

use JobApis\JobsToMail\Http\Middleware\UpdateSessionUser;
use JobApis\JobsToMail\Tests\TestCase;
use Mockery as m;

class UpdateSessionUserTest extends TestCase
{
    public function setUp()
    {
        parent::setUp();
        $this->repository = m::mock('JobApis\JobsToMail\Repositories\Contracts\UserRepositoryInterface');
        $this->middleware = new UpdateSessionUser($this->repository);
    }

    public function testItCanHandleWhenUserLoggedIn()
    {
        $id = uniqid();
        $request = m::mock('Illuminate\Http\Request');

        $request->shouldReceive('session')
            ->twice()
            ->andReturnSelf();
        $request->shouldReceive('get')
            ->with('user.id')
            ->once()
            ->andReturn($id);
        $this->repository->shouldReceive('getById')
            ->with($id)
            ->once()
            ->andReturnSelf();
        $request->shouldReceive('put')
            ->with('user', $this->repository)
            ->once()
            ->andReturnSelf();

        $this->assertTrue($this->middleware->handle($request, function() {
            return true;
        }));
    }

    public function testItCanHandleWhenUserNotLoggedIn()
    {
        $id = uniqid();
        $request = m::mock('Illuminate\Http\Request');
        $user = m::mock('JobApis\JobsToMail\Models\User');

        $request->shouldReceive('session')
            ->once()
            ->andReturnSelf();
        $request->shouldReceive('get')
            ->with('user.id')
            ->once()
            ->andReturn(null);

        $this->assertTrue($this->middleware->handle($request, function() {
            return true;
        }));
    }
}
