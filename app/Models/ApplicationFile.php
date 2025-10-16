<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ApplicationFile extends Model
{
    protected $fillable = [
        'application_id',
        'file',
        'type',
    ];

    public function application()
    {
        return $this->belongsTo(Application::class);
    }
}
