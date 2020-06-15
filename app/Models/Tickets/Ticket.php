<?php

namespace App\Models\Tickets;

use Illuminate\Database\Eloquent\Model;

class Ticket extends Model
{
    protected $fillable = [
        'user_name', 'user_system', 'description',
        'responsible_id', 'demand_id'
    ];

    protected $table = "tickets";
}
