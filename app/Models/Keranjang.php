<?php

namespace App\Models;
use App\Models\Produk;
use Illuminate\Database\Eloquent\Model;

class Keranjang extends Model
{
    protected $table = 'keranjang';
    protected $primaryKey = 'keranjang_id';
    public $timestamps = false;

    // protected $fillable = [
    //     'nama_produk', 'harga_produk'
    // ];


    public function member()
    {
        return $this->hasOne(User::class, 'id', 'member_id');
    }

    public function produk()
    {
        return $this->hasOne(Produk::class, 'id', 'produk_id');
    }
}
