<?php

use App\Models\OauthClient;

class PasswordGrantTest extends TestCase
{
    /** @test **/
    public function passwordGrant()
    {
        $OauthClient = OauthClient::where('password_client', '1')->first();
        $this->assertNotNull($OauthClient);
        $this->json('POST', '/oauth/token', [
            'grant_type' => 'password',
            'client_id' => $OauthClient->id,
            'client_secret' => $OauthClient->secret,
            'username' => 'memberone@test.test',
            'password' => 'Testing123'
        ])->seeJson([
            'token_type' => 'Bearer',
        ]);
    }
}
