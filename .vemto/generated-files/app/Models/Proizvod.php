<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Proizvod extends Model
{
    use HasFactory;

    protected $table = 'proizvod';

    protected $guarded = [];

    public function stavkaTransakcijas()
    {
        return $this->hasMany(StavkaTransakcija::class);
    }
}
