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
}
