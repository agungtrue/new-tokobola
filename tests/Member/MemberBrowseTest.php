<?php

use App\Models\User;

use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;

class MemberBrowseTest extends TestCase
{
    /** @test **/
    public function myInfo()
    {
        $user = User::where('email', 'memberone@test.test')->first();
        $this->actingAs($user, 'api');

        $response = $this->call('GET', '/member/id/my');
        $this->assertEquals(200, $response->status());
        $result = json_decode($response->getContent());
        if (isset($result->data->records[0])) {
            $this->assertEquals($user->id, $result->data->records[0]->id);
        }
    }

    /** @test **/
    public function spesificUserIdInfo()
    {
        $user = User::where('email', 'memberone@test.test')->first();
        $this->actingAs($user, 'api');

        $response = $this->call('GET', '/member/id/2');
        $this->assertEquals(200, $response->status());
        $result = json_decode($response->getContent());
        if (isset($result->data->records[0])) {
            $this->assertEquals(2, $result->data->records[0]->id);
        }
    }
}
