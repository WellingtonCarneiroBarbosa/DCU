<?php

namespace App\Models\Tickets;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Ticket extends Model
{
    use SoftDeletes;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'demand_id', 'client_id', 'user_id',
        'message'
    ];

    protected $table = "tickets";

    protected $softDeletes = true;
}
