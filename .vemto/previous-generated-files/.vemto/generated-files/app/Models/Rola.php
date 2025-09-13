<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Rola extends Model
{
    use HasFactory;

    protected $table = 'rola';

    protected $guarded = [];

    public function users()
    {
        return $this->hasMany(User::class);
    }
}
