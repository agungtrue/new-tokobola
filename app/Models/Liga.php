<?php

namespace App\Models;
use Illuminate\Database\Eloquent\Model;

class Liga extends Model
{
    protected $table = 'liga';
    public $timestamps = false;

    protected $fillable = ['name', 'image', 'id_negara', 'id_club'];

    public function negara()
    {
        return $this->hasOne(Negara::class, 'id', 'id_negara');
    }
}
