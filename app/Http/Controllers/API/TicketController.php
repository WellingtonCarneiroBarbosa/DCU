<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Tickets\Ticket;
use App\Models\Clients\Client;
use App\Models\Systems\System;
use App\API\ApiResponses;

class TicketController extends Controller
{
    /**
     * @model Ticket
     * 
     * @param \App\Models\Tickets\Ticket
     */
    private $ticket, $client, $system;

    public function __construct(Ticket $ticket, Client $client, System $system)
    {
        $this->ticket = $ticket;
        $this->client = $client;
        $this->system = $system;
    }

    public function index()
    {
        try {

            return response()->json(ApiResponses::responseData($this->ticket->paginate(5), 200));

        } catch (\Exception $e) {

            if(config('app.debug')) {
                return response()->json(ApiResponses::responseMessage($e->getMessage(), 500));
            }

            return response()->json(ApiResponses::responseMessage('Error listing ticket', 500));

        }
    }

    public function store(Request $request)
    {
        try {

            /**
             * Quando a api receber a solicitação,
             * ela verificará se o usuário que está
             * realizando o pedido já está cadastrado. 
             * 
             * Se sim, ela prossegue e abre o ticket para este usuário.
             * 
             * Se não, cadastra o usuário e então, prossegue e abre o ticket
             * 
             */

            $data = $request->all();

            if(! $data['name']) {
                return response()->json(ApiResponses::responseMessageWithData($data, 'The user name was not found!', 403));
            }

            if(! $data['email']) {
                return response()->json(ApiResponses::responseMessageWithData($data, 'The user email was not found!', 403));
            }

            /**
             * Tenta encontrar o cliente pelo email
             * 
             */
            $client = $this->client->where('email', $data['email'])->take(1)->get();

            /**
             * Se nao encontrar, cadastra
             */
            if(count($client) != 1) 
            {
                try {

                    /**
                     * Recupera os dados do sistema pelo token
                     * 
                     */
                    $system = $this->system->where('token', $data['token'])->take(1)->get();

                    foreach($system as $s) {
                        $system_id = $s->id;
                    }

                    $dataClient = [
                        'name' => $data['name'],
                        'email' => $data['email'],
                        'system_id' => $system_id,
                    ];

                    $client = $this->client->create($dataClient);

                    $clientID = $client->id;
                
                } catch(\Exception $e) {
                    if(config('app.debug')) {
                        return response()->json(ApiResponses::responseMessageWithData($client, $e->getMessage(), 500));
                    }
        
                    return response()->json(ApiResponses::responseMessageWithData($client, 'Error registering client', 500));
                }
            }else {
                /**
                 * Pega o id do cliente
                 * encontrado
                 * 
                 */
                foreach($client as $c) {
                    $clientID = $c->id;
                }
            }

            $dataTicket = [
                'demand_id' => $data['demand_id'],
                'client_id' => $clientID,
                'message' => $data['message'],
            ];

            $this->ticket->create($dataTicket);
            
            return response()->json(ApiResponses::responseMessage('Ticket opened successfully', 201));

        } catch (\Exception $e) {

            if(config('app.debug')) {
                return response()->json(ApiResponses::responseMessageWithData($data, $e->getMessage(), 500));
            }

            return response()->json(ApiResponses::responseMessageWithData($data, 'Error saving ticket', 500));
        }
    }
}
