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
        $this->tokens->shouldReceive('generate')
            ->with($user_id, 'confirm')
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
}
