<?php

namespace App\Models;

/**
 * Relation Models
 */

use App\Models\Member;
use App\Models\MemberBank;
use App\Models\MemberCompany;
use App\Models\MemberFamily;

use Illuminate\Auth\Authenticatable;
use Laravel\Lumen\Auth\Authorizable;
use Laravel\Passport\HasApiTokens;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Contracts\Auth\Authenticatable as AuthenticatableContract;
use Illuminate\Contracts\Auth\Access\Authorizable as AuthorizableContract;

class User extends Model implements AuthenticatableContract, AuthorizableContract
{
    use HasApiTokens, Authenticatable, Authorizable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email',
    ];

    /**
     * The attributes excluded from the model's JSON form.
     *
     * @var array
     */
    protected $hidden = [
        'password',
    ];

    public function member()
    {
        return $this->hasOne(Member::class, 'user_id', 'id');
    }

    public function memberBank()
    {
        return $this->hasOne(MemberBank::class, 'user_id', 'id');
    }

    public function memberCompany()
    {
        return $this->hasOne(MemberCompany::class, 'user_id', 'id');
    }

    public function memberFamily()
    {
        return $this->hasOne(MemberFamily::class, 'user_id', 'id');
    }
}
