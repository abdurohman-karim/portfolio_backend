<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Application extends Model
{
    protected $fillable = [
        'name',
        'email',
        'project_title',
        'description',
        'budget',
        'budget_type',
        'deadline',
    ];

    public function files()
    {
        return $this->hasMany(ApplicationFile::class);
    }
}
