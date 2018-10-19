<?php

namespace App\Models;
// use App\Models\Clubs;
use Illuminate\Database\Eloquent\Model;

use Illuminate\Auth\Authenticatable;
use Laravel\Lumen\Auth\Authorizable;
use Laravel\Passport\HasApiTokens;
use Illuminate\Contracts\Auth\Authenticatable as AuthenticatableContract;
use Illuminate\Contracts\Auth\Access\Authorizable as AuthorizableContract;


class Members extends Model
{
    use HasApiTokens, Authenticatable, Authorizable;

    protected $table = 'member';
    public $timestamps = false;

    protected $fillable = ['nama_lengkap', 'email', 'gender', 'alamat', 'username', 'password', 'no_hp', 'id_club', 'id_club_negara', 'id_liga'];
    // protected $guarded = ['nama_lengkap'];

    // public function Clubs()
    // {
    //     return $this->hasMany(Clubs::class, 'id', 'id_club')
    //     ->with('liga');
    // }

    public function negara_klub() {
      return $this->hasOne(Negara::class, 'id', 'id_club_negara')->select('id', 'name');
    }

    public function liga() {
      return $this->hasOne(Liga::class, 'id', 'id_liga')->select('id', 'name');
    }

    public function club() {
      return $this->hasOne(Clubs::class, 'id', 'id_club')->select('id', 'name');
    }

}
