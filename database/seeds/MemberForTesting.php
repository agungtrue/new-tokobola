<?php

use App\Models\User;
use App\Models\Member;
use App\Models\MemberBank;
use App\Models\MemberFamily;
use App\Models\MemberCompany;
use Illuminate\Database\Seeder;

class MemberForTesting extends Seeder
{
    protected $emails = [
        'memberone@test.test',
        'membertwo@test.test',
        'memberthree@test.test',
    ];

    protected $password = 'Testing123';
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $Users = User::whereIn('email', $this->emails)->get();
        if ($Users->count() < 1) {
            foreach ($this->emails as $email) {
                $this->createMemberAccount($email);
            }
        }
    }

    public function createMemberAccount($email) {
        $User = new User();
        $User->name = $email;
        $User->email = $email;
        $User->password = app('hash')->make($this->password);
        $User->mobile_phone_number = '088889181818';
        $User->save();

        $Member = new Member();
        $Member->idcard_number = '11111111111';
        $Member->user_id = $User->id;
        $Member->save();

        $MemberBank = new MemberBank();
        $MemberBank->user_id = $User->id;
        $MemberBank->save();

        $MemberFamily = new MemberFamily();
        $MemberFamily->user_id = $User->id;
        $MemberFamily->save();

        $MemberCompany = new MemberCompany();
        $MemberCompany->user_id = $User->id;
        $MemberCompany->save();
    }
}
