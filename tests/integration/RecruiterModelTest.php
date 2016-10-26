<?php namespace JobApis\JobsToMail\Tests\Integration;

use JobApis\JobsToMail\Models\Recruiter;
use JobApis\JobsToMail\Tests\TestCase;

class RecruiterModelTest extends TestCase
{
    public function testItGeneratesIdUponCreation()
    {
        $name = $this->faker->word();
        $recruiter = Recruiter::create([
            'name' => $name,
        ]);
        $this->assertNotNull($recruiter->id);
        $this->assertEquals($name, $recruiter->name);
    }

    public function testItCanFilterByName()
    {
        $name = $this->faker->randomElement(Recruiter::get()->toArray())['name'];
        $recruiter = Recruiter::whereNameLike($name)->first();

        $this->assertEquals($name, $recruiter->name);
    }
}
