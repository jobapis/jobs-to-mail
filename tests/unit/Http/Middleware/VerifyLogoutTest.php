<?php namespace JobApis\JobsToMail\Tests\Unit\Notifications;

use JobApis\JobsToMail\Http\Middleware\VerifyLogout;
use JobApis\JobsToMail\Tests\TestCase;
use Mockery as m;

class VerifyLogoutTest extends TestCase
{
    public function setUp()
    {
        parent::setUp();
        $this->middleware = new VerifyLogout();
    }

    public function testItCanHandleWhenUserLoggedOut()
    {
        $request = m::mock('Illuminate\Http\Request');

        $request->shouldReceive('session')
            ->once()
            ->andReturnSelf();
        $request->shouldReceive('get')
            ->with('user')
            ->once()
            ->andReturn(false);

        $this->assertTrue($this->middleware->handle($request, function() {
            return true;
        }));
    }

    public function testItCanHandleWhenUserNotLoggedOut()
    {
        $request = m::mock('Illuminate\Http\Request');

        $request->shouldReceive('session')
            ->once()
            ->andReturnSelf();
        $request->shouldReceive('get')
            ->with('user')
            ->once()
            ->andReturn(['id' => uniqid()]);

        $response = $this->middleware->handle($request, function() {
            return true;
        });

        $this->assertTrue($response->isRedirect());
    }
}
