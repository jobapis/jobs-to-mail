<?php namespace JobApis\JobsToMail\Tests\Integration;

use JobApis\JobsToMail\Models\User;
use JobApis\JobsToMail\Tests\TestCase;
use JobApis\JobsToMail\Models\Token;

class TokenModelTest extends TestCase
{
    public function testItGeneratesTokenUponCreation()
    {
        $user_id = User::first()->id;
        $token = Token::create([
            'user_id' => $user_id,
            'type' => uniqid(),
        ]);
        $this->assertNotNull($token->token);
        $this->assertEquals($user_id, $token->user_id);
    }

    public function testItCanGetAssociatedModelToken()
    {
        $token = Token::with('user')->first();
        $this->assertEquals($token->user_id, $token->user->id);
    }

    public function testItCanGenerateTokenFromUserIdAndType()
    {
        $type = uniqid();
        $user_id = User::first()->id;
        $token = new Token();

        $newToken = $token->generate($user_id, $type);

        $this->assertEquals($user_id, $newToken->user_id);
        $this->assertEquals($type, $newToken->type);
    }

    public function testItReturnsTokenValueWhenUsedAsString()
    {
        $token = Token::first();
        $this->assertEquals($token->token, (string) $token);
    }
}
