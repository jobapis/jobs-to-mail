<?php namespace JobApis\JobsToMail\Tests\Unit\Notifications;

use JobApis\JobsToMail\Http\Middleware\VerifyLogin;
use JobApis\JobsToMail\Tests\TestCase;
use Mockery as m;

class VerifyLoginTest extends TestCase
{
    public function setUp()
    {
        parent::setUp();
        $this->middleware = new VerifyLogin();
    }

    public function testItCanHandleWhenUserLoggedIn()
    {
        $request = m::mock('Illuminate\Http\Request');

        $request->shouldReceive('session')
            ->once()
            ->andReturnSelf();
        $request->shouldReceive('get')
            ->with('user')
            ->once()
            ->andReturn(['id' => uniqid()]);

        $this->assertTrue($this->middleware->handle($request, function() {
            return true;
        }));
    }

    public function testItCanHandleWhenUserNotLoggedIn()
    {
        $request = m::mock('Illuminate\Http\Request');

        $request->shouldReceive('session')
            ->once()
            ->andReturnSelf();
        $request->shouldReceive('get')
            ->with('user')
            ->once()
            ->andReturn(false);

        $response = $this->middleware->handle($request, function() {
            return true;
        });

        $this->assertTrue($response->isRedirect());
    }
}
