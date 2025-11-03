<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Budaya extends Model
{
    use HasFactory;

    protected $table = 'budayas';
    
    protected $guarded = ['id'];

    public function segments()
    {
        return $this->hasMany(Segment::class, 'id_budaya');
    }

    public function arsips()
    {
        return $this->hasMany(Arsip::class, 'id_budaya');
    }

    public function lagus()
    {
        return $this->hasMany(Lagu::class, 'id_budaya');
    }

    public function produks()
    {
        return $this->hasMany(Produk::class, 'id_budaya');
    }
}