<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Loan extends Model
{
    protected $table = 'loans';

    public function user()
    {
        return $this->hasOne(User::class, 'id', 'user_id');
    }
}
