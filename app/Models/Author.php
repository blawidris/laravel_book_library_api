<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Author extends Model
{
    use HasFactory;

    protected $fillable = [
        'name', 'dob'
    ];

    protected $casts = ['dob' => 'date'];

    // public function setDobAttribute(): Attribute
    // {
    //     return Attribute::make(set: fn ($attribute) => Carbon::parse($attribute));
    // }
}
