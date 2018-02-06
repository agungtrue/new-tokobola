<?php

namespace App\Console\Commands;

use App\Models\OauthClient;
use App\Models\OauthPersonalAccessClient;

use App\User;
use Illuminate\Console\Command;

class PassportSync extends Command
{
    protected $signature = 'passport:sync';

    public function handle()
    {
        if (OauthClient::all()->count() < 2) {
            $this->call('passport:install');
        }
    }
}
