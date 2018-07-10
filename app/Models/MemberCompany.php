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

    public function company_province()
    {
        return $this->hasOne(Administrative\Province::class, 'id', 'company_province')->select('id', 'name');
    }

    public function company_city()
    {
        return $this->hasOne(Administrative\Regency::class, 'id', 'company_city')->select('id', 'name');
    }

    public function company_sub_district()
    {
        return $this->hasOne(Administrative\District::class, 'id', 'company_sub_district')->select('id', 'name');
    }

    public function company_urban_village()
    {
        return $this->hasOne(Administrative\Village::class, 'id', 'company_urban_village')->select('id', 'name');
    }
}
