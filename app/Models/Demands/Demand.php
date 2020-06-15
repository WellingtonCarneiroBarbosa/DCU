<?php

namespace App\Models\Demands;

use Illuminate\Database\Eloquent\Model;

class Demand extends Model
{
    protected $fillable = [
        'demand', 'description', 'priority'
    ];

    protected $table = "demands";
}
