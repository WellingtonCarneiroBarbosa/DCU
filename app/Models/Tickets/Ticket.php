<?php

namespace App\Models\Tickets;

use App\Models\Demands\Demand;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Models\Clients\Client;

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

    public function client () {
        return $this->hasOne(Client::class, 'id', 'client_id');
    }

    public function demand () {
        return $this->hasOne(Demand::class, 'id', 'demand_id');
    }
}
