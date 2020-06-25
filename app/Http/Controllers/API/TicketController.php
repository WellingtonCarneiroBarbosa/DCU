<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\Tickets\TicketResponse;
use Illuminate\Http\Request;
use App\Models\Tickets\Ticket;
use App\Models\Clients\Client;
use App\Models\Systems\System;
use App\API\ApiResponses;

/**
 * Class TicketController
 * @package App\Http\Controllers\API
 *
 */
class TicketController extends Controller
{
    /**
     * Returns data from a
     * specific client
     *
     * @param $client_email
     * @param $system_id
     * @return bool|array
     *
     */
    static function getClientByEmail($client_email, $system_id)
    {
        try {
            $client = Client::where('email', $client_email)->where('system_id', $system_id)->take(1)->get();

            if(count($client) != 1) {
                return false;
            }

            foreach($client as $c)
            {
                $client_id = $c->id;
            }

            return $client_id;
        } catch (\Exception $exception) {
            if(config('app.debug')) {
                return $exception->getMessage();
            }

            return false;
        }
    }

    /**
     * Returns system ID by providing
     * the system token identifier
     *
     * @param $token
     * @return bool|string
     */
    static function getSystemIDBySystemTokenIdentifier($token)
    {
        try {
            $system = System::where('token', $token)->take(1)->get();

            if(! $system) {
                return false;
            }

            foreach($system as $s)
            {
                $system_id = $s->id;
            }

            return $system_id;
        } catch (\Exception $exception) {

            if(config('app.debug')) {
                return $exception->getMessage();
            }

            return false;
        }
    }

    /**
     * @param $ticket_id
     * @return bool|string
     */
    static function getOpenedTicketByID($ticket_id)
    {
        try {
            $ticket = Ticket::find($ticket_id);

            if(! $ticket) {
                return false;
            }

            return $ticket;
        } catch (\Exception $exception) {
            if(config('app.debug')) {
                return $exception->getMessage();
            }

            return false;
        }
    }


    /**
     * Returns all tickets for a client from
     * specific system
     *
     * @param $client_email
     * @param Request $request
     * @param Ticket $ticket
     * @return array|\Illuminate\Http\JsonResponse
     */
    public function getClientTickets($client_email, Request $request, Ticket $ticket)
    {
        try {

            $system_id = $this->getSystemIDBySystemTokenIdentifier($request['token']);

            $client_id = $this->getClientByEmail($client_email, $system_id);

            if(! $client_id) {
                 return response()->json(ApiResponses::responseMessageWithData($client_email, 'No client found with this email and system token', 204));
            }

            $tickets = $ticket->withTrashed()->where('client_id', $client_id)->get();

            if(count($tickets) <= 0 ) {
                return response()->json(ApiResponses::responseMessage('No tickets found', 204));
            }

            return ApiResponses::responseMessageWithData($tickets, 'Tickets get successfully', 200);
        } catch (\Exception $e) {
            if(config('app.debug')) {
                return response()->json(ApiResponses::responseMessage($e->getMessage(), 500));
            }

            return response()->json(ApiResponses::responseMessage('Error getting client tickets', 500));
        }
    }

    /**
     * Open a ticket.
     *
     * Parameters [
     *  Client => name, email, message,
     *  Demand => demand_id
     * ]
     *
     * @param Request $request
     * @param Client $client
     * @param Ticket $ticket
     * @return array|\Illuminate\Http\JsonResponse
     */
    public function openTicket(Request $request, Client $client, Ticket $ticket)
    {
        try {
            $required_parameters = ['name', 'email', 'message', 'demand_id'];

            foreach ($required_parameters as $required_parameter)
            {
                if (! $request[$required_parameter]) {
                    return response()->json(ApiResponses::responseMessageWithData($request->all(),'Missing required parameters. Your request must have: name, email, message, demand_id', 500));
                }
            }

            $system_id = $this->getSystemIDBySystemTokenIdentifier($request['token']);

            $client_id = $this->getClientByEmail($request['email'], $system_id);

            /**
             * Create client in database
             *
             */
            if(! $client_id) {
                try {
                    $client_id = $client->create([
                        'name' => $request['name'],
                        'email' => $request['email'],
                        'system_id' => $system_id,
                    ])->id;
                } catch (\Exception $e) {
                    if(config('app.debug')) {
                        return ApiResponses::responseMessage($e->getMessage(), 500);
                    }

                    return ApiResponses::responseMessage('Error saving client in database', 500);
                }
            }

            $ticket->create([
                'demand_id' => $request['demand_id'],
                'client_id' => $client_id,
                'message' => $request['message'],
            ]);

            return response()->json(ApiResponses::responseMessage('Ticket opened successfully', 201));
        } catch (\Exception $e) {
            if(config('app.debug')) {
                return response()->json(ApiResponses::responseMessageWithData($request->all(), $e->getMessage(), 500));
            }

            return response()->json(ApiResponses::responseMessageWithData($request->all(), 'Error opening ticket', 500));
        }
    }

    /**
     * Close a ticket
     *
     * @param $ticket_id
     * @param Ticket $ticket
     * @return \Illuminate\Http\JsonResponse
     */
    public  function  closeTicket($ticket_id, Ticket $ticket) {
        try {
            $ticket_to_close = $this->getOpenedTicketByID($ticket_id);

            if(! $ticket_to_close) {
                return response()->json(ApiResponses::responseMessageWithData($ticket_id, 'This ticket is already closed or does not exist', 500));
            }

            $ticket->destroy($ticket_id);

            return response()->json(ApiResponses::responseMessage('Ticket closed successfully', 200));
        } catch (Exception $exception) {
            if(config('app.debug')) {
                return response()->json(ApiResponses::responseMessageWithData($ticket_id, $exception->getMessage(), 500));
            }

            return response()->json(ApiResponses::responseMessageWithData($ticket_id, 'Error closing ticket', 500));
        }
    }

    /**
     * Returns infos and responses of a ticket
     * by providing ticket id
     *
     * @param $ticket_id
     * @param Ticket $ticket
     * @param TicketResponse $ticketResponse
     * @return \Illuminate\Http\JsonResponse
     */
    public function getAllTicketInfos($ticket_id, Ticket $ticket, TicketResponse $ticketResponse)
    {
        try {
            $ticket_infos = $ticket->withTrashed()->with('client')->with('demand')->find($ticket_id);

            if(! $ticket_infos) {
                return response()->json(ApiResponses::responseMessage('This ticket does not exist', 404));
            }

            $ticket_responses = $ticketResponse->latest()->where('ticket_id', $ticket_id)->get();

            $response_data = ['ticket_infos' => $ticket_infos, 'ticket_responses' => $ticket_responses];

            return response()->json(ApiResponses::responseData($response_data, 200));
        } catch (\Exception $exception) {
            if(config('app.debug')) {
                return response()->json(ApiResponses::responseMessageWithData($ticket_id, $exception->getMessage(), 500));
            }

            return response()->json(ApiResponses::responseMessageWithData($ticket_id, 'Error getting ticket infos', 500));
        }
    }

    /**
     * Save a client response
     * in database
     *
     * Parameters = [
     *  ticket_id, client_id, responsible_id, message
     * ]
     *
     * @param Request $request
     * @param TicketResponse $ticketResponse
     * @return \Illuminate\Http\JsonResponse
     */
    public function  storeClientResponse(Request $request, TicketResponse $ticketResponse)
    {
        try {
            $required_parameters = ['ticket_id', 'message'];

            foreach ($required_parameters as $required_parameter)
            {
                if (! $request[$required_parameter]) {
                    return response()->json(ApiResponses::responseMessageWithData($request->all(),'Missing required parameters. Your request must have: ticket_id, message' , 500));
                }
            }

            $isTicketValid = $this->getOpenedTicketByID($request['ticket_id']);

            if(! $isTicketValid) {
                return response()->json(ApiResponses::responseMessageWithData($request->all(), 'This ticket is closed or does not exist', 500));
            }

            $ticketResponse->create($request->all());

            return response()->json(ApiResponses::responseMessage('Response save successfully', 201));
        } catch (\Exception $e) {
            if(config('app.debug')) {
                return response()->json(ApiResponses::responseMessageWithData($request->all(), $e->getMessage(), 500));
            }

            return response()->json(ApiResponses::responseMessageWithData($request->all(), 'Error saving response', 500));
        }
    }
}
