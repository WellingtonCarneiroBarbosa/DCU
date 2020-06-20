<?php

namespace App\Models\Tickets;

use Illuminate\Database\Eloquent\Model;

class TicketResponse extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'ticket_id', 'client_id',
        'responsible_id', 'message'
    ];

    protected $table = "ticket_responses";
}
