<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class MemberCompany extends Model
{
    protected $table = 'member_company';

    protected $primaryKey = 'user_id';
    protected $fillable = [
        'user_id',
        'company_name',
        'company_phone_number',
        'company_address',
        'company_province',
        'company_city',
        'company_sub_district',
        'company_urban_village',
        'company_neighbourhood',
        'company_hamlet',
        'company_postal_code',
        'updated_at'
    ];

    public $timestamps = false;
}
