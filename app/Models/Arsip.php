<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Arsip extends Model
{
    use HasFactory;
    protected $table = 'arsips';
    protected $guarded = ['id'];

    public function budaya()
    {
        return $this->belongsTo(Budaya::class, 'id_budaya');
    }
}