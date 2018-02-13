<?php

use App\Models\User;

use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;

class LoanBrowseTest extends TestCase
{
    /** @test **/
    public function myLoans()
    {
        $user = User::where('email', 'memberone@test.test')->first();
        $this->actingAs($user, 'api');

        $response = $this->call('GET', '/loan/user_id/my');
        $this->assertEquals(200, $response->status());
        $result = json_decode($response->getContent());
        if (isset($result->data->records[0])) {
            $this->assertEquals($user->id, $result->data->records[0]->user_id);
        }
    }

    /** @test **/
    public function spesificUserIdLoans()
    {
        $user = User::where('email', 'memberone@test.test')->first();
        $this->actingAs($user, 'api');

        $response = $this->call('GET', '/loan/user_id/1');
        $this->assertEquals(200, $response->status());
        $result = json_decode($response->getContent());
        if (isset($result->data->records[0])) {
            $this->assertEquals($user->id, $result->data->records[0]->user_id);
        }
    }
}
