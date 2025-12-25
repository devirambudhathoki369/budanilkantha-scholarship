<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class School extends Model
{
    use HasFactory;

    protected $table = 'schools';

    protected $fillable = [
        'emis_no',
        'school_name',
        'address',
        'contact_no',
        'contact_person',
        'email',
        'ward_id',
        'school_type',
    ];

    public function ward()
    {
        return $this->belongsTo(Ward::class);
    }

    public function users()
{
    return $this->hasMany(User::class);
}
}
