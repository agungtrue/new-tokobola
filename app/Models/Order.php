<?php

namespace App\Models;
use App\Models\User;
use App\Models\Produk;
use App\Models\Order;
use App\Models\KategoriProduk;
use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    protected $table = 'orders';
    protected $primaryKey = 'order_id';

    // public $timestamps = false;

    // protected $fillable = [
    //     'nama_produk', 'harga_produk'
    // ];


    // public function member()
    // {
    //     return $this->hasOne(User::class, 'id', 'id_member');
    // }
    //
    public function produk()
    {
        return $this->hasOne(Produk::class, 'id', 'produk_id')->with('member');
    }
}
