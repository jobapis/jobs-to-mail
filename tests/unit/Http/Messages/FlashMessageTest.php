<?php namespace JobApis\JobsToMail\Tests\Unit\Http\Messages;

use JobApis\JobsToMail\Http\Messages\FlashMessage;
use JobApis\JobsToMail\Tests\TestCase;

class FlashMessageTest extends TestCase
{
    public function setUp()
    {
        parent::setUp();
        $types = [
            'alert-danger',
            'alert-success',
        ];
        $this->type = $this->faker->randomElement($types);
        $this->message = $this->faker->sentence();
    }

    public function testItCanInstantiateFlashMessage()
    {
        $messageObject = new FlashMessage($this->type, $this->message);
        $this->assertEquals($this->type, $messageObject->type);
        $this->assertEquals($this->message, $messageObject->message);
    }

    /**
     * @expectedException \OutOfBoundsException
     */
    public function testItThrowsExceptionWhenInvalidType()
    {
        new FlashMessage(uniqid(), $this->message);
    }
}
