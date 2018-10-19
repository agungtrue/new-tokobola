<?php

namespace App\Models;
use Illuminate\Database\Eloquent\Model;

class Clubs extends Model
{
    protected $table = 'clubs';
    public $timestamps = false;

    protected $fillable = ['name', 'image', 'id_liga'];

    public function liga()
    {
        return $this->hasMany(Liga::class, 'id', 'id_liga')
        ->with('negara');
    }

}
