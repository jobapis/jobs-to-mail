<?php namespace JobApis\JobsToMail\Tests\Unit\Notifications;

use Mockery as m;
use JobApis\JobsToMail\Repositories\UserRepository;
use JobApis\JobsToMail\Tests\TestCase;

class UserRepositoryTest extends TestCase
{
    public function setUp()
    {
        parent::setUp();
        $this->users = m::mock('JobApis\JobsToMail\Models\User');
        $this->tokens = m::mock('JobApis\JobsToMail\Models\Token');
        $this->repository = new UserRepository($this->users, $this->tokens);
    }

    public function testItCanConfirmUserFromToken()
    {
        $token = uniqid();
        $user_id = uniqid();

        $this->tokens->shouldReceive('where')
            ->times(3)
            ->andReturnSelf();
        $this->tokens->shouldReceive('first')
            ->andReturnSelf();
        $this->tokens->shouldReceive('getAttribute')
            ->with('user_id')
            ->once()
            ->andReturn($user_id);
        $this->users->shouldReceive('where')
            ->with('id', $user_id)
            ->once()
            ->andReturnSelf();
        $this->users->shouldReceive('update')
            ->once()
            ->andReturnSelf();

        $this->assertTrue($this->repository->confirm($token));
    }

    public function testItCanConfirmUserWithInvalidToken()
    {
        $token = uniqid();

        $this->tokens->shouldReceive('where')
            ->times(3)
            ->andReturnSelf();
        $this->tokens->shouldReceive('first')
            ->andReturnNull();

        $this->assertFalse($this->repository->confirm($token));
    }

    public function testItCanCreateUserAndToken()
    {
        $data = [
            'email' => $this->faker->email(),
            'keyword' => uniqid(),
            'location' => uniqid(),
        ];
        $user_id = uniqid();

        $this->users->shouldReceive('create')
            ->with($data)
            ->once()
            ->andReturnSelf();
        $this->users->shouldReceive('getAttribute')
            ->with('id')
            ->once()
            ->andReturn($user_id);
        $this->tokens->shouldReceive('create')
            ->with(['user_id' => $user_id, 'type' => 'confirm'])
            ->once()
            ->andReturnSelf();
        $this->users->shouldReceive('notify')
            ->once()
            ->andReturnSelf();

        $result = $this->repository->create($data);

        $this->assertEquals($this->users, $result);
    }

    public function testItCanGetUserById()
    {
        $id = uniqid();

        $this->users->shouldReceive('where')
            ->with('id', $id)
            ->once()
            ->andReturnSelf();
        $this->users->shouldReceive('first')
            ->once()
            ->andReturnSelf();

        $result = $this->repository->getById($id);

        $this->assertEquals($this->users, $result);
    }

    public function testItCanUnsubscribeUser()
    {
        $id = uniqid();
        $this->users->shouldReceive('where')
            ->with('id', $id)
            ->once()
            ->andReturnSelf();
        $this->users->shouldReceive('delete')
            ->once()
            ->andReturn(true);
        $this->assertTrue($this->repository->unsubscribe($id));
    }
}
