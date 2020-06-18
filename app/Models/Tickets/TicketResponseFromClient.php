<?php

namespace App\Models\Tickets;

use Illuminate\Database\Eloquent\Model;

class TicketResponseFromClient extends Model
{
    protected $fillable = ['ticket_id', 'message'];

    protected $table = "ticket_responses_from_client";
}
