<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class MemberFamily extends Model
{
    protected $table = 'member_family';

    protected $primaryKey = 'user_id';
    protected $fillable = [
        'user_id',
        'family_name',
        'family_mobile_phone_number',
        'family_phone_number',
        'family_address',
        'family_province',
        'family_city',
        'family_sub_district',
        'family_urban_village',
        'family_neighbourhood',
        'family_hamlet',
        'family_postal_code',
        'updated_at'
    ];

    public $timestamps = false;
}
