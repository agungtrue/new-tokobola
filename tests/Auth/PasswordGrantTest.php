<?php

class PasswordGrantTest extends TestCase
{
    /** @test **/
    public function passwordGrant()
    {
        $this->json('POST', '/oauth/token', [
            'grant_type' => 'password',
            'client_id' => '2',
            'client_secret' => 'JABuBVNUo2h5YPqMfHI4LBsxl0b6Uh2uPfVL004e',
            'username' => 'waldiirawan@gmail.com',
            'password' => 'Password123'
        ])->seeJson([
            'token_type' => 'Bearer',
        ]);
    }
}
