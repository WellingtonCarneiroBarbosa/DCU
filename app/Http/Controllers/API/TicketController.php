<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Tickets\Ticket;
use App\Models\Clients\Client;
use App\Models\Systems\System;
use App\API\ApiResponses;
use App\Models\Tickets\TicketResponseFromSupport;
use App\Models\Tickets\TicketResponseFromClient;

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

    /**
     * Save response from client
     * 
     */
    public function storeClientResponse($ticketID, Request $request)
    {
        try {

            /**
             * Verify if has any ticket opened with
             * this id
             * 
             */
            $ticket = $this->ticket->where('id', $ticketID)->get();

            if(count($ticket) != 1) {
                return response()->json(ApiResponses::responseMessageWithData($ticketID, 'No opened ticket was found with this id', 204));
            }

            $data = $request->all();

            $data['ticket_id'] = $ticketID;

            TicketResponseFromClient::create($data);

            return response()->json(ApiResponses::responseMessage('Ticket response save successfully', 201));

        } catch (\Exception $e) {

            if(config('app.debug')) {
                return response()->json(ApiResponses::responseMessageWithData($data, $e->getMessage(), 500));
            }

            return response()->json(ApiResponses::responseMessageWithData($data, 'Error saving ticket response', 500));
        }
    }

    /**
     * Tickets response from support 
     * 
     */
    public function responsesFromSuport($ticketID)
    {
        try {
            $responsesFromSupport = TicketResponseFromSupport::where('ticket_id', $ticketID)->get();

            if(count($responsesFromSupport) <= 0) 
            {
                return response()->json(ApiResponses::responseMessage('There is No response from support team', 204));
            }

            return response()->json(ApiResponses::responseData($responsesFromSupport, 200));
        } catch (\Exception $e) {

            if(config('app.debug')) {
                return response()->json(ApiResponses::responseMessageWithData($ticketID, $e->getMessage(), 500));
            }

            return response()->json(ApiResponses::responseMessageWithData($ticketID, 'Error getting support team responses for this ticket', 500));   
        
        }
    }

    /**
     * Tickets response from client 
     * 
     */
    public function responsesFromClient($ticketID)
    {
        try {
            $responsesFromClient = TicketResponseFromClient::where('ticket_id', $ticketID)->get();

            if(count($responsesFromClient) <= 0) 
            {
                return response()->json(ApiResponses::responseMessage('There is No response from client', 204));
            }

            return response()->json(ApiResponses::responseData($responsesFromClient, 200));
        } catch (\Exception $e) {

            if(config('app.debug')) {
                return response()->json(ApiResponses::responseMessageWithData($ticketID, $e->getMessage(), 500));
            }

            return response()->json(ApiResponses::responseMessageWithData($ticketID, 'Error getting client responses for this ticket', 500));   
        
        }
    }

    /**
     * Ticket for a client
     * 
     */
    public function clientTickets($clientEmail, Request $request)
    {
        try {

            /**
             * Recupera o ID do sistema do cliente
             * 
             */
            $systemTOKEN = $request->token;

            $system = $this->system->where('token', $systemTOKEN)->take(1)->get();

            foreach($system as $s)
            {
                $systemID = $s->id;
            }

            /***
             * Tenta encontra o cliente
             * 
             */

            $client = $this->client->where('email', $clientEmail)->where('system_id', $systemID)->take(1)->get();

            if(count($client) <= 0) {
                return response()->json(ApiResponses::responseMessageWithData($clientEmail, 'No cliente was found with this email', 204));
            }

            /**
             * Get ID of this client
             * 
             */
            foreach($client as $c) 
            {
                $clientID = $c->id;
            } 

            /**
             * Get tickets
             * 
             */
            $tickets = Ticket::withTrashed()->where('client_id', $clientID)->get();

            if(count($tickets) <= 0) 
            {
                return response()->json(ApiResponses::responseMessage('This client has No ticket', 204));
            }

            return response()->json(ApiResponses::responseData($tickets, 200));

        } catch(\Exception $e) {

            if(config('app.debug')) {
                return response()->json(ApiResponses::responseMessageWithData($clientEmail, $e->getMessage(), 500));
            }

            return response()->json(ApiResponses::responseMessageWithData($clientEmail, 'Error getting tickets of this client', 500));   
        
        }
    }

    /**
     * Close a ticket
     * 
     */
    public function closeTicket($ticketID) 
    {
        try {
            $this->ticket->destroy($ticketID);
        } catch (\Exception $e) {

            if(config('app.debug')) {
                return response()->json(ApiResponses::responseMessageWithData($ticketID, $e->getMessage(), 500));
            }

            return response()->json(ApiResponses::responseMessageWithData($ticketID, 'Error closing ticket', 500));   
        
        }
    }

    public function showTicket($clientEmail, $ticketID, Request $request)
    {
        try {

            /**
             * Recupera o ID do sistema do cliente
             * 
             */
            $systemTOKEN = $request->token;

            $system = $this->system->where('token', $systemTOKEN)->take(1)->get();

            foreach($system as $s)
            {
                $systemID = $s->id;
            }

            /***
             * Tenta encontra o cliente
             * 
             */

            $client = $this->client->where('email', $clientEmail)->where('system_id', $systemID)->take(1)->get();

            if(count($client) <= 0) {
                return response()->json(ApiResponses::responseMessageWithData($clientEmail, 'No cliente was found with this email', 204));
            }

            /**
             * Get ID of this client
             * 
             */
            foreach($client as $c) 
            {
                $clientID = $c->id;
            } 

            /**
             * Get ticket
             * 
             */
            $ticket = Ticket::withTrashed()->where('id', $ticketID)->where('client_id', $clientID)->take(1)->get();

            if(count($ticket) != 1) 
            {
                return response()->json(ApiResponses::responseMessage('This client has No ticket', 204));
            }

            /**
             * Get support responses for 
             * this ticket
             * 
             */
            $responsesFromSupport = TicketResponseFromSupport::where('ticket_id', $ticketID)->get();



             /**
              * Get client responses 
              * for this ticket
              *
              */
            $responsesFromClient = TicketResponseFromClient::where('ticket_id', $ticketID)->get();

            $response = [
                'ticket' => $ticket,
                'responsesFromSupport' => $responsesFromSupport,
                'responsesFromClient' => $responsesFromClient,
            ];

            return response()->json(ApiResponses::responseData($response, 200));

        } catch(\Exception $e) {

            if(config('app.debug')) {
                return response()->json(ApiResponses::responseMessageWithData($request->all(), $e->getMessage(), 500));
            }

            return response()->json(ApiResponses::responseMessageWithData($request->all(), 'Error geting ticket informations', 500));  

        }
    }
}
