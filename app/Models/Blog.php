<?php

namespace App\Models;
use App\Models\User;
use Illuminate\Database\Eloquent\Model;

class Blog extends Model
{
    protected $table = 'blog';

    // protected $fillable = [
    //     'nama_produk', 'harga_produk'
    // ];

    public function member()
    {
        return $this->hasOne(User::class, 'id', 'member_id');
    }


}
