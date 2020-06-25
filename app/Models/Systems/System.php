<?php

namespace App\Models\Systems;

use App\Models\Clients\Client;
use Illuminate\Database\Eloquent\Model;

class System extends Model
{
    protected $fillable = [
        'name', 'token'
    ];

    protected $table = "systems";

    public function client () {
        return $this->belongsTo(Client::class);
    }
}
