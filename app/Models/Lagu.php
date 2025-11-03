<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Lagu extends Model
{
    use HasFactory;
    protected $table = 'lagus';
    protected $guarded = ['id'];

    public function budaya()
    {
        return $this->belongsTo(Budaya::class, 'id_budaya');
    }
}
