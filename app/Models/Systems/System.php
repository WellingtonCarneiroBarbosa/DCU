<?php

namespace App\Models\Systems;

use Illuminate\Database\Eloquent\Model;

class System extends Model
{
    protected $fillable = [
        'name', 'token'
    ];

    protected $table = "systems";
}
