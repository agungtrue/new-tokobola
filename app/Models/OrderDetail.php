<?php

namespace App\Models;
use App\Models\User;
use App\Models\Produk;
use App\Models\Keranjang;
use App\Models\Order;
use App\Models\KategoriProduk;
use Illuminate\Database\Eloquent\Model;

class OrderDetail extends Model
{
    protected $table = 'order_detail';
    // protected $primaryKey = 'order_id';

    // public $timestamps = false;

    // protected $fillable = [
    //     'nama_produk', 'harga_produk'
    // ];
    public function produk()
    {
        return $this->hasOne(Produk::class, 'id', 'produk_id');
    }
}
