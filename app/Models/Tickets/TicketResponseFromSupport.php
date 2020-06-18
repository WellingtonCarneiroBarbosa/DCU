<?php

namespace App\Models\Tickets;

use Illuminate\Database\Eloquent\Model;

class TicketResponseFromSupport extends Model
{
    protected $fillable = ['ticket_id', 'message'];

    protected $table = "ticket_responses_from_support";
}
