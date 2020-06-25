<?php

namespace App\Models\Demands;

use App\Models\Tickets\Ticket;
use Illuminate\Database\Eloquent\Model;

class Demand extends Model
{
    protected $fillable = [
        'demand', 'description', 'priority'
    ];

    protected $table = "demands";

    public function ticket () {
        return $this->belongsTo(Ticket::class);
    }
}
