<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Member extends Model
{
    protected $table = 'members';

    protected $primaryKey = 'user_id';
    protected $fillable = [
        'user_id',
        'idcard_number',
        'referrer',
        'gender',
        'birth_place',
        'birth_date',
        'religion',
        'citizenship',
        'phone_number',
        'address',
        'province',
        'city',
        'sub_district',
        'urban_village',
        'neighbourhood',
        'hamlet',
        'postal_code',
        'idcard_address',
        'idcard_province',
        'idcard_city',
        'idcard_sub_district',
        'idcard_urban_village',
        'idcard_neighbourhood',
        'idcard_hamlet',
        'idcard_postal_code',
        'house_status',
        'relationship_status',
        'last_education',
        'dependents',
        'kpr_installment',
        'idcard_image',
        'pay_slip_image',
        'profile_image',
        'profession',
        'work_position',
        'work_start_year',
        'work_start_month',
        'monthly_income',
        'monthly_expenses',
        'updated_at'
    ];

    public $timestamps = false;

    public function company()
    {
        return $this->hasOne(Company::class, 'id', 'company_id');
    }

    public function province()
    {
        return $this->hasOne(Administrative\Province::class, 'id', 'province')->select('id', 'name');
    }

    public function city()
    {
        return $this->hasOne(Administrative\Regency::class, 'id', 'city')->select('id', 'name');
    }

    public function sub_district()
    {
        return $this->hasOne(Administrative\District::class, 'id', 'sub_district')->select('id', 'name');
    }

    public function urban_village()
    {
        return $this->hasOne(Administrative\Village::class, 'id', 'urban_village')->select('id', 'name');
    }

    public function idcard_province()
    {
        return $this->hasOne(Administrative\Province::class, 'id', 'idcard_province')->select('id', 'name');
    }

    public function idcard_city()
    {
        return $this->hasOne(Administrative\Regency::class, 'id', 'idcard_city')->select('id', 'name');
    }

    public function idcard_sub_district()
    {
        return $this->hasOne(Administrative\District::class, 'id', 'idcard_sub_district')->select('id', 'name');
    }

    public function idcard_urban_village()
    {
        return $this->hasOne(Administrative\Village::class, 'id', 'idcard_urban_village')->select('id', 'name');
    }
}
