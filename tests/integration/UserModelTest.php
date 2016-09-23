<?php namespace JobApis\JobsToMail\Tests\Integration;

use JobApis\JobsToMail\Tests\TestCase;
use JobApis\JobsToMail\Models\User;

class UserModelTest extends TestCase
{
    /**
     * A basic functional test example.
     *
     * @return void
     */
    public function testItGeneratesUuidUponCreation()
    {
        $email = $this->faker->email();
        $user = User::create([
            'email' => $email,
            'keyword' => uniqid(),
            'location' => uniqid(),
        ]);
        $this->assertNotNull($user->id);
        $this->assertEquals($email, $user->email);
    }
}
