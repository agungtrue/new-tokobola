<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Company extends Model
{
    protected $table = 'companies';

    protected $fillable = [
        'id',
    	'key',
    	'name',
    	'phone_number',
    	'address',
    	'province',
    	'city',
        'updated_at',
        'created_at'
    ];

    public $timestamps = false;
}
