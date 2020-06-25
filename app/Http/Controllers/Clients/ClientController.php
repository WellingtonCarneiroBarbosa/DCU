<?php

namespace App\Http\Controllers\Clients;

use App\Http\Controllers\Controller;
use App\Models\Clients\Client;
use Illuminate\Http\Request;

class ClientController extends Controller
{
    public function __construct(Client $client)
    {
        $this->client = $client;
    }

    public function getAllClients ()
    {
        $clients = $this->client->with('system')->paginate(10);

        return view('app.clients.index', [
            'clients' => $clients
        ]);
    }
}
