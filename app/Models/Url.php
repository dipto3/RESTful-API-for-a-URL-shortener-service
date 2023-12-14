<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Url extends Model
{
    use HasFactory;
    protected $fillable = [
        'long_url',
        'shortened_url_code',
        'user_id',
        'total_visit',
    ];
}
