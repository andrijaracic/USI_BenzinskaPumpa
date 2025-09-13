<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Transakcija extends Model
{
    use HasFactory;

    protected $table = 'transakcija';

    protected $guarded = [];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function stavkaTransakcijas()
    {
        return $this->hasMany(StavkaTransakcija::class);
    }
}
