<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class StavkaTransakcija extends Model
{
    use HasFactory;

    protected $table = 'stavka_transakcija';

    protected $guarded = [];

    public function transakcija()
    {
        return $this->belongsTo(Transakcija::class);
    }

    public function proizvod()
    {
        return $this->belongsTo(Proizvod::class);
    }
}
