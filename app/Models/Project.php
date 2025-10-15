<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Project extends Model
{
    protected $fillable = [
        'title',
        'link',
        'image'
    ];

    public function getImageAttribute($value)
    {
        return asset('storage/' . $value);
    }
}
