<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ChessGame extends Model
{
    use HasFactory;

    protected $fillable = [
        'board_size',
        'total_obstacles',
        'queen_rows',
        'queen_columns',
        'obstacles',
        'attacks',
    ];

    protected $casts = [
        'obstacles' => 'array', // Convierte JSON a array automáticamente
    ];
}
