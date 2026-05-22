<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Promotion extends Model
{
    protected $fillable = [
        'title', 'slug', 'description', 
        'discount_percent', 'image_path', 'start_date', 'end_date'
    ];

    protected $casts = [
        'discount_percent' => 'integer',
        'start_date' => 'date',
        'end_date' => 'date',
    ];
}
