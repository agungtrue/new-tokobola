<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class MemberBank extends Model
{
    protected $table = 'member_bank';

    protected $primaryKey = 'user_id';
    protected $fillable = [
        'user_id',
        'bank',
        'bank_branch',
        'bank_account_name',
        'bank_account_number',
        'updated_at'
    ];

    public $timestamps = false;
}
