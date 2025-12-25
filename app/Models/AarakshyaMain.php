<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AarakshyaMain extends Model
{
    use HasFactory;

    protected $table = 'aarakshya_main';

    protected $fillable = [
        'title',
        'percentage',
    ];
}
