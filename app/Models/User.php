<?php

namespace App\Models;

/**
 * Relation Models
 */


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
    protected $table = 'member';
    public $timestamps = false;
    
    protected $fillable = [
        'nama_lengkap', 'email', 'gender', 'alamat', 'username',
        'password', 'no_hp', 'id_club', 'id_club_negara', 'id_liga'
    ];

    /**
     * The attributes excluded from the model's JSON form.
     *
     * @var array
     */
    protected $hidden = [
        'password',
    ];

    public function negara_klub() {
      return $this->hasOne(Negara::class, 'id', 'id_club_negara')->select('id', 'name');
    }

    public function liga() {
      return $this->hasOne(Liga::class, 'id', 'id_liga')->select('id', 'name');
    }

    public function club() {
      return $this->hasOne(Clubs::class, 'id', 'id_club')->select('id', 'name');
    }


    // public function member()
    // {
    //     return $this->hasOne(Member::class, 'user_id', 'id')
    //     ->with('province')
    //     ->with('city')
    //     ->with('sub_district')
    //     ->with('urban_village')
    //     ->with('idcard_province')
    //     ->with('idcard_city')
    //     ->with('idcard_sub_district')
    //     ->with('idcard_urban_village');
    // }

    // public function memberBank()
    // {
    //     return $this->hasOne(MemberBank::class, 'user_id', 'id');
    // }

    // public function memberCompany()
    // {
    //     return $this->hasOne(MemberCompany::class, 'user_id', 'id')
    //     ->with('company_province')
    //     ->with('company_city')
    //     ->with('company_sub_district')
    //     ->with('company_urban_village');
    // }

    // public function memberFamily()
    // {
    //     return $this->hasOne(MemberFamily::class, 'user_id', 'id')
    //     ->with('family_province')
    //     ->with('family_city')
    //     ->with('family_sub_district')
    //     ->with('family_urban_village');
    // }
}
