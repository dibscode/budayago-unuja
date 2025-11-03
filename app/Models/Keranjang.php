<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Keranjang extends Model
{
    use HasFactory;
    protected $table = 'keranjangs';
    protected $guarded = ['id'];
    
  
    public function user()
    {
        return $this->belongsTo(User::class, 'id_user');
    }


    public function produk()
    {
        return $this->belongsTo(Produk::class, 'id_produk');
    }
}
