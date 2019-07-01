<?php

namespace App\Models;
use App\Models\User;
use App\Models\Produk;
use App\Models\Keranjang;
use App\Models\OrderDetail;
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
    // public function keranjang()
    // {
    //     return $this->hasOne(Keranjang::class, 'keranjang_id', 'keranjang_id')->with('produk');
    // }

    public function orderdetail()
    {
        return $this->hasMany(OrderDetail::class, 'order_id', 'order_id')->with('produk');
    }

    public function member()
    {
        return $this->hasOne(User::class, 'id', 'member_id');
    }
}
