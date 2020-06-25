<?php

namespace App\Models\Clients;

use App\Models\Systems\System;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use App\Models\Tickets\Ticket;

class Client extends Model
{
    protected $fillable = [
        'name', 'email', 'system_id'
    ];

    protected $table = "clients";

    public function ticket () {
       return $this->belongsTo(Ticket::class);
    }

    public function system () {
        return $this->hasOne(System::class, 'id', 'system_id');
    }
}
