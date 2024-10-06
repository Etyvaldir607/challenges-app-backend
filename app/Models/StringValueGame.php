<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class StringValueGame extends Model
{
    use HasFactory;

    protected $fillable = [
        'string_value',
        'result',
    ];
}
