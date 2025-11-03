<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Produk extends Model
{
    use HasFactory;
    protected $table = 'produks';
    protected $guarded = ['id'];


    public function penjual()
    {
        return $this->belongsTo(User::class, 'id_penjual');
    }

 
    public function budaya()
    {
        return $this->belongsTo(Budaya::class, 'id_budaya');
    }


    public function keranjangItems()
    {
        return $this->hasMany(Keranjang::class, 'id_produk');
    }
}
