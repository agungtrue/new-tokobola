<?php

namespace App\Models;
use App\Models\User;
use App\Models\KategoriProduk;
use App\Models\Clubs;
use Illuminate\Database\Eloquent\Model;

class Produk extends Model
{
    protected $table = 'produk';
    public $timestamps = false;

    // protected $fillable = [
    //     'nama_produk', 'harga_produk'
    // ];


    public function penjual()
    {
        return $this->hasOne(User::class, 'id', 'id_member');
    }

    public function kategori_produk()
    {
        return $this->hasOne(KategoriProduk::class, 'id', 'id_kategori_produk');
    }

    public function club()
    {
        return $this->hasOne(Clubs::class, 'id', 'id_club');
    }
}
